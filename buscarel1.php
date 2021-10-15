<?php
require('classes/Lancamento.class.php');

$Lancamento = new Lancamento();
$empresa = trim($_GET['valor']);
$Lancamento->setEmpresa($empresa);


$rs = $Lancamento->consultaUltChamadosEmpresa();

if($rs != false)
    {
    ?>
<table border='0' cellpadding='1' cellspacing='1'  width="100%" bgcolor="#E8E8E8">
<tr bgcolor="#FFD974">
<td>Codigo:</td>
<td>Empresa:</td>
<td>Funcionario:</td>
<td>Dia:</td>
</tr>
    <?php
    $cont = 0;
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
            <td <?=$cor?>><a href="buscarel1.php?cod=<?=$linha['ano_codigo']?>" ><?php print $linha['ano_codigo']) ?></a></td>
            <td <?=$cor?>><a href="buscarel1.php?cod=<?=$linha['ano_codigo']?>" ><?php print $linha['fun_nome']) ?></a></td>
            <td <?=$cor?>><a href="buscarel1.php?cod=<?=$linha['ano_codigo']?>" ><?php print $linha['emp_nome']) ?></a></td>
            <td <?=$cor?>><a href="buscarel1.php?cod=<?=$linha['ano_codigo']?>" ><?php print $linha['data']) ?></a></td>
        </tr>
    <?php
    }
    ?>
</table>
<?php
}
?>