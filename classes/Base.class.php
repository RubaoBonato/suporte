<?php
class Base{
	protected $pdo = null;
	
	public function conectar(){
		try{	
			$this->pdo = new PDO("mysql:host=localhost;dbname=suporte","root","a12345z", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
		}catch (PDOException $e){
			return false;
		}
	}
	
//        define (ROOT_FOLDER,$_SERVER['DOCUMENT_ROOT']);
        function __autoload ($className) {
          if (file_exists (ROOT_FOLDER.'/classes/'.$className.'.class.php')) {
            require_once (ROOT_FOLDER.'/classes/'.$className.'.class.php');
          } else {
            die ("<p><strong>ERRO no arquivo ".$SERVER["SCRIPT_URL"]."</strong> O arquivo da classe <strong>$className</strong> não foi encontrado, por favor entre em contato com o administrador do sistema para resolver este problema.</p>");
          }
        }

        public function desconectar(){
		$this->pdo = null;
	}
  
	function __construct($pdo = null){
		$this->pdo = $pdo;
		if ($this->pdo == null){
			$this->conectar();
		}
	}
	
	public function getPdo(){
		return $this->pdo;
	}
}
?>