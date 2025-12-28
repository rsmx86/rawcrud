<div style="padding: 10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
        <tr>
            <td>
                <button onclick="window.location.href='<?= site_url('estoque/novo_produto_catalogo') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:5px;">
                    <b>[ + ] Register New Part Number</b>
                </button>
                &nbsp;
                <button onclick="window.location.href='<?= site_url('estoque') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:5px;">
                    <b>[ ← ] Back to Stock_Inventory</b>
                </button>
            </td>
            <td align="right">
                <font face="Arial" size="2"><b>VIEW: MASTER_CATALOG</b></font>
            </td>
        </tr>
    </table>

   <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#808080">
    <tr bgcolor="#C0C0C0">
        <td width="15%"><font face="Arial" size="2"><b>SKU / PART_NUMBER</b></font></td>
        <td width="25%"><font face="Arial" size="2"><b>PRODUCT NAME</b></font></td>
        <td width="40%"><font face="Arial" size="2"><b>TECHNICAL INFO</b></font></td>
        <td width="20%"><font face="Arial" size="2"><b>ACTIONS</b></font></td>
    </tr>
    <?php foreach($produtos as $p): ?>
    <tr bgcolor="#D6D2C4">
        <td><font face="Arial" size="2"><b><?= $p->codigo_sku ?></b></font></td>
        <td><font face="Arial" size="2"><?= strtoupper($p->nome_produto) ?></font></td>
        <td><font face="Arial" size="2"><?= $p->descricao ?></font></td>
        <td align="center">
            <button onclick="window.location.href='<?= site_url('estoque/editar_catalogo/'.$p->id) ?>'" style="background:#C0C0C0; border: 1px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; font-size:10px;">EDIT</button>
            <button onclick="if(confirm('Delete this Part Number?')){ window.location.href='<?= site_url('estoque/eliminar_catalogo/'.$p->id) ?>' }" style="background:#C0C0C0; border: 1px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; font-size:10px; color:red;">DEL</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</div>

