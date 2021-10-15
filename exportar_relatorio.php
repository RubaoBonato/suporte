<?php
require("conexao.php");
conexao();
session_start();

if (($_SESSION['login']) == "")
{
	//DESTRÓI AS SESSOES
	unset($_SESSION[login]);
	session_destroy();
	//REDIRECIONA PARA A TELA DE LOGIN
	header("location:index.php");
}
		function dataCorreta($datac)
		{
			$vData = explode('-', $datac);
			if(count($vData) == 3){
				 $c = $vData[2].'/'.$vData[1].'/'.$vData[0];
				 return $c;
			}
		}
		
		$buscareg= $_GET['buscareg'];
		$buscaregfun= $_GET['buscaregfun'];
		$tipo= $_GET['tipo'];
		print $buscareg." - " .$buscaregfun. " - " .$tipo;
		
		
		$diagerado = date('d/m/Y');

		//-------- exportar excel ------------

		// Nome do Arquivo do Excel que será gerado
		$arquivo = 'relatorio.txt';
		// Puxando dados do Banco de dados
		$sql =mysql_query("SELECT ano.ano_codigo, ano.ano_data, ano.ano_chamado, fun.fun_nome, emp.emp_nome, 
				ano.ano_correcao, ano.ano_datacorrecao, ano.ano_tipo FROM anotacao ano, funcionario fun, empresa emp
				where ano.fun_codigo = fun.fun_codigo
				and ano.emp_codigo = emp.emp_codigo
				and ano.ano_chamado like '%%'
				and fun.fun_nome like '%%'
				and ano.ano_tipo like '%DOMINIO%'
		        order by ano.ano_codigo");
		
		
		
		while($dados = mysql_fetch_array($sql, MYSQL_ASSOC))
		{
			$tabela .= $dados['ano_codigo']." - ".$dados['ano_data']." - ".$dados['ano_chamado']." - ".$dados['fun_nome']." - ".$dados['emp_nome']." - ".$dados['ano_correcao']." - ".$dados['ano_datacorrecao']." - ".$dados['ano_tipo']. "\r\n";
		}
		print $tipo;
		// Força o Download do Arquivo Gerado
		header ('Cache-Control: no-cache, must-revalidate');
		header ('Pragma: no-cache');
		header('Content-type: text/plain');
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		echo $tabela;	
?>