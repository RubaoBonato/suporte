<?php
require 'classes/Acesso.class.php';


$usuario = trim($_POST["usuario"]);
$senha = trim($_POST['senha']);


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

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title>Suporte</title>

    <script type="text/javascript" src="script.js"></script>

    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->

    <script type="text/javascript" src="js/tabenter.js"></script>
    <script type="text/javascript">
            addEvent(window, "load", iniciarMudancaDeEnterPorTab);
    </script>

</head>
<body onload="document.index.usuario.focus()">
<div id="art-page-background-glare">
        <div id="art-page-background-glare-image"></div>
    </div>
    <div id="art-main">
        <div class="art-Sheet">
            <div class="art-Sheet-tl"></div>
            <div class="art-Sheet-tr"></div>
            <div class="art-Sheet-bl"></div>
            <div class="art-Sheet-br"></div>
            <div class="art-Sheet-tc"></div>
            <div class="art-Sheet-bc"></div>
            <div class="art-Sheet-cl"></div>
            <div class="art-Sheet-cr"></div>
            <div class="art-Sheet-cc"></div>
            <div class="art-Sheet-body">
                <div class="art2-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art1-menu">
                		<li>
                			<a href="#" class=""><span class="l"></span><span class="r"></span><span class="t"></span></a>
                		</li>
                		<li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t"></span></a>
                		</li>
                	</ul>
                </div>
                <div class="art-contentLayout">
                    <div class="art-sidebar1">
                        <div class="art-Block">
                            <div class="art-Block-body">
                                        <div class="art-BlockHeader">
                                            <div class="art-header-tag-icon">
                                                <div class="t">&nbsp;&nbsp;Acesso Restrito</div>
                                            </div>
                                        </div><div class="art-BlockContent">
                                            <div class="art-BlockContent-tl"></div>
                                            <div class="art-BlockContent-tr"></div>
                                            <div class="art-BlockContent-bl"></div>
                                            <div class="art-BlockContent-br"></div>
                                            <div class="art-BlockContent-tc"></div>
                                            <div class="art-BlockContent-bc"></div>
                                            <div class="art-BlockContent-cl"></div>
                                            <div class="art-BlockContent-cr"></div>
                                            <div class="art-BlockContent-cc"></div>
                                            <div class="art-BlockContent-body">
        <?
        echo "<font color='red'>";
        $msg = $_GET["msg"];
        echo $msg;
        echo "</font>";
        ?>
         <div>
            <form name="index" method="post" Action="index.php">
            Usu&aacute;rio
            <input type="text" name="usuario" style="width: 95%;" />
            Senha
            <input type="password" name="senha" style="width: 95%;" />
            <span class="art1-button-wrapper">
                    <span class="l"> </span>
                    <span class="r"> </span>
                    <input class="art1-button" type="submit" name="bEntrar" value="Entrar"/>
            </span>
            </form>
         </div>
                                        		<div class="cleared"></div>
                                            </div>
                                        </div>
                        		<div class="cleared"></div>
                            </div>
                        </div>
                        <div class="art-Block">
                            <div class="art-Block-body">
                                        <div class="art-BlockHeader">
                                            <div class="art-header-tag-icon22">
                                                <div class="t"></div>
                                            </div>
                                        </div>
                        		<div class="cleared"></div>
                            </div>
                        </div>

                    </div>
                    <div class="art-content">
                        <div class="art-Post">
                            <div class="art-Post-body">
                        <div class="art-Post-inner">
                                        <h2 class="art-PostHeader">
										 &nbsp;&nbsp;&nbsp;&nbsp;   
										 Grupo Renaer
                                        </h2>
                                        <div class="art-PostContent">
                                            <p>

											</p>
                                            <table class="table" width="100%">
                                            	<tr>
                                            		<td width="33%" valign="top">
                                            		<div class="art-Block">
                                            			<div class="art-Block-body">
                                            				<div class="art-BlockHeader">
                                                      <div class="l"></div>
                                            				  <div class="r"></div>
                                            				  <div class="t"><center>Suporte</center></div>
                                            			  </div>
                                            				<div class="art-BlockContent">
                                            					<div class="art-PostContent">
                                            						<img src="images/03.png" width="55px" height="55px" alt="an image" style="margin: 0 auto; display: block; border: 0" />
                                            						<p></p>
                                            					</div>
                                            				</div>
                                            			</div>
                                            		</div>
                                            		</td>
                                            		<td width="33%" valign="top">
                                            		<div class="art-Block">
                                            			<div class="art-Block-body">
                                            				<div class="art-BlockHeader">
                                                      <div class="l"></div>
                                            				  <div class="r"></div>
                                            				  <div class="t"><center></center></div>
                                            			  </div>
                                            				<div class="art-BlockContent">
                                            					<div class="art-PostContent">
                                            						        </div>
                                            				</div>
                                            			</div>
                                            		</div>
                                            		</td>
                                            		<td width="33%" valign="top">
                                            		<div class="art-Block">
                                            			<div class="art-Block-body">
                                                    <div class="art-BlockHeader">
                                                      <div class="l"></div>
                                            				  <div class="r"></div>
                                            				  <div class="t"><center>Certificados Digitais</center></div>
                                            			  </div>
                                            				<div class="art-BlockContent">
                                            					<div class="art-PostContent">
                                            						<img src="images/02.png" width="55px" height="55px" alt="an image" style="margin: 0 auto; display: block; border: 0" />
                                            						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Controle de Vencimentos</p>
                                            					</div>
                                            				</div>
                                            			</div>
                                            		</div>
                                            		</td>
                                            	</tr>
                                            </table>

                                        </div>
                                        <div class="cleared"></div>
                        </div>

                        		<div class="cleared"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="cleared"></div><div class="art-Footer">
                    <div class="art-Footer-inner">
                        <div class="art-Footer-text">
                            <p>Regente Feijo-SP</p>
                        </div>
                    </div>
                    <div class="art-Footer-background"></div>
                </div>
        		<div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>

    </div>
</body>
</html>