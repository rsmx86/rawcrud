<center>
<form action="<?= site_url('requisicoes/salvar'); ?>" method="post" id="form_saida">
    <table width="800" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>New_Outbound_Order // Picking_Request</b></font></td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:15px;">
                
                <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0">
                    <tr bgcolor="#808080">
                        <td><font face="Arial" size="2" color="#FFFFFF"><b>1. DESTINATION_CLIENT</b></font></td>
                    </tr>
                    <tr>
                        <td>
                            <font size="1">CLIENTE / DESTINATÁRIO:</font><br>
                            <select name="id_cliente" required style="width:100%">
                                <option value="">-- SELECIONE O CLIENTE --</option>
                                <?php foreach($clientes as $c): ?>
                                    <option value="<?= $c->id ?>"><?= $c->nome_completo ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0">
                    <tr bgcolor="#808080">
                        <td colspan="3"><font face="Arial" size="2" color="#FFFFFF"><b>2. ITEM_SELECTION</b></font></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <font size="1">PRODUTO (DISPONÍVEL NO CATÁLOGO):</font><br>
                            <select id="sel_produto" style="width:100%">
                                <option value="">-- SELECIONE O PRODUTO --</option>
                                <?php foreach($produtos as $p): ?>
                                    <option value="<?= $p->id ?>" data-nome="<?= $p->nome_produto ?>" data-sku="<?= $p->codigo_sku ?>">
                                        <?= $p->codigo_sku ?> - <?= $p->nome_produto ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td width="20%">
                            <font size="1">QTD SAÍDA:</font><br>
                            <input type="number" id="ipt_qtd" step="1" style="width:100%">
                        </td>
                        <td align="center" valign="bottom">
                            <button type="button" onclick="adicionarItemSaida()"><b>[ ADD ]</b></button>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" id="tabela_itens">
                    <thead>
                        <tr bgcolor="#E0E0E0">
                            <td><font size="1">SKU</font></td>
                            <td><font size="1">PRODUTO</font></td>
                            <td align="right"><font size="1">QTD REQUISITADA</font></td>
                            <td align="center"><font size="1">X</font></td>
                        </tr>
                    </thead>
                    <tbody id="corpo_itens">
                        </tbody>
                </table>

                <br>
                <div align="right">
                    <button type="submit" style="height:35px; width:200px; font-weight:bold;">[ GENERATE_PICKING_LIST ]</button>
                </div>

            </td>
        </tr>
    </table>
</form>
</center>

<script>
function adicionarItemSaida() {
    const sel = document.getElementById('sel_produto');
    const idProd = sel.value;
    const nomeProd = sel.options[sel.selectedIndex].getAttribute('data-nome');
    const skuProd = sel.options[sel.selectedIndex].getAttribute('data-sku');
    const qtd = document.getElementById('ipt_qtd').value;

    if(!idProd || qtd <= 0) {
        alert("Selecione um produto e uma quantidade válida!");
        return;
    }

    const corpo = document.getElementById('corpo_itens');
    const rowId = Date.now();

    const tr = document.createElement('tr');
    tr.id = 'row_' + rowId;
    tr.innerHTML = `
        <td><font size="2">${skuProd}</font><input type="hidden" name="itens[id_catalogo][]" value="${idProd}"></td>
        <td><font size="2">${nomeProd}</font></td>
        <td align="right"><font size="2"><b>${qtd}</b></font><input type="hidden" name="itens[quantidade][]" value="${qtd}"></td>
        <td align="center"><button type="button" onclick="document.getElementById('row_${rowId}').remove()">X</button></td>
    `;
    corpo.appendChild(tr);

    // Limpa campos
    document.getElementById('ipt_qtd').value = '';
    sel.value = '';
}
</script>