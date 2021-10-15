<?php
require('Base.class.php');
require('Data.class.php');

class Certificado extends Base {
    private $codigo;
    private $empresa;
	private $modelo;
	private $vencimento;
	private $ativo;
    private $erro;

	public function setAtributos($codigo, $empresa, $modelo, $vencimento, $ativo)
	{
            if ($codigo != null)
            $this->setCodigo($codigo);
            $this->setEmpresa($empresa);
			$this->setModelo($modelo);
			$this->setVencimento($vencimento);
			$this->setAtivo($ativo);
    }
	
	public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($codigo) {
        $this->codigo=$codigo;
    }

    public function getEmpresa() {
        return $this->empresa;
    }
	
    public function setEmpresa($empresa) {
        $this->empresa=$empresa;
    }
    
	public function getModelo(){
		return $this->modelo;
	}
	
	public function setModelo($modelo){
		$this->modelo=$modelo;
	}
  
  
    public function getVencimento(){
		return $this->vencimento;
	}
	
	public function setVencimento($vencimento){
		//$this->data=$data;
		if($vencimento == '')
        {
            $this->vencimento = date('d-m-Y');
        }
        else{
        $this->vencimento = $vencimento;
        $Data1 = new Data($vencimento, null, null, null);
            if($this->vencimento != null) {
                $this->erro = $this->vencimento;
                $dt = $Data1->dataInvertida();
                    if($dt != null) {
                        $this->erro = "nao gravou a data data";
                        $this->vencimento = $dt;
            }else{
                $this->vencimento = $this->vencimento;
	            }
            }
        else {
		$this->erro = $this->vencimento;

            }
        }
	}

	public function getAtivo(){
		return $this->ativo;
	}

	public function setAtivo($ativo){
		$this->ativo = $ativo;
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

   public function selecionaCertificado()
    {
        if(parent::getPdo()==null)
        {
         parent::conectar();
        }
        $selCertificado = $this->pdo->prepare("select emp_codigo, mod_codigo, cer_vencimento, cer_ativo from certificado where cer_codigo = ?");
        $selCertificado->bindValue(1,$this->getCodigo());
        if($selCertificado->execute())
        {
            $linha = $selCertificado->fetch(PDO::FETCH_ASSOC);

            $this->setEmpresa($linha['emp_codigo']);
            $this->setModelo($linha['mod_codigo']);
			$this->setVencimento($linha['cer_vencimento']);
            $this->setAtivo($linha['cer_ativo']);
			//echo 'seleciona ativo '.$linha['cer_ativo'];
			
            parent::desconectar();
            return true;
        }
        else
        {
           parent::desconectar();
           return false;
        }
    }

    public function gravaCertificado() {
        if(parent::getPdo()==null) {
            parent::conectar();
        }
        try {
            $grava = $this->pdo->prepare("insert into certificado(emp_codigo, mod_codigo, cer_vencimento, cer_ativo) values (?,?,?,?)");
            
			$grava->bindValue(1, $this->getEmpresa());
			$grava->bindValue(2, $this->getModelo());
			$grava->bindValue(3, $this->getVencimento());
			$grava->bindValue(4, $this->getAtivo());
			
			//print $this->getEmpresa().' '.$this->getModelo().' '.$this->getVencimento().' '.$this->getAtivo();
			
            if($grava->execute()) {
                $this->codigo = $this->pdo->LastInsertId();
                $this->erro = "<font color='blue'>Gravado Com Sucesso!</font>";
                parent::desconectar();
                return true;
            }
            else {
                parent::desconectar();
                $this->setErro("<font color='red'>Erro no gravar!!!</font>");
                return false;
            }
        }
        catch(PDOException $e) {
            parent::desconectar();
            $this->setErro("<font color='red'>Erro no gravar!!!</font>");
            return false;
        }

    }

    public function alteraCertificado()
    {
        if(parent::getPdo()==null)
        {
            parent::conectar();
        }
        try{
            $altera = $this->pdo->prepare("update certificado set emp_codigo = ?, mod_codigo = ?, cer_vencimento = ?, cer_ativo = ? where cer_codigo = ?");
            
			$altera->bindValue(1, $this->getEmpresa());
			$altera->bindValue(2, $this->getModelo());
			$altera->bindValue(3, $this->getVencimento());
			$altera->bindValue(4, $this->getAtivo());
			$altera->bindValue(5, $this->getCodigo());
			
			//print '<br> altera certi '. $this->getEmpresa().' '.$this->getModelo().' '.$this->getVencimento().' '.$this->getAtivo();
			
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

    public function excluiCertificado()
    {
        if(parent::getPdo()==null)
        {
            parent::conectar();
        }

        try{
            $exclui = $this->pdo->prepare("delete from certificado where cer_codigo = ?");
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
	
	public function consultaModelo()
    {
        if(parent::getPdo()==null)
        {
           parent::conectar();
        }
        $cons = $this->pdo->prepare("select mod_codigo, mod_descricao from modelocertificado order by mod_codigo");
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
	
	public function pesquisaCertificado(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        try{
                $pesq = $this->pdo->prepare('SELECT DATEDIFF(CER.cer_vencimento,CURRENT_DATE) AS VEN, cer.cer_codigo ,emp.emp_nome, mo.mod_descricao, cer_vencimento, cer_ativo FROM certificado cer, empresa emp, modelocertificado mo
											where cer.emp_codigo = emp.emp_codigo
											and cer.mod_codigo = mo.mod_codigo
											order by emp.emp_nome, mo.mod_descricao,cer_vencimento');
                if($pesq->execute()){
					print '<br><p>pesquisa -  '.$this->setEmpresa($linha['emp_codigo']).' '.$linha['mod_codigo'].' '.$linha['cer_vencimento'].' '.$linha['cer_ativo'].'</p>';
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