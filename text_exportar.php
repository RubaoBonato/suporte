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
$diagerado = date('d/m/Y');

function dataCorreta($data)
    {
        $vData = explode('-', $data);
        if(count($vData) == 3){
             $c = substr($vData[2],0,2).'/'.$vData[1].'/'.$vData[0];
             return $c;
        }
    }
	
//-------- exportar excel ------------

	// Nome do Arquivo do Excel que será gerado
	$arquivo = 'certificado.txt';

	// Criamos uma tabela HTML com o formato da planilha para excel
	$tabela .= "Tabela dos Certificados Ativo \r\n";
	$tabela .= "-=-=-=-=-=-=-=-=-=-=-=-=-=-=- \r\n";
	$tabela .= "Gerado: ".$diagerado." \r\n";
	$tabela .= "-=-=-=-=-=-=-=-=-= \r\n";
	$chamado = $_GET[''];
	$funcionario = $_GET[''];
	$tipo = $_GET[''];

	// Puxando dados do Banco de dados
	
	//$sql = mysql_query("SELECT DATEDIFF(c.cer_vencimento,CURRENT_DATE) AS VEN, e.emp_nome, c.cer_vencimento  FROM certificado c, empresa e where c.emp_codigo = e.emp_codigo and c.cer_ativo = 'A' order by c.cer_vencimento");
	  $sql = mysql_query("SELECT DATEDIFF(c.cer_vencimento,CURRENT_DATE) AS VEN, e.emp_nome, c.cer_vencimento, mod_descricao FROM certificado c, empresa e, modelocertificado mo where c.emp_codigo = e.emp_codigo and c.mod_codigo = mo.mod_codigo and c.cer_ativo = 'A' order by c.cer_vencimento");
	//$sql =mysql_query("SELECT ano.ano_codigo, ano.ano_data, ano.ano_chamado, fun.fun_nome, emp.emp_nome, 
	//			ano.ano_correcao, ano.ano_datacorrecao, ano.ano_tipo FROM anotacao ano, funcionario fun, empresa emp
	//			where ano.fun_codigo = fun.fun_codigo
	//			and ano.emp_codigo = emp.emp_codigo
	//			and ano.ano_chamado like ?
	//			and fun.fun_nome like ?
	//			and ano.ano_tipo like ?
	//	        order by ano.ano_codigo desc");
	while($dados = mysql_fetch_array($sql, MYSQL_ASSOC))
	{
	$sinal4 = intval(strlen($dados['emp_nome']));
	$sinal3 = 5;
	$sinal2 = (int)($sinal3 - $sinal4);
	$sinal = str_pad($dados['emp_nome'],$sinal2,"-",STR_PAD_RIGHT);
	$tabela .= $sinal." - [ ".$dados['mod_descricao']." ] - ".dataCorreta($dados['cer_vencimento'])." - ".$dados['VEN']." Dias. \r\n";
	}
	
	// Força o Download do Arquivo Gerado
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
	header('Content-type: text/plain');
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
	echo $tabela;
	//echo $tabela2;
?>