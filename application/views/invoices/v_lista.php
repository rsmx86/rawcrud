<center>

<table border="2" cellpadding="5" cellspacing="0" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer;" onclick="window.location.href='<?= site_url(
    "invoices/novo"
) ?>'">
    <tr>
        <td><font face="Arial" size="2"><b>[+] REGISTER_NEW_INVOICE</b></font></td>
    </tr>
</table>

<table width="98%" border="2" cellspacing="0" cellpadding="4" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="#FFFFFF">
    <tr bgcolor="#C0C0C0">
        <td><b><font face="Arial" size="2">ID</font></b></td>
        <td><b><font face="Arial" size="2">NÚMERO_NF</font></b></td>
        <td><b><font face="Arial" size="2">FORNECEDOR</font></b></td>
        <td><b><font face="Arial" size="2">VALOR_TOTAL</font></b></td>
        <td><b><font face="Arial" size="2">EMISSÃO</font></b></td>
        <td align="center"><b><font face="Arial" size="2">ACTIONS</font></b></td>
    </tr>
    <?php foreach ($invoices as $inv): ?>
    <tr>
        <td><font face="Arial" size="2"><?= $inv->id ?></font></td>
        <td><font face="Arial" size="2"><b><?= $inv->numero_nota ?></b></font></td>
        <td><font face="Arial" size="2"><?= $inv->fornecedor ?></font></td>
        <td><font face="Arial" size="2">R$ <?= number_format(
            $inv->valor_total_nota,
            2,
            ",",
            "."
        ) ?></font></td>
        <td><font face="Arial" size="2"><?= date(
            "d/m/Y",
            strtotime($inv->data_emissao)
        ) ?></font></td>
        <td align="center">
            <button onclick="window.location.href='<?= site_url(
                "invoices/detalhes/" . $inv->id
            ) ?>'">[ OPEN ]</button>
            <button onclick="if(confirm('Deletar Nota?')){ window.location.href='<?= site_url(
                "invoices/deletar/" . $inv->id
            ) ?>'; }">[ DELETE ]</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>


<br>

</center>