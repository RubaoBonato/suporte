<?php
require 'classes/Base.class.php';
//require('Data.class.php');

class Acesso extends Base {
    private $usuario;
    private $senha;
    private $data;
    private $erro;
    private $codigo;

    public function  __construct() {
        $this->erro= '';
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getData(){
        return $this->data;
    }

    public function getErro(){
        return $this->erro;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setUsuario($usuario){
		if($usuario != ''){
			$this->usuario=$usuario;
			return true;
		}
		else{
			$this->setErro('Digite o Usuario.');
			return false;
		}
        
    }
    public function setSenha($senha) {
		if($senha != ''){
			$this->senha = md5($senha);
			return true;
		}
		else{
			$this->setErro('Digite sua Senha.');
			return false;
		}
        
    }

    public function setData($data){
        $this->data=$data;
    }
    
    public function setErro($erro) {
        $this->erro = $erro;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function validaUsuario(){
        if(parent::getPdo()==null)
        {
         parent::conectar();
        }

        $verifica = $this->pdo->prepare("select count(*), usu_codigo
                                            from acesso
                                                where usu_usuario = ?
                                                    and usu_senha =?
                                            group by usu_codigo");
        $verifica->execute(array($this->getUsuario(),$this->getSenha()));
        $ver = $verifica->fetch(PDO::FETCH_NUM);

        if($ver[0] > 0)
        {
            parent::desconectar();
            $this->setCodigo($ver[1]);
            session_start();
            $_SESSION["login"] = $this->getTudo();
            return 1;
           
         }
         if($ver[0] == 0)
            {
            parent::desconectar();
            $this->SetErro("Usuário ou Senha Inválido.");
            return 0;
           }
    }

    public function getTudo(){
        if(parent::getPdo() == null){
            parent::conectar();
        }
        
        try{
            $retorna = $this->pdo->prepare('select * from acesso where usu_codigo = ?');
            if($retorna->execute(array($this->getCodigo()))){
                $linha = $retorna->fetch(PDO::FETCH_ASSOC);
                if($linha['usu_codigo'] > 0){
                    parent::desconectar();
                    //$Data = new Data($linha['usu_data'], null, null, null);
                    //return $this->getUsuario() ." - ". $Data->dataCorreta();;
					$_SESSION["codigo"]= $linha["usu_codigo"];
					$_SESSION["datainicio"]= $linha["usu_data"];
				}
					else{
					}
                    return $this->getUsuario(); //." Nivel ".$nivelt;
            }
        }
        catch(PDOException $ex){
            $e = $ex->getMessage();
            $this->setErro('Fatal Erros...');
            return false;
        }
    }
}
?>