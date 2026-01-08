<center>
<table width="850" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#808080">
        <td height="22">&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Dispatch_Order_v2.0.exe</b></font></td>
    </tr>
    <tr>
        <td bgcolor="#D6D2C4" style="padding:15px;">
            <form action="<?= site_url("requisicoes/salvar") ?>" method="POST">
                
                <fieldset style="border:1px solid #808080; padding:10px; margin-bottom:15px;">
                    <legend><font face="Arial" size="1"><b>1. DESTINATION_CLIENT</b></font></legend>
                    <select name="id_cliente" required style="width:100%; font-family:'Courier New'; font-weight:bold;">
                        <option value="">-- SELECT_CLIENT --</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c->id ?>"><?= strtoupper(
    $c->nome_completo
) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>

                <fieldset style="border:1px solid #808080; padding:10px; margin-bottom:15px;">
                    <legend><font face="Arial" size="1"><b>2. ADD_ITEMS_FROM_INVENTORY</b></font></legend>
                    <table width="100%" border="0">
                        <tr>
                            <td>
                                <font face="Arial" size="1"><b>PRODUCT:</b></font><br>
                                <select id="sel_produto" style="width:100%; font-family:'Courier New';">
    <option value="">-- SELECT_ITEM --</option>
    <?php if (!empty($estoque)): ?>
        <?php foreach ($estoque as $item): ?>
    <option value="<?= $item->id ?>" 
            data-nome="<?= $item->nome_produto ?>" 
            data-sku="<?= $item->sku ?>"
            data-preco="<?= $item->valor_venda ?>"
            data-max="99999"> <?= $item->sku ?> | <?= strtoupper(
     $item->nome_produto
 ) ?> | R$ <?= number_format($item->valor_venda, 2, ",", ".") ?>
    </option>
<?php endforeach; ?>
    <?php endif; ?>
</select>
                            </td>
                            <td width="80">
                                <font face="Arial" size="1"><b>QTY:</b></font><br>
                                <input type="number" id="ipt_qtd" style="width:100%">
                            </td>
                            <td width="100" valign="bottom">
                                <button type="button" onclick="adicionarItemSaida()" style="width:100%; height:25px;"><b>[ ADD_ITEM ]</b></button>
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <tr bgcolor="#C0C0C0">
                        <td width="15%"><font face="Arial" size="1"><b>SKU</b></font></td>
                        <td width="45%"><font face="Arial" size="1"><b>PRODUCT_NAME</b></font></td>
                        <td width="15%" align="center"><font face="Arial" size="1"><b>UNIT_PR</b></font></td>
                        <td width="10%" align="center"><font face="Arial" size="1"><b>QTY</b></font></td>
                        <td width="15%" align="center"><font face="Arial" size="1"><b>CMD</b></font></td>
                    </tr>
                    <tbody id="corpo_itens">
                        </tbody>
                </table>

                <br>
                <div align="right">
                    <button type="button" onclick="window.location.href='<?= site_url(
                        "requisicoes"
                    ) ?>'"><b>[ ABORT ]</b></button>
                    <button type="submit" style="background:#000080; color:#FFF; padding:5px 20px;"><b>[ FINALIZE_REQUEST ]</b></button>
                </div>
            </form>
        </td>
    </tr>
</table>
</center>

<script>
function adicionarItemSaida() {
    const sel = document.getElementById('sel_produto');
    const idProd = sel.value;
    const opt = sel.options[sel.selectedIndex];
    
    const nomeProd = opt.getAttribute('data-nome');
    const skuProd = opt.getAttribute('data-sku');
    const precoProd = opt.getAttribute('data-preco');
    const maxQtd = parseInt(opt.getAttribute('data-max'));
    const qtd = parseInt(document.getElementById('ipt_qtd').value);

    if(!idProd || isNaN(qtd) || qtd <= 0) {
        alert("Select product and valid quantity!");
        return;
    }
    
    if(qtd > maxQtd) {
        alert("Error: Quantity exceeds stock limit (" + maxQtd + ")");
        return;
    }

    const corpo = document.getElementById('corpo_itens');
    const rowId = Date.now();

    const tr = document.createElement('tr');
    tr.id = 'row_' + rowId;
    tr.innerHTML = `
        <td><font size="2" face="Courier New">${skuProd}</font></td>
        <td><font size="2">${nomeProd}</font><input type="hidden" name="itens[id_produto][]" value="${idProd}"></td>
        <td align="right"><font size="2" face="Courier New">R$ ${precoProd}</font></td>
        <td align="center"><font size="2"><b>${qtd}</b></font><input type="hidden" name="itens[quantidade][]" value="${qtd}"></td>
        <td align="center"><button type="button" onclick="document.getElementById('row_${rowId}').remove()" style="color:red;"><b>[REMOVE]</b></button></td>
    `;
    corpo.appendChild(tr);

    document.getElementById('ipt_qtd').value = '';
    sel.value = '';
}
</script>