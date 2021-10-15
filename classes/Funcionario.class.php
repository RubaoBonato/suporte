<?php
require('Base.class.php');

class Funcionario extends Base {
    private $codigo;
    private $nome;
    private $empresa;
    private $ativo;
    private $erro;

    public function setAtributos($codigo, $nome, $empresa, $ativo){
            if ($cod != null)
            $this->setCodigo($codigo);
            $this->setNome($nome);
            $this->setEmpresa($empresa);
            $this->setAtivo($ativo);
    }

    public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($codigo) {
        $this->codigo=$codigo;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        if($nome != '')
            {
            $this->nome = $nome;
            return true;
            }
            else
            {
             $this->setErro("<font color='red'>preencha um nome</font>");
             return false;
            }
    }

    public function getEmpresa() {
        return $this->empresa;
    }
	
    public function setEmpresa($empresa) {
        if($empresa != '')
        {
        $this->empresa=$empresa;
        return true;
        }
        else
        {
            $this->setErro("<font color='red'>Selecione uma Empresa</font>");
            return false;
        }

    }
	
	public function getAtivo(){
		return $this->ativo;
	}
  
    public function setAtivo($ativo){
		$this->ativo=$ativo;
	}
  
    public function getErro() {
        return $this->erro;
    }
    public function setErro($erro) {
        $this->erro=$erro;
    }

    public function  __construct() {
        $this->erro='';
    }

   public function selecionaFuncionario()
    {
        if(parent::getPdo()==null)
        {
         parent::conectar();
        }
        $selFuncionario = $this->pdo->prepare("select * from funcionario where fun_codigo = ?");
        $selFuncionario->bindValue(1,$this->getCodigo());
		//print 'classe '.$this->getCodigo().'termina classe';
        if($selFuncionario->execute())
        {
            $linha = $selFuncionario->fetch(PDO::FETCH_ASSOC);

            $this->setNome($linha['FUN_NOME']);
            $this->setEmpresa($linha['EMP_CODIGO']);
            $this->setAtivo($linha['FUN_ATIVO']);
			//print_r($linha).'<br>';
			//print 'linha '.$linha['FUN_NOME'];

            parent::desconectar();
            return true;
        }
        else
        {
           parent::desconectar();
           return false;
        }
    }

    public function gravaFuncionario() {
        if(parent::getPdo()==null) {
            parent::conectar();
        }
        try {
            $grava = $this->pdo->prepare("insert into funcionario(fun_nome, emp_codigo, fun_ativo) values (?,?,?)");
            
			$grava->bindValue(1, $this->getNome());
			$grava->bindValue(2, $this->getEmpresa());
			$grava->bindValue(3, $this->getAtivo());
			

            if($grava->execute()) {
                $this->codigo = $this->pdo->LastInsertId();
                $this->erro = "<font color='blue'>Gravado Com Sucesso!</font>";
                parent::desconectar();
                return true;
            }
            else {
                parent::desconectar();
                $this->setErro("<font color='red'>Erro no Cadastro do Funcionario!!!</font>");
                return false;
            }
        }
        catch(PDOException $e) {
            parent::desconectar();
            $this->setErro("<font color='red'>Erro no Cadastro do Funcionario!!!</font>");
            return false;
        }

    }

    public function alteraFuncionario()
    {
        if(parent::getPdo()==null)
        {
            parent::conectar();
        }
        try{
            $altera = $this->pdo->prepare("UPDATE FUNCIONARIO SET FUN_NOME = ?, EMP_CODIGO = ?, FUN_ATIVO = ? WHERE FUN_CODIGO = ?");
			$altera->bindValue(1, $this->getNome());
            $altera->bindValue(2, $this->getEmpresa());
            $altera->bindValue(3, $this->getAtivo());
            $altera->bindValue(4, $this->getCodigo());
			
            if($altera->execute())
            {
				parent::desconectar();
                $this->erro="<font color='blue'>Alterado Com Sucesso</font>";
                return true;
            }
            else
                {
                parent::desconectar();
                $this->setErro("<font color='red'>Erro ao Alterar</font>");
                return false;
                }
        }catch(PDOException $e)
        {
                parent::desconectar();
                $this->setErro("<font color='red'>Erro ao Alterar</font>");
                return false;
        }
    }

    public function excluiFuncionario()
    {
        if(parent::getPdo()==null)
        {
            parent::conectar();
        }

        try{
            $exclui = $this->pdo->prepare("delete from funcionarios where fun_codigo = ?");
            $exclui->bindValue(1,$this->getCodigo());
            if($exclui->execute())
            {
                $this->setErro("<font color='blue'>Excluido com Sucesso</font>");
                parent::desconectar();
                return true;
            }
            else
            {
                $this->setErro("<font color='red'>Erro ao excluir</font>");
                parent::desconectar();
                return false;
            }
        }  catch (PDOException $ex)
        {
            $this->setErro("<font color='red'>Erro ao excluir</font>");
            parent::desconectar();
            return false;
        }

    }

	
	 public function consultaEmpresa()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
        $cons = $this->pdo->prepare("select emp_codigo, emp_nome from empresa");
        if($cons->execute())
        {
            parent::desconectar();
            return $cons;
        }
		else
       {
           parent::desconectar();
           return false;
       }
    }
	
	 public function consultaAtivo()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
        $cons = $this->pdo->prepare("select fun_ativo from funcionario where fun_codigo = ?");
		$pesq->bindValue(1,$this->getCodigo());
        if($cons->execute())
        {
            parent::desconectar();
            return $cons;
        }
		else
       {
           parent::desconectar();
           return false;
       }
    }
	
    public function pesquisaFuncionario(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('select fun.fun_codigo, fun.fun_nome, emp.emp_codigo, emp.emp_nome, fun.fun_ativo
											from funcionario fun, empresa emp
											where fun.emp_codigo = emp.emp_codigo
											and (fun.fun_nome like ?)
											order by 2,1 asc');
                $pesq->bindValue(1, "%".$this->getNome()."%");
               //$pesq->bindValue(2, "%".$this->getCodigo()."%");
                if($pesq->execute()){
                    return $pesq;
                }
                else{
					$this->erro = "nada encontrado!";
                    return false;
                }

        }
        catch(PDOException $e){
            $this->erro = "Erro na Pesquisa!!!";
            return false;
        }
    }


	
       public function qtosCad(){
        if(parent::getPdo()==null)
        {
            parent::conectar();
        }
        $qtoscadfuncionario = $this->pdo->prepare("select count(*) as tot from funcionario");
        $retorno = 0;
        if($qtosfuncionario->execute()){
            $linha = $qtoscadfuncionario->fetch(PDO::FETCH_ASSOC);
            $retorno = $linha["tot"];
        }
        return $retorno;

     }
}
?>