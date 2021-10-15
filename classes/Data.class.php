<?php

class Data {
    private $data;
    private $dia;
    private $mes;
    private $ano;

    function __construct($data, $dia, $mes, $ano) {
        $this->data = $data;
        $this->dia = $dia;
        $this->mes = $mes;
        $this->ano = $ano;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        if($data != '')
        {
        $this->data = $data;
        }
        else
        {
            $this->data = null;
        }
    }

    public function getDia() {
        return $this->dia;
    }

    public function setDia($dia) {
        $this->dia = $dia;
    }

    public function getMes() {
        return $this->mes;
    }

    public function setMes($mes) {
        $this->mes = $mes;
    }

    public function getAno() {
        return $this->ano;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }
	
    public function isInteger($v) {
            return (is_numeric($v) ? intval($v+0) == $v : false);
    }
	
    public function validaData()
        {
                $a = explode("/", $this->getData());
                if (count($a) == 3) {
                        if ($this->isInteger($a[0]) && $this->isInteger($a[1]) && $this->isInteger($a[2])){
                        //mes dia ano
                                $this->setDia($a[0]);
                                $this->setMes($a[1]);
                                $this->setAno($a[2]);
                                return checkdate($a[1], $a[0], $a[2]);
                        }
                        else
                                return false;
                }
                else
                        return false;
         }

    public function dataCorreta()
    {
        $vData = explode('-', $this->getData());
        if(count($vData) == 3){
             $c = $vData[2].'/'.$vData[1].'/'.$vData[0];
             return $c;
        }
    }

    public function dataInvertida()
    {
		$a = explode("/", $this->getData());
		if(count($a) == 3){
			$b = $a[2]."-".$a[1]."-".$a[0];
			return $b;
		}
		return null;
    }

     public function dataInvertidai()
    {
		$a = str_replace("-", "", $this->getData());
                $a1 = substr($a,0,4);
                $a2 = substr($a,4,2);
                $a3 = substr($a,6,2);
                $a4 = $a1."/".$a2."/".$a3;
                $a5 = explode("/",$a4);
		if(count($a5) == 3){
			$b = $a5[2]."/".$a5[1]."/".$a5[0];
			return $b;
		}
		return null;
    }

    public function timestamp($data){
        if($this.validaData($data)){
            $d = explode("/", $data);
            return mktime(0, 0, 0, $d[1], $d[0], $d[2]);
        }
    }
   
    public function somaData()
    {
        
    }

}
?>
