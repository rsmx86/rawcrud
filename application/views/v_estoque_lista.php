<div style="padding: 10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
        <tr>
            <td>
                <button onclick="window.location.href='<?= site_url('invoice') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:5px;">
                    <b>[ + ] Invoice Entry</b>
                </button>
                &nbsp;
                <button onclick="window.location.href='<?= site_url('estoque/catalogo') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:5px;">
                    <b>[ 📑 ] Product Catalog</b>
                </button>
                &nbsp;
                <button onclick="window.location.href='<?= site_url('estoque/painel_saida') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:5px;">
                    <b>[ 🕊️ ] DISPATCH</b>
                </button>
                &nbsp;
                <?php if($this->session->userdata('cargo') == 'Garage Chief'): ?>
                <button onclick="window.location.href='<?= site_url('configuracoes') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:5px;">
                    <b>[ ⚙️ ] Control Panel</b>
                </button>
                <?php endif; ?>
            </td>
            <td align="right">
                <font face="Arial" size="2"><b>VIEW: PHYSICAL_STOCK</b></font>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; margin-bottom:15px;">
        <tr>
            <td>
                <font face="Arial" size="2"><b>SHIPMENT_SEARCH (Invoice #):</b></font>
                <input type="text" id="nota_busca" style="border: 2px inset #FFF; padding: 3px;" placeholder="Ex: 1010">
                <button onclick="buscarNota()" style="background:#C0C0C0; border: 2px solid #FFF; border-right-color:#808080; border-bottom-color:#808080; cursor:pointer; padding:3px 10px;">
                    <b>[ PULL_DATA ]</b>
                </button>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#808080">
        <tr bgcolor="#C0C0C0">
            <td width="15%"><font face="Arial" size="2"><b>PART_NUMBER</b></font></td>
            <td width="35%"><font face="Arial" size="2"><b>DESCRIPTION</b></font></td>
            <td width="25%"><font face="Arial" size="2"><b>WAREHOUSE LOC.</b></font></td>
            <td width="15%"><font face="Arial" size="2"><b>LOT #</b></font></td>
            <td width="10%"><font face="Arial" size="2"><b>QTY_STOCK</b></font></td>
        </tr>

        <?php if(empty($itens)): ?>
            <tr bgcolor="#FFFFFF">
                <td colspan="5" align="center" style="padding: 20px;">
                    <font face="Arial" size="2" color="gray">Stock is empty. Use <b>PULL_DATA</b> to store new items.</font>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach($itens as $i): ?>
                <?php 
                    $text_color = "#000000"; 
                    if($i->status_posicao == 'NON_COMPLIANCE') $text_color = "#0000FF"; // Azul
                    if($i->status_posicao == 'QUARANTINE') $text_color = "#FF0000";     // Vermelho
                ?>
                <tr bgcolor="#FFFFFF">
                    <td><font face="Arial" size="2" color="<?= $text_color ?>"><?= $i->codigo_produto ?></font></td>
                    <td><font face="Arial" size="2" color="<?= $text_color ?>"><?= $i->nome_produto ?></font></td>
                    <td><font face="Arial" size="2" color="<?= $text_color ?>">STREET: <b><?= $i->rua ?></b> / POS: <b><?= $i->posicao ?></b></font></td>
                    <td><font face="Arial" size="2" color="<?= $text_color ?>"><?= ($i->lote == "" || $i->lote == "N/A") ? 'none' : $i->lote ?></font></td>
                    <td align="right" bgcolor="#E8E8E8"><font face="Arial" size="2" color="<?= $text_color ?>"><b><?= $i->quantidade ?></b></font></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>