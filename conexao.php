<?php
function conexao()
{
    $conn = @mysql_connect('localhost','root','a12345z') or die('Erro Conectando');
	if (!$conn)
	{
		print '<p>Erro ao se conectar, por favor contate o desenvolvedor do sistema!!!</p>';
		exit;
	}
	$db   = @mysql_select_db('suporte',$conn) or die('Erro Selecionando Banco');
	if (!$db)
	{
		print '<p>Banco de dados não encontrado, por favor contate o desenvolvedor do sistema!!!</p>';
		exit;
	}  
}

function desconecta()
{
	mysql_close($conn);
}
		
function injet(&$txt)
{
	$txt = str_replace('--','',$txt);
	$txt = str_replace('%','',$txt);
	$txt = str_replace('*','',$txt);
	$txt = str_replace('|','',$txt);
	$txt = str_replace('#','',$txt);
	$txt = str_replace('@','',$txt);
	$txt = str_replace('select','',$txt);
	$txt = str_replace('drop','',$txt);
	$txt = str_replace('delete','',$txt);
	$txt = str_replace('update','',$txt);
	$txt = str_replace('create','',$txt);
}
?>