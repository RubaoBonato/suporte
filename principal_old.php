<?php
require('classes/Lancamento.class.php');
//include('menus.php');
session_start();
$hoje = date('d/m/y');
$lista = $_GET["lista"];


if (($_SESSION['login']) == "")
{
	//DESTRÓI AS SESSOES
	unset($_SESSION[login]);
	session_destroy();
	//REDIRECIONA PARA A TELA DE LOGIN
	header("location:index.php");
}

function dataCorreta($data)
    {
        $vData = explode('-', $data);
        if(count($vData) == 3){
             $c = substr($vData[2],0,2).'/'.$vData[1].'/'.$vData[0];
             return $c;
        }
    }
	 
$usuario = $_SESSION["login"];
$datainicio = $_SESSION["datainicio"];

if(isset($_POST["limpar"]))
{
	$codigo = "";
	$funcionario= "";
	$empresa = "";
	header("location:principal.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="PT-BR" xml:lang="PT">
<head>

<link rel="shortcut icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" />
<link rel="icon" href="http://10.0.0.24:8080/suporte/imagens/favicon.png" type="image/x-icon" />


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Principal</title>
<link href="css/aba.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<script type="text/javascript" src="js/jquery_min.js"></script> 
<script type="text/javascript" src="js/aba.js"></script>
<script type="text/javascript" src="js/script.js"></script>


<!-- Incluimos a biblioteca do jquery -->
<style>

		.window{
			display:none;
			width:600px;
			height:600px;
			position:absolute;
			left:0;
			top:0;
			background:#FFF;
			z-index:9900;
			padding:10px;
			border-radius:10px;
		}

		#mascara{
			position:absolute;
  			left:0;
  			top:0;
  			z-index:9000;
  			background-color:#000;
  			display:none;
		}

		.fechar{display:block; text-align:right;}

</style>

<script type="text/javascript">
$(document).ready(function(){
    $("a[rel=modal]").click( function(ev){
        ev.preventDefault();
 
        var id = $(this).attr("href");
 
        var alturaTela = $(document).height();
        var larguraTela = $(window).width();
     
        //colocando o fundo preto
        $('#mascara').css({'width':larguraTela,'height':alturaTela});
        $('#mascara').fadeIn(1000); 
        $('#mascara').fadeTo("slow",0.8);
 
        var left = ($(window).width() /2) - ( $(id).width() / 2 );
        var top = ($(window).height() / 2) - ( $(id).height() / 2 );
     
        $(id).css({'top':top,'left':left});
        $(id).show();   
    });
 
    $("#mascara").click( function(){
        $(this).hide();
        $(".window").hide();
    });
 
    $('.fechar').click(function(ev){
        ev.preventDefault();
        $("#mascara").hide();
        $(".window").hide();
    });
});
</script>

</head>
<body onload="document.principal.buscareg.focus()">
<div id="art-page-background-glare">
        <div id="art-page-background-glare-image"></div>
    </div>
 								
<div id="topo">
  <h2>Sistema de Chamados <div><?php print "<font size='1' align='right' color='blue'> Usuario: ". $usuario." - desde: ".dataCorreta($datainicio);?>.</font></div></h2>
   </div>
    <div id="conteudoEsq"> 
     <h3>Menu</h3>
			<p>
				<div>
					<li><a href='principal.php?lista=t'>[Geral]</a> <a href='principal.php?lista=d'>[Mês]</a></li>
					<li><a href='funcionario.php'>Cadastro de Funcionario</a></li>
					<li><a href='lancamento.php'>Lancamento</a></li>
					<li><a href='certificado.php'>Certificado</a></li>
					<li><a href="#janela1" rel="modal">+ Chamados</a></li>
					<li><a href='sair.php'>Sair</a></li>
				</div>
			</p>
		</br>
		</br>
		<form id="principal" name="principal"  method="post" action="">
		<a href="text_exportar.php" target="_blank" title="Exporta lista de Certificados para excel!."><strong>Certificados Ativos</strong></a>
		</br>
	<?
	$Lancamento = new Lancamento();
	$rs = $Lancamento->pesquisaCertificadoAtivo();
		if($rs != false)
			{
				print "<table border='0' cellpadding='1' cellspacing='1'  width='100%' bgcolor='#E8E8E8'>";
				while($linha = $rs->fetch(PDO::FETCH_ASSOC))
				{
					$dt=dataCorreta($linha[cer_vencimento]);
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
						if($linha["VEN"] <= 15 )
						{
							$cor = "bgcolor=#F5A9A9";
							print "<tr>";
							print "<td print $cor title=' Vencimento: $dt'><font size='1'>";
							print $linha['emp_nome'].' ['.$linha['mod_descricao'].']';
							print "</font></td>";
							print "<td  print $cor title=' Vencimento: $dt'><font size='1'>";
							print $linha["VEN"]." dias ";		
							print "</font></td>";
							print "</tr>";
						}else
						if($linha["VEN"] <= 60 )
						{
							$cor = "bgcolor=yellow";
							print "<tr>";
							print "<td print $cor title=' Vencimento: $dt'><font size='1'>";
							print $linha['emp_nome'].' ['.$linha['mod_descricao'].']';
							print "</font></td>";
							print "<td  print $cor title=' Vencimento: $dt'><font size='1'>";
							print $linha["VEN"]." dias";		
							print "</font></td>";
							print "</tr>";
						}else
						{
							print "<tr>";
							print "<td  print $cor title=' Vencimento: $dt'><font size='1'>";
							print $linha["emp_nome"].' ['.$linha['mod_descricao'].']';
							print "</font></td>";
							print "<td  print $cor title=' Vencimento: $dt'><font size='1'>";
							print $linha["VEN"]." dias ";		
							print "</font></td>";
							print "</tr>";
						}
				}
				print "</table>";
			}	
	?>
	</div>
      <div id="colEsq">
		<div id="sepEsqcolCentral">
			<!--div id="colDir"-->
				
	<div id="sepcolCentralDir">
		<div id="colCentral">
				<strong>Quantidade de Chamados por Empresa [<?php if($_GET['lista']=='t') {print "Geral";}else{print "Mês Atual";} ?>]</strong>
		 
			<div id="escrever">
				
				<?php
					$Lancamento = new Lancamento();
					
					$Lancamento->setLista($lista);
					$lan= $Lancamento->consultaLanGeral();
							
					$linha = $lan->fetchAll(PDO::FETCH_ASSOC);
				?>
				<div style="width: 100%; ">
				<?php
					$lista = $_GET['lista'];
					foreach($linha as $info){
					?>
						<div style="width: 95px; height: 90px; padding:5px; float: left;">
							<div style="background: #f4f1f1; width: 95px; height: 90px;">
								<?php print "<a href=http://10.0.0.24:8080/suporte/principal.php?porempresa=".$info['emp_codigo']."&lista=".$lista."'/><img src=imagens/".$info['empresa'].".ico widht='50' height='50' border='1' /></a><br/>[ ".$info['total']." ]"; ?>
							</div>
						</div>
						<?php 
						}
				?>
				</div> 
			</div>
		</div>
	</div>
	
	<div style="width: 990px; float: auto; padding-top:17%; ">
	<hr width='100%'>
	<strong>&nbsp;Chamados</strong>
	<input type='text' name='buscareg' id='buscareg' size='30'> 
	&nbsp;
	<strong>&nbsp;Funcionario</strong>
	<input type='text' name='buscaregfun' id='buscaregfun' size='30'> 
	&nbsp;
	<input type='submit' name='buscar' id='buscar' value='buscar'>
	&nbsp;
	<input type='submit' name='limpar' id='limpar' value='Limpar'>
	&nbsp;
	<!--input type="submit" name="pesquisar" id="pesquisar" value="Ultimas Chamadas" /-->
	<?php
		$lista = $_GET['lista'];	
		if(isset($_GET['porempresa']))
		{
			if(isset($_GET['lista']))
            {
			$porempresa = $_GET['porempresa'];
			$Lancamento = new Lancamento();
			$Lancamento->setEmpresa($porempresa);
			$Lancamento->setLista($lista);

			$rs= $Lancamento->consultaPorEmpresa();
			}
		}
		
		if(isset($_POST['buscar']))
		{
		$lista = $_GET["lista"];	
		$buscareg = $_POST['buscareg'];
		$buscaregfun = $_POST['buscaregfun'];
		$Lancamento = new Lancamento();
		$Lancamento->setChamado($buscareg);
		$Lancamento->setFuncionario($buscaregfun);
		$rs= $Lancamento->consultaLanResultado();
		}
			 if($rs != false && (isset($_GET['porempresa']) || isset($_POST['buscareg'])))
						{
						?>
						<table border='0' cellpadding='1' cellspacing='1'  width="100%" bgcolor="#E8E8E8">
						<tr bgcolor="#FFD974">
						<td>Codigo:</td>
						<td>Empresa:</td>
						<td>Chamado:</td>
						<td>Correcao:</td>
						<td>Ver</td>
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
									<td <?php print $cor ?> ><?php print $linha['ano_codigo'];?></td>
									<td <?php print $cor ?> title="<?print $linha['emp_codigo']; ?>"><?php print substr($linha['emp_nome'],0,9);?></td>
									<td <?php print $cor ?> title="<?print $linha['ano_chamado']; ?>"><?php print substr($linha['ano_chamado'],0,40);?></td>
									<td <?php print $cor ?> title="<?print $linha['ano_correcao']; ?>"><?php print substr($linha['ano_correcao'],0,40);?></td>

									<td <?php print $cor ?>><a href="lancamento.php?codigo=<?=$linha['ano_codigo'];?>&tipo=alt" > <img src="imagens/icone_editar.gif" title="Altera Lancamento"  border="0"  </a></td>
								</tr>
							<?php
							}
							?>
						</table>
						<?php
						}	
			
	  ?>
	</div>		
	

		<div class="window" id="janela1">
			<a href="#" class="fechar">X Fechar</a>
			<h4>Mais Chamados</h4>
			<!--inicio-->
			<?php
			//pega post com dados da busca
			if(isset($_POST['buscar']))

			$Lancamento = new Lancamento();
			$rs= $Lancamento->consultaFuncionarioMais();
			 if($rs != false)
						{
						?>
						<table border='0' cellpadding='1' cellspacing='1'  width='100%' bgcolor='#E8E8E8'>
						<tr bgcolor='#FFD974'>
						<td>Funcionario:</td>
						<td>Qtde Chamados</td>
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
									<td <?php print $cor ?> ><?php print $linha['FUN_NOME'];?></td>
									<td <?php print $cor ?> ><?php print $linha['QTDE'];?></td>
								</tr>
							<?php
							}
							?>
						</table>
						<?php
						}	
			
	     ?>
			<!--fim-->
		</div>

		<!-- mascara para cobrir o site -->	
		<div id="mascara"></div>
		</form>
	</div>		
       </div>
     </div>
    </div>
   <!--/div-->  
  <!--/div-->

</body>
</html>