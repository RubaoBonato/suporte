<?php
require("conexao.php");
conexao();
session_start();
sdsdfdfdf
if (($_SESSION['login']) == "")
{
	//DESTRÓI AS SESSOES
	unset($_SESSION[login]);
	session_destroy();
	//REDIRECIONA PARA A TELA DE LOGIN
	header("location:index.php");
}
$diagerado = date('d/m/Y');

//-------- exportar excel ------------

	// Nome do Arquivo do Excel que será gerado
	$arquivo = 'certificado.xls';

	// Criamos uma tabela HTML com o formato da planilha para excel
	$tabela = '<table border="1">';
	$tabela .= '<tr>';
	$tabela .= '<td colspan="3">Tabela dos Certificados Ativo '.$diagerado.'</tr>';
	$tabela .= '</tr>';
	$tabela .= '<tr>';
	$tabela .= '<td><b>Empresa</b></td>';
	$tabela .= '<td><b>Vencimento</b></td>';
	$tabela .= '<td><b>Dias</b></td>';
	$tabela .= '</tr>';

	// Puxando dados do Banco de dados
	
	$sql = mysql_query("SELECT DATEDIFF(c.cer_vencimento,CURRENT_DATE) AS VEN, e.emp_nome, c.cer_vencimento FROM certificado c, empresa e where c.emp_codigo = e.emp_codigo and c.cer_ativo = 'A' order by c.cer_vencimento");
	while($dados = mysql_fetch_array($sql, MYSQL_ASSOC))
	{
	$tabela .= '<tr>';
	$tabela .= '<td>'.str_pad($dados['emp_nome'].,50, 0).'</td>';
	//$tabela .= '<td>'.$dados['emp_nome'].'</td>';
	$tabela .= '<td>'.$dados['cer_vencimento'].'</td>';
	$tabela .= '<td>'.$dados['VEN'].'</td>';
	$tabela .= '</tr>';
	}

	$tabela .= '</table>';

	// Força o Download do Arquivo Gerado
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
	//header('Content-Type: application/x-msexcel');
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
	echo $tabela;
?>