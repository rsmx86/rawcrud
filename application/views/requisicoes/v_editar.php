<center>
<form action="<?= site_url('requisicoes/atualizar'); ?>" method="post">
    <input type="hidden" name="id_requisicao" value="<?= $requisicao->id ?>">

    <table width="850" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Edit_Request // ID: #<?= $requisicao->id ?></b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:15px;">
                
                <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0">
                    <tr>
                        <td>
                            <font size="1">CLIENTE ATUAL:</font><br>
                            <input type="text" value="<?= $requisicao->nome_cliente ?>" disabled style="width:100%; background:#E0E0E0;">
                            <input type="hidden" name="id_cliente" value="<?= $requisicao->id_cliente ?>">
                        </td>
                        <td width="30%">
                            <font size="1">DATA REGISTRO:</font><br>
                            <b><?= date('d/m/Y H:i', strtotime($requisicao->data_requisicao)) ?></b>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0">
                    <tr bgcolor="#808080">
                        <td colspan="3"><font face="Arial" size="2" color="#FFFFFF"><b>ADD_MORE_ITEMS</b></font></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <font size="1">SELECIONE O PRODUTO:</font><br>
                            <select id="sel_produto" style="width:100%">
                                <option value="">-- PRODUTOS NO CATÁLOGO --</option>
                                <?php foreach($produtos as $p): ?>
                                    <option value="<?= $p->id ?>" data-nome="<?= $p->nome_produto ?>" data-sku="<?= $p->codigo_sku ?>">
                                        <?= $p->codigo_sku ?> - <?= $p->nome_produto ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td width="20%">
                            <font size="1">QTD:</font><br>
                            <input type="number" id="ipt_qtd" style="width:100%">
                        </td>
                        <td align="center" valign="bottom">
                            <button type="button" onclick="adicionarLinhaEdicao()"><b>[ ADD ]</b></button>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" id="tabela_edit">
                    <thead>
                        <tr bgcolor="#E0E0E0">
                            <td><font size="1"><b>SKU</b></font></td>
                            <td><font size="1"><b>PRODUTO</b></font></td>
                            <td align="right"><font size="1"><b>QUANTIDADE</b></font></td>
                            <td align="center" width="50"><font size="1"><b>DEL</b></font></td>
                        </tr>
                    </thead>
                    <tbody id="corpo_edit">
                        <?php foreach($itens_atuais as $item): 
                            $randId = rand(1000, 9999); ?>
                        <tr id="row_<?= $randId ?>">
                            <td bgcolor="#F0F0F0"><font size="2"><?= $item->codigo_sku ?></font>
                                <input type="hidden" name="itens[id_catalogo][]" value="<?= $item->id_catalogo ?>">
                            </td>
                            <td><font size="2"><?= $item->nome_produto ?></font></td>
                            <td align="right">
                                <input type="number" name="itens[quantidade][]" value="<?= (int)$item->quantidade_pedida ?>" style="width:60px; text-align:right;">
                            </td>
                            <td align="center">
                                <button type="button" onclick="document.getElementById('row_<?= $randId ?>').remove()" style="color:red;"><b>X</b></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <br>
                <table width="100%" border="0">
                    <tr>
                        <td>
                            <button type="button" onclick="window.location.href='<?= site_url('requisicoes') ?>'">[ CANCEL_EDIT ]</button>
                        </td>
                        <td align="right">
                            <button type="submit" style="height:30px; font-weight:bold; background-color: #C0C0C0;">[ SAVE_CHANGES_AND_RECALCULATE ]</button>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</form>
</center>

<script>
function adicionarLinhaEdicao() {
    const sel = document.getElementById('sel_produto');
    const idProd = sel.value;
    const nomeProd = sel.options[sel.selectedIndex].getAttribute('data-nome');
    const skuProd = sel.options[sel.selectedIndex].getAttribute('data-sku');
    const qtd = document.getElementById('ipt_qtd').value;

    if(!idProd || qtd <= 0) {
        alert("Preencha o produto e a quantidade corretamente!");
        return;
    }

    const corpo = document.getElementById('corpo_edit');
    const rowId = Date.now();

    const tr = document.createElement('tr');
    tr.id = 'row_' + rowId;
    tr.innerHTML = `
        <td bgcolor="#F0F0F0"><font size="2">${skuProd}</font><input type="hidden" name="itens[id_catalogo][]" value="${idProd}"></td>
        <td><font size="2">${nomeProd}</font></td>
        <td align="right"><input type="number" name="itens[quantidade][]" value="${qtd}" style="width:60px; text-align:right;"></td>
        <td align="center"><button type="button" onclick="document.getElementById('row_${rowId}').remove()" style="color:red;"><b>X</b></button></td>
    `;
    corpo.appendChild(tr);

    document.getElementById('ipt_qtd').value = '';
    sel.value = '';
}
</script>