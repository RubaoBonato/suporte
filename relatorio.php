<?php 
require 'classes/Lancamento.class.php';

$codigo = "";
$funcionario = "";
$empresa = "";
$chamado = "";
$correcao = "";
$data = "";
$datacorrecao = "";
$lista = "";
$tipo="";

$funcionario = trim(strtoupper($_POST["funcionario"]));
$empresa = trim($_POST["empresa"]);
$chamado = trim(strtoupper($_POST["chamado"]));
$correcao = trim($_POST["correcao"]);
$data = $_POST["data"];
$datacorrecao = $_POST["datacorrecao"];
$tipo= trim(strtoupper($_POST["tipo"]));
$lista = $GET["lista"];

function dataCorreta($datac)
    {
        $vData = explode('-', $datac);
        if(count($vData) == 3){
             $c = $vData[2].'/'.$vData[1].'/'.$vData[0];
             return $c;
        }
    }
	

if(isset($_GET["codigo"]) != null)
{
	if(isset($_GET["tipo"]) == "alt")
	{
	$codigo = trim($_GET["codigo"]);
    $Lancamento= new Lancamento();
    $Lancamento->setCodigo($codigo);
	$Lancamento->setLista($lista);

    if($Lancamento->selecionaLancamento()==true)
		{
			$codigo = $Lancamento->getCodigo();
			$data = dataCorreta(substr($Lancamento->getData(),0,10));
			$funcionario = $Lancamento->getFuncionario();
			$chamado = $Lancamento->getChamado();
			$empresa = $Lancamento->getEmpresa();
			$correcao = $Lancamento->getCorrecao();
			$datacorrecao = dataCorreta(substr($Lancamento->getDataCorrecao(),0,10));
			$tipo = $Lancamento->getTipo();
			$lista = $Lancamento->getLista();

		}else{
			$err = $Lancamento->getErro();
		}
	}
}
	
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="shortcut icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" />
<link rel="icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" type="image/x-icon" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lancamento</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<!-- Incluimos a biblioteca do jquery -->
<script type="text/javascript" src="js/funcao.js"></script>
<script type="text/javascript" src="js/tabenter.js"></script>
<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
<script language="javascript" type="text/javascript">
		addEvent(window, "load", iniciarMudancaDeEnterPorTab);
</script>
</head>

<body onload="document.lancamento.data.focus()">

 <div id="topo"> 
  <h2>Sistema de Chamados</h2>
   </div>
    <div id="conteudoEsq"> 
     <h3>Menu</h3>
			<p>
				<div>
					<li><a href='principal.php'>Principal</a></li>
					<li><a href='funcionario.php'>Cad. de Funcionario</a></li>
					<li><a href='lancamento.php'>Lancamento</a></li>
					<li><a href='certificado.php'>Certificado</a></li>
					<li><a href='relatorio.php'>Relat??rio</a></li>
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
						<h1>Relat??rio</h1>
				 
						<div id="escrever">
				<form id="lancamento" name="lancamento"  method="post" action=''>

				<div>&nbsp;Chamados</div>
				<input type='text' name='buscareg' id='buscareg' size='30'> 
				</br>
				<div>&nbsp;Funcionario</div>
				<input type='text' name='buscaregfun' id='buscaregfun' size='30'> 		
				</br>	
				</br>	
				<select name="tipo" id="tipo" width="200" value="<? print $tipo; ?>" >
				</br>
				<div>&nbsp;Tipo</div>
				</br>
				<?php
					$Empresa = new Lancamento();
					$emp= $Empresa->consultaTipo();
					$linha = $emp->fetchAll(PDO::FETCH_ASSOC);
					
						foreach($linha as $info) {
							if($info['tipo_nome'] == $tipo)
							{
								print "<option value=$info[tipo_nome] selected>" .$info['tipo_nome']; "</option>";
							}else{
								print "<option value=$info[tipo_nome]>" .$info['tipo_nome']; "</option>";
							}
							
						}						
                 ?>
				</select>
				<input type="checkbox" name='chk'>
				</br>
				</br>
				<input type='submit' value='buscar'  name='buscar'>
				<input type='' value='exporta' name='exporta'>
				 <?
				 if(isset($_POST["buscar"]))
				{
					if($pesquisar == "")
					{
					
					$checa = $_POST['chk'];
					$buscareg = $_POST['buscareg'];
					$buscaregfun = $_POST['buscaregfun'];
					$Lancamento = new Lancamento();
					$Lancamento->setChamado($buscareg);
					$Lancamento->setFuncionario($buscaregfun);
					
					if ($checa != "") 
					{
						$Lancamento->setTipo($tipo);
					}
					
					$rs = $Lancamento->pesquisaLancamentoRel();
							
					 if($rs != false)
						{
						?>
						<table border='0' cellpadding='1' cellspacing='1'  width="100%" bgcolor="#E8E8E8">
						<tr bgcolor="#FFD974">
						<td>Qtde:</td>
						<td>Data:</td>
						<td>Chamado:</td>
						<td>Funcionario:</td>
						<td>Empresa:</td>
						<td>Correcao:</td>
						<td>Tipo:</td>
						<td>Data Correcao:</td>
						<td>Alterar</td>
						<td>Excluir</td>
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
								
								?>
								<tr>
									<td <?php print $cor ?>><?php print $cont; ?></td>
									<td <?php print $cor ?>><?php print dataCorreta(substr($linha['ano_data'],0,10));?></td>
									<td <?php print $cor ?> title="<?print $linha['ano_chamado']; ?>"><?php print substr($linha['ano_chamado'],0,15);?></td>
									<td <?php print $cor ?> title="<?print $linha['fun_nome']; ?>"><?php print substr($linha['fun_nome'],0,5);?></td>
									<td <?php print $cor ?> title="<?print $linha['emp_nome']; ?>"><?php print substr($linha['emp_nome'],0,5);?></td>
									<td <?php print $cor ?> title="<?print $linha['ano_correcao']; ?>"><?php print substr($linha['ano_correcao'],0,15);?></td>
									<td <?php print $cor ?> title="<?print $linha['ano_tipo']; ?>"><?php print substr($linha['ano_tipo'],0,15);?></td>
									<td <?php print $cor ?> ><?php print dataCorreta(substr($linha['ano_datacorrecao'],0,10));?></td>
									<td <?php print $cor ?>><a href="lancamento.php?codigo=<?=$linha['ano_codigo'];?>&tipo=alt" > <img src="imagens/icone_editar.gif" title="Altera Lancamento"  border="0"  </a></td>
									<td <?php print $cor ?>><a href="lancamento.php?codigo=<?=$linha['ano_codigo'];?>&tipo=exc" > <img src="imagens/icone-excluir.gif" title="Excluir Lancamento" border="0"  </a></td>
								</tr>
							<?php
						}
							?>
						</table>
						<?php
						}
					}
				}
				
	if (isset($_POST['exporta']))
	{
		$checa = $_POST['chk'];
		$buscareg = $_POST['buscareg'];
		$buscaregfun = $_POST['buscaregfun'];
		$Lancamento = new Lancamento();
		$Lancamento->setChamado($buscareg);
		$Lancamento->setFuncionario($buscaregfun);
		
		if ($checa != "") 
		{
			$Lancamento->setTipo($tipo);
		}
		
		$rs = $Lancamento->pesquisaLancamentoExporta();
		//Arquivo txt
		$arquivo = "exporta.txt";

		//abrir arquivo txt 
		$arq = fopen($arquivo,"w");
		
		while($dados = $rs->fetch(PDO::FETCH_ASSOC))
		{
			$tabela .= $dados['ano_codigo']." - ".$dados['ano_data']." - ".$dados['ano_chamado']." - ".$dados['fun_nome']." - ".$dados['emp_nome']." - ".$dados['ano_correcao']." - ".$dados['ano_datacorrecao']." - ".$dados['ano_tipo']. "\r\n";
		}
		fwrite($arq,$tabela);
		fclose($arq);
		//echo $tabela;
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