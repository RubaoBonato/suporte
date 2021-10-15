<?php 
require 'classes/Certificado.class.php';

$codigo = "";
$empresa = "";
$modelo = "";
$vencimento = "";
$ativo = "";


$empresa = trim($_POST["empresa"]);
$modelo = trim($_POST["modelo"]);
$vencimento = $_POST["vencimento"];
if(isset($_POST[ativo])){
		$ativo = 'A';
	}else{
		$ativo = 'D';
	}

 function dataCorreta($datac)
    {
        $vData = explode('-', $datac);
        if(count($vData) == 3){
             $c = $vData[2].'/'.$vData[1].'/'.$vData[0];
             return $c;
        }
    }
	

if(isset($_POST["limpar"]))
{
	$codigo = "";
	$funcionario= "";
	$empresa = "";
	header("location:certificado.php?codigo");
}

if(isset($_POST['ativo']))
{
	$ativo = "checked";
}else{
	$ativo = "";
}	


if(isset($_GET["codigo"]) != null)
{
	if(isset($_GET["tipo"]) == "alt")
	{
	$codigo = trim($_GET["codigo"]);
	$Certificado= new Certificado();
    $Certificado->setCodigo($codigo);
	
    if($Certificado->selecionaCertificado()==true)
		{
			
			$codigo = $Certificado->getCodigo();
			
			$empresa = $Certificado->getEmpresa();
			$modelo = $Certificado->getModelo();
			$vencimento = dataCorreta(substr($Certificado->getVencimento(),0,10));
			$ativo = $Certificado->getAtivo();
			if($ativo == 'A')
			{
				$ativo = 'A';
			}else{
				$ativo = 'D';
			}
			
		}else{
			$err = $Certificado->getErro();
		}
	}
}
				

	
if(isset($_POST["gravar"]))
{
		if($codigo == "")
		{
		$Certificado = new Certificado();
		
		if(isset($_POST['ativo']))
			{
				$checado = 'A';
		}else{
				$checado = 'D';
		}	
		
		$Certificado->setAtributos($codigo, $empresa, $modelo, $vencimento, $checado);	
		if($Certificado->gravaCertificado()==true)
			{
				$codigo = $Certificado->getCodigo();
				$err= $Certificado->getErro();
			}
		}
		
		$Certificado = new Certificado();
		$codigo = trim($_POST['codigo']);
		$empresa = trim($_POST['empresa']);
		$modelo = trim($_POST['modelo']);
		$vencimento = trim($_POST['vencimento']);

		$ativo = trim($_POST['ativo']);
		
		if(isset($_POST['ativo']))
			{
				$checado = 'A';
		}else{
				$checado = 'D';
		}	
		
		$Certificado->setAtributos($codigo, $empresa, $modelo, $vencimento, $checado);
		
		if($Certificado->alteraCertificado()==true)
				{ 
					$err= $Certificado->getErro();
				}
					else{
					$err= $Certificado->getErro();
					}
}


if(isset($_GET["tipo"])=="exc")
{
	$codigo = trim($_GET["codigo"]);
    $Certificado = new Certificado();
    $Certificado->setCodigo($codigo1);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="shortcut icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" />
<link rel="icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" type="image/x-icon" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificado Digital</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!-- Incluimos a biblioteca do jquery -->
<script type="text/javascript" src="js/funcao.js"></script>
<script type="text/javascript" src="js/tabenter.js"></script>
<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
<script language="javascript" type="text/javascript">
		addEvent(window, "load", iniciarMudancaDeEnterPorTab);
</script>

</head>

<body onload="document.certificado.empresa.focus()">

 <div id="topo"> 
  <h2>Controle de Certificado Digital</h2>
   </div>
    <div id="conteudoEsq"> 
     <h3>Menu</h3>
			<p>
				<div>
					<li><a href='principal.php'>Principal</a></li>
					<li><a href='funcionario.php'>Cadastro de Funcionario</a></li>
					<li><a href='lancamento.php'>Lancamento</a></li>
					<li><a href='certificado.php'>Certificado</a></li>
					<li><a href='relatorio.php'>Relatório</a></li>
					<li><a href='sair.php'>Sair</a></li>
				</div>
			</p>
    </div>
      <div id="colEsq">
		<div id="sepEsqcolCentral">
			<div id="colDir">
				<div id="conteudoDir"> 
				<h1>Mensagem</h1>
					<div id="mensagens">
						<?php
						// Buscamos e exibimos as mensagens jcontidas no banco de dados
					
						if ($_GET["erro"] == "")
						{
							print $err;
						}else{
							$err = $_GET["erro"];
						}
						?>
					</div>
				</div>
	<div id="sepcolCentralDir">
		<div id="colCentral">
			<h1>Lancamentos</h1>
     
			<div id="escrever">
	<form id="certificado" name="certificado"  method="post" action="">

				<input name="codigo" type="hidden" id="codigo" size="6" size="6" readonly value="<?php print $codigo; ?>" />
				
				<strong>Empresa:</strong> 
				<select name="empresa" id="empresa" width="200" value="<? print $empresa; ?>" >
				<?php
					$Empresa = new Certificado();
					$emp= $Empresa->consultaEmpresa();
					$linha = $emp->fetchAll(PDO::FETCH_ASSOC);
					
						foreach($linha as $info) {
							if($info['emp_codigo'] == $empresa)
							{
								print "<option value=$info[emp_codigo] selected>" .$info['emp_nome']; "</option>";
							}else{
								print "<option value=$info[emp_codigo]>" .$info['emp_nome']; "</option>";
							}
							
						}						
                 ?>
				</select>  

				
				<strong>Modelo:</strong>
				<select name="modelo" id="modelo" value="<? print $modelo; ?>">
					<?php
					$Empresa = new Certificado();
					$emp= $Empresa->consultaModelo();
					$linha = $emp->fetchAll(PDO::FETCH_ASSOC);
					
						foreach($linha as $info) {
							if($info['mod_codigo'] == $modelo)
							{
								print "<option value=$info[mod_codigo] selected>" .$info['mod_descricao']; "</option>";
							}else{
								print "<option value=$info[mod_codigo]>" .$info['mod_descricao']; "</option>";
							}
							
						}
					?>						
				</select>
				
				<strong>Vencimento:</strong>
				
				<input name="vencimento" type="text" id="vencimento" size="11" maxlength="10" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);" value="<?php print $vencimento; ?>" />
				
				<br/>
				<br/>

				<strong>Ativo:</strong><br/>
				
				
				<?php
				if($ativo == 'A')
				{
					$checked = "checked";
				}else{
					$checked = "";
				}				
				?>
				<input name="ativo" type="checkbox" id="ativo" <? print $checked; ?> value="<?php print $ativo; ?>" />
				<br/>
				<br/>
				<?php
				if(isset($_POST[ativo])){
					print "ativo ".$ativo;
				}else{
					print "nao ativo ".$ativo;
				}
				?>
				<input type='submit' value='gravar' name='gravar' />
				&nbsp;&nbsp;
				<input type='submit' value='buscar'  name='buscar'  />
				
				&nbsp;&nbsp;
				<input type='submit' value='limpar' name='limpar' />
				
				
				 <?
				 if(isset($_POST["buscar"]))
				{	
				
					$Certificado = new Certificado();
					$rs = $Certificado->pesquisaCertificado();
				
					 if($rs != false)
						{
						?>
						<table border='0' cellpadding='1' cellspacing='1'  width="100%" bgcolor="#E8E8E8">
						<tr bgcolor="#FFD974">
						<td>Empresa:</td>
						<td>Modelo:</td>
						<td>Vencimento:</td>
						<td>Ativo:</td>
						<td>faltam (dias)</td>
						<td>Alterar</td>
						</tr>
							<?php
							while($linha = $rs->fetch(PDO::FETCH_ASSOC))
							{
								$cont++;
								$co = $cont % 2;
								if($co == 0 )
								{
									$cor = "bgcolor='#E8E8E8'";
								}
									else
									{
										$cor = "bgcolor='#C0C0C0'";
									}
								if($linha['cer_ativo'] == 'D')
								{
									$cor = "bgcolor=#F5A9A9";
								}
								if($linha['VEN'] >= 1 and $linha['VEN'] <= 20)
								{
									$cor = "bgcolor=yellow";
								}
								?>
								<tr>
									<td <?php print $cor ?> title="<?print $linha['emp_codigo']; ?>"><?php print substr($linha['emp_nome'],0,9);?></td>
									<td <?php print $cor ?> title="<?print $linha['mod_descricao']; ?>"><?php print substr($linha['mod_descricao'],0,15);?></td>
									<td <?php print $cor ?>><?php print dataCorreta(substr($linha['cer_vencimento'],0,10));?></td>
									<td <?php print $cor ?> title="<?print $linha['cer_ativo']; ?>"><?php print substr($linha['cer_ativo'],0,5);?></td>
									<td <?php print $cor ?> ><?php print substr($linha['VEN'],0,5);?></td>
									<td <?php print $cor ?>><a href="certificado.php?codigo=<?=$linha['cer_codigo'];?>&tipo=alt" > <img src="imagens/icone_editar.gif" title="Altera Certificado"  border="0"  </a></td>
														</tr>
							<?php
							}
							?>
						</table>
						<?php
						}
				}
     ?>
	</form>
	</div>		
       </div>
     </div>
    </div>
   </div>  
  </div>

</body>
</html>