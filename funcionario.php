<?php 
require 'classes/Funcionario.class.php';

$err ="";
$codigo = "";
$funcionario = trim(strtoupper($_POST["funcionario"]));
$empresa = trim($_POST["empresa"]);
$ativo = $_POST["ativo"];


if(isset($_POST["limpar"]))
{
	$codigo = "";
	$funcionario= "";
	$empresa = "";
	header("location:funcionario.php?codigo");
}



if(isset($_GET["codigo"]) != null)
{
	if(isset($_GET["tipo"]) == "alt")
	{
	$codigo = trim($_GET["codigo"]);
    $Funcionarios= new Funcionario();
    $Funcionarios->setCodigo($codigo);
	//print $codigo;
    if($Funcionarios->selecionaFuncionario()==true)
		{
			//$codigo = $Funcionario->getCodigo();
			$funcionario = $Funcionarios->getNome();
			$empresa = $Funcionarios->getEmpresa();
			$ativo = $Funcionarios->getAtivo();
			//print 'fun '.$funcionario;

		}else{
			$err = $Funcionario->getErro();
		}
	}
}
				

	
if(isset($_POST["gravar"]))
{
		
		if (isset($_POST['ativo'])=='A' && $_POST['ativo'] == 'on')
				{
					$ativo = 'A';
				}else{
					$ativo = 'D';
				}
		
		$Funcionario = new Funcionario();
		$Funcionario->setAtributos($codigo, $funcionario, $empresa, $ativo);
		
		if($codigo == "")
		{
			
			if($Funcionario->setNome($funcionario) != '')
				{
					$Funcionario->setEmpresa($empresa);

						if($Funcionario->gravaFuncionario()==true)
						{
							$codigo = $Funcionario->getCodigo();
							$err= $Funcionario->getErro();

							$codigo = "";
							$Funcionario = "";
							$empresa = "";
							$ativo="";
							
					}
					else{
						$err= "<font color='red'>selecionar uma empresa</font>";
						}
				}
				 else{
					   $err= $Funcionario->getErro();
					 }
		}else{
			
			$codigo = $_GET['codigo'];
			$funcionario = trim(strtoupper($_POST["funcionario"]));
			$empresa = $_POST["empresa"];
			$ativo = $_POST["ativo"];
			
			if (isset($_POST['ativo'])=='A' || $_POST['ativo'] == 'on')
				{
					$ativo = 'A';
				}
				else{
					$ativo = 'D';
				}
			
			$Funcionario->setAtributos($codigo, $funcionario, $empresa, $ativo);
			
			
			$Funcionario->setCodigo($codigo);
			$Funcionario->setNome($funcionario);
			$Funcionario->setEmpresa($empresa);
			$Funcionario->setAtivo($ativo);
			
			
			if($Funcionario->alteraFuncionario()==true)
			{
			$err= $Funcionario->getErro();

			$err = "";
			$codigo = "";
			$funcionario = "";
			$empresa = "";

			$err= $Funcionario->getErro();
			}
			else{
				$err= $Funcionario->getErro();
			}
			
		}
}

//--



if(isset($_GET["tipo"])=="exc")
{
	$codigo = trim($_GET["codigo"]);
    $Funcionario = new Funcionario();
    $Funcionario->setCodigo($codigo);
    if($Funcionario->excluiFuncionario()==true)
    {
        $err = "";
        $codigo = "";
        $funcionario = "";
		$empresa = "";

		$err= $Funcionario->getErro();
		header("location:funcionario.php?erro=excluido com sucesso");
		
    }else{
        $err = $Funcionario->getErro();
    }
}
//--
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="shortcut icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" />
<link rel="icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" type="image/x-icon" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro de Funcionario</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!-- Incluimos a biblioteca do jquery -->
</head>

<body onload="document.func.funcionario.focus()">

 <div id="topo"> 
  <h2>Sistema de Chamados</h2>
   </div>
    <div id="conteudoEsq"> 
     <h3>Menu</h3>
			<p>
				<div>
					<li><a href='principal.php'>Principal</a></li>
					<li><a href='funcionario.php'>Cadastro de Funcionario</a></li>
					<li><a href='lancamento.php'>Lancamento</a></li>
					<li><a href='certificado.php'>Certificado</a></li>
					<li><a href='relatorio.php'>Relatorio</a></li>
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
						// Buscamos e exibimos as mensagens já contidas no banco de dados
					
						$err = "<font color='blue'>".$_GET["erro"]."</font>";
						print "<font size='3'>".$err."</font>";
						?>
					</div>
				</div>
	<div id="sepcolCentralDir">
		<div id="colCentral"  style="text-align:justify">
			<h1>Cadastro de Funcionario</h1>
     
			<div id="escrever">
	<form id="func" name="func"  method="post" action="">

				<strong>Nome &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  / Empresa:</strong> <br />
				<input name="codigo" type="hidden" id="codigo" size="6" size="6" readonly value="<?php print $codigo; ?>" />
				<input name="funcionario" type="text" id="funcionario" size="60" maxlength="50" value="<?php print $funcionario; ?>" />
				
				
				
			 <select name="empresa" id="empresa" width="30" value="<?php print $empresa; ?>">
               <?php
				$Empresa = new Funcionario();
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
				<?php
				if($ativo == "A"){
					//print "novo : ".$ativo;
					$checked = "checked";
				}
				else{
					$checked = '';
				}		
				?>
			
			[ Ativo	
			<input name="ativo" type="checkbox" id="ativo" <? print  $checked; ?> value="<? print $ativo; ?>" />]
				<?php
				if($ativo == "A"){
					//print "novo : ".$ativo;
					$checked = "checked";
				}
				else{
					$checked = '';
				}		
				?>
				
				<input type='submit' value='gravar' name='gravar' />
				&nbsp;&nbsp;
				<input type='submit' value='buscar' name='buscar' />
				
				&nbsp;&nbsp;
				<input type='submit' value='limpar' name='limpar' />
				
				
				 <?
				 if(isset($_POST["buscar"]))
				{
					$Funcionario = new Funcionario();
					
					$codigo = trim($_POST['codigo']);
					$fun = trim($_POST['funcionario']);
					$Funcionario->setNome($fun);
					$Funcionario->setCodigo($codigo);
					$rs = $Funcionario->pesquisaFuncionario();
					
					
					if($rs != false)
						{
						?>
						<table border='0' cellpadding='1' cellspacing='1'  width="100%" bgcolor="#E8E8E8">
						<tr bgcolor="#FFD974">
						<td>Codigo:</td>
						<td>Nome:</td>
						<td>Empresa:</td>
						<td>Ativo</td>
						<td>Alterar</td>
						<td>Excluir</td>

						</tr>
							<?php
							while($linha = $rs->fetch(PDO::FETCH_ASSOC))
							{
								?>
								<tr>
									<td><?php print $linha['fun_codigo'];?></td>
									<td><?php print $linha['fun_nome'];?></td>
									<td><?php print $linha['emp_nome'];?></td>
									<td><?php print $linha['fun_ativo'];?></td>
									<td><a href="funcionario.php?codigo=<?=$linha['fun_codigo'];?>&tipo=alt&funcionario<?=$linha['fun_nome'];?>" > <img src="imagens/icone_editar.gif" title="Altera Cadastro" border="0"  </a></td>
									<td><a href="funcionario.php?codigo=<?=$linha['fun_codigo'];?>&tipo=exc" > <img src="imagens/icone-excluir.gif" title="Excluir Cadastro" border="0"  </a></td>
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