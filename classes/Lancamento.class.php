<?php
require('Base.class.php');
require('Data.class.php');

class Lancamento extends Base {
    private $codigo;
    private $funcionario;
    private $empresa;
	private $chamado;
	private $correcao;
	private $data;
	private $dataCorrecao;
	private $lista;
    private $erro;
	private $tipo;

	public function setAtributos($codigo, $funcionario, $empresa, $chamado, $correcao, $data, $dataCorrecao, $lista, $tipo)
	{
            if ($codigo != null)
            $this->setCodigo($codigo);
            $this->setFuncionario($funcionario);
            $this->setEmpresa($empresa);
			$this->setChamado($chamado);
			$this->setCorrecao($correcao);
			$this->setData($data);
			$this->setDataCorrecao($dataCorrecao);
			$this->setLista($lista);
			$this->setTipo($tipo);
    }
	
	public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($codigo) {
        $this->codigo=$codigo;
    }

    public function getFuncionario() {
        return $this->funcionario;
    }
    public function setFuncionario($funcionario) {
        $this->funcionario=$funcionario;
    }

    public function getEmpresa() {
        return $this->empresa;
    }
	
    public function setEmpresa($empresa) {
        $this->empresa=$empresa;
    }
    
	public function getChamado(){
		return $this->chamado;
	}
	
	public function setChamado($chamado){
		$this->chamado=$chamado;
	}
  
    public function getCorrecao(){
		return $this->correcao;
	}
	
	public function setCorrecao($correcao){
		$this->correcao=$correcao;
	}
  
    public function getData(){
		return $this->data;
	}
	
	public function setData($data){
		//$this->data=$data;
		if($data == '')
        {
            $this->data = date('d-m-Y');
        }
        else{
        $this->data = $data;
        $Data1 = new Data($data, null, null, null);
            if($this->data != null) {
                $this->erro = $this->data;
                $dt = $Data1->dataInvertida();
                    if($dt != null) {
                        $this->erro = "nao gravou a data data";
                        $this->data = $dt;
            }else{
                $this->data = $this->data;
	            }
            }
        else {
		$this->erro = $this->data;

            }
        }
	}

	public function getDataCorrecao(){
		return $this->dataCorrecao;
	}
	
	public function setDataCorrecao($dataCorrecao){
		//$this->dataCorrecao=$dataCorrecao;
		if($dataCorrecao == '')
        {
            $this->dataCorrecao = null;
        }
        else{
        $this->dataCorrecao = $dataCorrecao;
        $Data1 = new Data($dataCorrecao, null, null, null);
            if($this->dataCorrecao != null) {
                $this->erro = $this->dataCorrecao;
                $dt = $Data1->dataInvertida();
                    if($dt != null) {
                        $this->erro = "nao gravou a data dataCorrecao";
                        $this->dataCorrecao = $dt;
            }else{
                $this->dataCorrecao = $this->dataCorrecao;
            }
            }
        else {
		$this->erro = $this->dataCorrecao;

            }
        }
	}

    public function getLista() {
        return $this->lista;
    }
    public function setLista($lista) {
        $this->lista=$lista;
    }

	 public function getTipo(){
		return $this->tipo;
	}
	
	public function setTipo($tipo){
		$this->tipo=$tipo;
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

   public function selecionaLancamento()
    {
        if(parent::getPdo()==null)
        {
         parent::conectar();
        }
        $selFuncionario = $this->pdo->prepare("select * from anotacao where ano_codigo = ?");
        $selFuncionario->bindValue(1,$this->getCodigo());
        if($selFuncionario->execute())
        {
            $linha = $selFuncionario->fetch(PDO::FETCH_ASSOC);

			$this->setData($linha['ANO_DATA']);
            $this->setChamado($linha['ANO_CHAMADO']);
            $this->setFuncionario($linha['FUN_CODIGO']);
            $this->setEmpresa($linha['EMP_CODIGO']);
            $this->setCorrecao($linha['ANO_CORRECAO']);
            $this->setDataCorrecao($linha['ANO_DATACORRECAO']);
            $this->setTipo($linha['ANO_TIPO']);
			
            parent::desconectar();
            return true;
        }
        else
        {
           parent::desconectar();
           return false;
        }
    }

    public function gravaLancamento() {
        if(parent::getPdo()==null) {
            parent::conectar();
        }
        try {
            $grava = $this->pdo->prepare("insert into anotacao(ano_data, ano_chamado, fun_codigo, emp_codigo, ano_correcao, ano_datacorrecao, ano_tipo) values (?,?,?,?,?,?,?)");
            
			$grava->bindValue(1, $this->getData());
			$grava->bindValue(2, $this->getChamado());
			$grava->bindValue(3, $this->getFuncionario());
			$grava->bindValue(4, $this->getEmpresa());
			$grava->bindValue(5, $this->getCorrecao());
			$grava->bindValue(6, $this->getDataCorrecao());
			$grava->bindValue(7, $this->getTipo());
			
            if($grava->execute()) {
                $this->codigo = $this->pdo->LastInsertId();
                $this->erro = "<font color='blue'>Gravado Com Sucesso!</font>";
                parent::desconectar();
                return true;
            }
            else {
                parent::desconectar();
                $this->setErro("<font color='red'>Erro no Lancamento!!!</font>");
                return false;
            }
        }
        catch(PDOException $e) {
            parent::desconectar();
            $this->setErro("<font color='red'>Erro no Lancamento!!!</font>");
            return false;
        }

    }

    public function alteraLancamento()
    {
        if(parent::getPdo()==null)
        {
            parent::conectar();
        }
        try{
            $altera = $this->pdo->prepare("update anotacao set ano_data = ?, ano_chamado = ?, fun_codigo = ?, emp_codigo = ?, ano_correcao = ?, ano_datacorrecao = ?, ano_tipo = ? where ano_codigo = ?");
            $altera->bindValue(1, $this->getData());
			$altera->bindValue(2, $this->getChamado());
			$altera->bindValue(3, $this->getFuncionario());
			$altera->bindValue(4, $this->getEmpresa());
			$altera->bindValue(5, $this->getCorrecao());
			$altera->bindValue(6, $this->getDataCorrecao());
			$altera->bindValue(7, $this->getTipo());
			$altera->bindValue(8, $this->getCodigo());
			
			//print 'update  anotacao set ano_data = '.$this->getData().' ,ano_chamado= '.$this->getChamado(). ', fun_codigo = '.$this->getFuncionario(). ', emp_codigo= '.$this->getEmpresa(). ', ano_correcao = '.$this->getCorrecao(). ', ano_datacorrecao= '.$this->getDataCorrecao(). ' where ano_codigo = '.$this->getCodigo();
			
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

    public function excluiLancamento()
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
        $cons = $this->pdo->prepare("select emp_codigo, emp_nome from empresa order by emp_nome");
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
	
	 public function consultaTipo()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
        $cons = $this->pdo->prepare("select tipo_codigo, tipo_nome from tipo order by tipo_nome");
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
	
	 public function consultaLanGeral()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
		$lista = $this->getLista($lista);
		if($lista == 'd')
		{
			$cons = $this->pdo->prepare("select emp.emp_codigo, emp.emp_nome as empresa, count(ano.ano_codigo) as total
			from anotacao ano, empresa emp
			where ano.emp_codigo = emp.emp_codigo
			and YEAR(ano_data) = YEAR(now())
			AND MONTH(ano_data) =  MONTH(now())
			group by ano.emp_codigo
			order by total desc");							 
		}
		else
		{							
			$cons = $this->pdo->prepare("select emp.emp_codigo, emp.emp_nome as empresa, count(ano.ano_codigo) as total  
			 from anotacao ano, empresa emp 
			 where ano.emp_codigo = emp.emp_codigo
			 group by ano.emp_codigo
			 order by total desc"); 
		}	
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

   

	 public function consultaPorEmpresa	()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
				$lista = $this->getLista($lista);
				if($lista =='d')
				{
				$cons = $this->pdo->prepare("select ano.ano_codigo, ano.ano_data, ano.ano_chamado, ano.ano_tipo ,emp.emp_codigo, emp.emp_nome, fun.fun_nome, ano.ano_correcao
										from anotacao ano, empresa emp, funcionario fun
										where ano.emp_codigo = emp.emp_codigo
										and fun.fun_codigo = ano.fun_codigo
										and emp.emp_codigo = ?
										and YEAR(ano_data) = YEAR(now())
										AND MONTH(ano_data) =  MONTH(now())
										order by ano.ano_codigo desc
										");
				}
				else{
				$cons = $this->pdo->prepare("select ano.ano_codigo, ano.ano_data, ano.ano_chamado, ano.ano_tipo ,emp.emp_codigo, emp.emp_nome, fun.fun_nome, ano.ano_correcao
										from anotacao ano, empresa emp, funcionario fun
										where ano.emp_codigo = emp.emp_codigo
										and fun.fun_codigo = ano.fun_codigo
										and emp.emp_codigo = ?
										order by ano.ano_codigo desc
										");
				}
			$cons->bindValue(1, $this->getEmpresa());	
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
   
   
	 public function consultaFuncionario()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
        $cons = $this->pdo->prepare("select fun_codigo, fun_nome, emp_codigo,fun_ativo from funcionario where fun_ativo = 'A' order by fun_nome");
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
	
	
    public function pesquisaLancamento(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('SELECT ano.ano_codigo, ano.ano_data, ano.ano_chamado, fun.fun_nome, emp.emp_nome, 
				ano.ano_correcao, ano.ano_datacorrecao, ano.ano_tipo FROM anotacao ano, funcionario fun, empresa emp
				where ano.fun_codigo = fun.fun_codigo
				and ano.emp_codigo = emp.emp_codigo
		        order by ano.ano_codigo desc
				LIMIT 20');
                //$pesq->bindValue(1, "%".$this->getNome()."%");
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
	
	
	 public function pesquisaLancamentoRel(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('SELECT ano.ano_codigo, ano.ano_data, ano.ano_chamado, fun.fun_nome, emp.emp_nome, 
				ano.ano_correcao, ano.ano_datacorrecao, ano.ano_tipo FROM anotacao ano, funcionario fun, empresa emp
				where ano.fun_codigo = fun.fun_codigo
				and ano.emp_codigo = emp.emp_codigo
				and ano.ano_chamado like ?
				and fun.fun_nome like ?
				and ano.ano_tipo like ?
		        order by ano.ano_codigo desc');

				$pesq->bindValue(1, "%".$this->getChamado()."%");
				$pesq->bindValue(2, "%".$this->getFuncionario()."%");
				$pesq->bindValue(3, "%".$this->getTipo()."%");

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
	
	
		 public function pesquisaLancamentoExporta(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('SELECT ano.ano_codigo, ano.ano_data, ano.ano_chamado, fun.fun_nome, emp.emp_nome, 
				ano.ano_correcao, ano.ano_datacorrecao, ano.ano_tipo FROM anotacao ano, funcionario fun, empresa emp
				where ano.fun_codigo = fun.fun_codigo
				and ano.emp_codigo = emp.emp_codigo
				and ano.ano_chamado like ?
				and fun.fun_nome like ?
				and ano.ano_tipo like ?
		        order by ano.ano_codigo desc');

				$pesq->bindValue(1, "%".$this->getChamado()."%");
				$pesq->bindValue(2, "%".$this->getFuncionario()."%");
				$pesq->bindValue(3, "%".$this->getTipo()."%");

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
	
	public function consultaLanResultado(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('select ano.ano_codigo,ano.ano_chamado, ano_correcao, ano_tipo, fun_nome, emp_nome
											from anotacao ano, funcionario fun, empresa emp
											where ano.fun_codigo = fun.fun_codigo
											and ano.emp_codigo = emp.emp_codigo
											and (ano.ano_chamado like ? or ano.ano_correcao like ?)
											and fun_nome like ? ');  
                $pesq->bindValue(1, "%".$this->getChamado()."%");
                $pesq->bindValue(2, "%".$this->getChamado()."%");
                $pesq->bindValue(3, "%".$this->getFuncionario()."%");

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
	

	public function pesquisaCertificadoAtivo(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('SELECT DATEDIFF(CER.cer_vencimento,CURRENT_DATE) AS VEN, cer.cer_codigo ,emp.emp_nome, mo.mod_descricao, cer.cer_vencimento, cer.cer_ativo FROM certificado cer, empresa emp, modelocertificado mo
											where cer.emp_codigo = emp.emp_codigo
											and cer.mod_codigo = mo.mod_codigo
											and cer.cer_ativo = "A"
											order by cer_vencimento');
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
	 
	 
	public function consultaUltChamadosEmpresa()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
			$cons = $this->pdo->prepare("SELECT ano.emp_codigo,emp.emp_nome, max(ano.ano_data) as data
				from anotacao ano, empresa emp
				where ano.emp_codigo = emp.emp_codigo
				group by emp_codigo
				order by data desc");
			//$pesq->bindValue(1, "%".$this->getEmpresa()."%"); and emp.emp_nome like ?
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
	 
	public function consultaEmpresaFuncionario()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
			$cons = $this->pdo->prepare("SELECT  emp.emp_nome as empresa, fun.fun_nome as nome, ano.ano_data as data ,COUNT(*) as quantidade
							FROM anotacao ano, empresa emp, funcionario fun
							where ano.emp_codigo = emp.emp_codigo
							and ano.fun_codigo = fun.fun_codigo
							GROUP BY emp.emp_codigo, fun.fun_nome, ano.ano_data
							order by ano_data desc limit 20");
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

	public function consultaFuncionarioMais()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
			$cons = $this->pdo->prepare("SELECT COUNT(*) AS QTDE, FUN_NOME
			FROM ANOTACAO ANO, FUNCIONARIO FUN
			WHERE FUN.FUN_CODIGO = ANO.FUN_CODIGO
			AND  FUN.FUN_CODIGO <> 11
			AND FUN.FUN_CODIGO <> 38
			AND FUN.FUN_ATIVO = 'A'
			GROUP BY ANO.FUN_CODIGO
			ORDER BY QTDE DESC
			LIMIT 24");
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
	
	 
	 
}
?>