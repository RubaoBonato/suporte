<?php
require 'classes/Acesso.class.php';
$usuario = trim($_POST["usuario"]);
$senha = trim($_POST["senha"]);

if(isset($_POST["bEntrar"])){
    $Acesso = new Acesso();

	if($Acesso->setUsuario($usuario)){
		if($Acesso->setSenha($senha)){
			if($Acesso->validaUsuario() > 0 ){
				header("location:Principal.php");
				exit;
			}
		}
	}
	$erro =  $Acesso->getErro(); //"Usuario ou senha Invalida";
	header("location:index.php?msg=$erro");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
<link rel="shortcut icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" />
<link rel="icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" type="image/x-icon" />


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login:</title>

    <script type="text/javascript" src="script.js"></script>

    <link rel="stylesheet" href="css/estilo.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!-- Incluimos a biblioteca do jquery -->
<script type="text/javascript" src="js/funcao.js"></script>
<script type="text/javascript" src="js/tabenter.js"></script>
<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
<script language="javascript" type="text/javascript">
		addEvent(window, "load", iniciarMudancaDeEnterPorTab);
</script>
	
</head>
<body onload="document.index.usuario.focus()">
    <div>
            <form name="index" method="Post" Action="index.php">
            Usu&aacute;rio
            <input type="text" name="usuario" style="width: 13.8%;" /><br>
            Senha&nbsp;&nbsp;&nbsp;
            <input type="password" name="senha" style="width: 10%;" />
            <span>
                    <span class="l"> </span>
                    <span class="r"> </span>
                    <input class="art-button" type="submit" name="bEntrar" value="Entrar"/>
            </span>
			<br><br>
			<?
        print "<font color='red'>";
        $msg = $_GET["msg"];
        print $msg;
        print "</font>";
        ?>
        
            </form>
    </div>
</body>
</html>
