<td width="65%">
    <button onclick="window.location.href='<?= site_url('estoque') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:3px 10px; margin-bottom: 10px;">
        <font face="Arial" size="1"><b>< BACK_TO_INVENTORY</b></font>
    </button>

    <form id="form_invoice" action="<?= site_url('invoice/salvar'); ?>" method="POST">
        <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#808080">
            <tr>
                <td>
                    <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#C0C0C0">
                        <tr>
                            <td>
                                <font face="Arial" size="4"><b>Invoice_Entry // Bulk_Shipment_Processor</b></font>
                                ...

<div style="padding: 15px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
            
            <td width="65%">
                <form id="form_invoice" action="<?= site_url('invoice/salvar'); ?>" method="POST">
                    <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#808080">
                        <tr>
                            <td>
                                <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#C0C0C0">
                                    <tr>
                                        <td>
                                            <font face="Arial" size="4"><b>Invoice_Entry // Bulk_Shipment_Processor</b></font>
                                            <hr size="1" color="#808080" noshade><br>

                                            <fieldset style="border: 2px inset #FFFFFF; padding: 10px;">
                                                <legend><font face="Arial" size="2"><b>Fiscal Information</b></font></legend>
                                                <table border="0" cellpadding="4">
                                                    <tr>
                                                        <td><font face="Arial" size="2">INVOICE_#:</font></td>
                                                        <td><input type="text" name="numero_nota" id="num_nota" required style="border: 2px inset #FFF;"></td>
                                                        <td><font face="Arial" size="2">TOTAL_VALUE ($):</font></td>
                                                        <td><input type="number" step="0.01" id="valor_total_nota" name="valor_total_nota" oninput="validarTotais()" required style="border: 2px inset #FFF; font-weight:bold; color:blue;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><font face="Arial" size="2">SUPPLIER:</font></td>
                                                        <td colspan="3"><input type="text" name="fornecedor" size="40" style="border: 2px inset #FFF;"></td>
                                                    </tr>
                                                </table>
                                            </fieldset>

                                            <br>

                                            <fieldset style="border: 2px inset #FFFFFF; padding: 10px;">
                                                <legend><font face="Arial" size="2"><b>Add New Item</b></font></legend>
                                                <table border="0" cellpadding="4">
                                                    <tr>
                                                        <td><font face="Arial" size="2">PRODUCT:</font></td>
                                                        <td colspan="3">
                                                            <select id="sel_produto" style="width:100%; border: 2px inset #FFF;">
                                                                <option value="">-- Choose from Catalog --</option>
                                                                <?php foreach($produtos_catalogo as $p): ?>
                                                                    <option value="<?= $p->id ?>" data-nome="<?= $p->nome_produto ?>" data-sku="<?= $p->codigo_sku ?>">[<?= $p->codigo_sku ?>] <?= $p->nome_produto ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><font face="Arial" size="2">QTY:</font></td>
                                                        <td><input type="number" id="item_qtd" style="width:70px; border: 2px inset #FFF;"></td>
                                                        <td><font face="Arial" size="2">UNIT ($):</font></td>
                                                        <td><input type="number" step="0.01" id="item_preco" style="width:80px; border: 2px inset #FFF;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><font face="Arial" size="2">LOT_#:</font></td>
                                                        <td><input type="text" id="item_lote" style="width:100px; border: 2px inset #FFF;"></td>
                                                        <td colspan="2" align="right">
                                                            <button type="button" onclick="adicionarItem()" style="background:#C0C0C0; border: 2px solid #FFF; border-right-color:#808080; border-bottom-color:#808080; cursor:pointer; padding:5px;"><b>[ ADD_TO_LIST ]</b></button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </fieldset>

                                            <br>

                                            <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#808080" id="tabela_itens">
                                                <tr bgcolor="#C0C0C0">
                                                    <td><font face="Arial" size="2"><b>SKU</b></font></td>
                                                    <td><font face="Arial" size="2"><b>PRODUCT</b></font></td>
                                                    <td><font face="Arial" size="2"><b>QTY</b></font></td>
                                                    <td><font face="Arial" size="2"><b>UNIT</b></font></td>
                                                    <td><font face="Arial" size="2"><b>SUBTOTAL</b></font></td>
                                                    <td><font face="Arial" size="2"><b>X</b></font></td>
                                                </tr>
                                            </table>

                                            <br>

                                            <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#D6D2C4" style="border: 2px inset #FFF;">
                                                <tr>
                                                    <td><font face="Arial" size="2">TOTAL: <b>$<span id="disp_total_nota">0.00</span></b></font></td>
                                                    <td><font face="Arial" size="2">SUM: <b>$<span id="disp_soma_itens">0.00</span></b></font></td>
                                                    <td align="right">
                                                        <input type="submit" id="btn_salvar" value=" [ SAVE_INVOICE ] " disabled style="background:#C0C0C0; border: 2px solid #FFF; border-right-color:#808080; border-bottom-color:#808080; padding:10px; font-weight:bold;">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>

            <td width="2%">&nbsp;</td>

            <td width="33%">
                <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#808080">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#C0C0C0">
                                <tr>
                                    <td>
                                        <font face="Arial" size="2"><b>REGISTERED_INVOICES_LOG:</b></font>
                                        <hr size="1" color="#808080" noshade>
                                        <br>
                                        <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#808080">
                                            <tr bgcolor="#D6D2C4">
                                                <td><font face="Arial" size="1"><b>INV #</b></font></td>
                                                <td><font face="Arial" size="1"><b>DATE</b></font></td>
                                                <td><font face="Arial" size="1"><b>TOTAL</b></font></td>
                                            </tr>
                                            <?php if(empty($historico_notas)): ?>
                                                <tr bgcolor="#FFFFFF">
                                                    <td colspan="3" align="center"><font face="Arial" size="1" color="gray">No records.</font></td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach($historico_notas as $nota): ?>
    <tr bgcolor="#FFFFFF">
        <td><font face="Arial" size="2" color="blue"><u><?= $nota->numero_nota ?></u></font></td>
        <td><font face="Arial" size="1"><?= date('d/m/y', strtotime($nota->data_emissao)) ?></font></td>
        <td align="right"><font face="Arial" size="1"><b><?= number_format($nota->valor_total_nota, 2) ?></b></font></td>
        <td align="center">
            <a href="javascript:confirmarExclusao('<?= $nota->numero_nota ?>')" style="text-decoration:none;">
                <button type="button" style="background:#C0C0C0; border: 1px solid #FFF; border-right-color:#808080; border-bottom-color:#808080; cursor:pointer; padding:1px 4px; color:red; font-weight:bold;">X</button>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
                                            <?php endif; ?>
                                        </table>
                                        <br>
                                        <font face="Arial" size="1">* Last 10 entries displayed.</font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<script>
// Mantenha todo o seu código JavaScript original aqui embaixo...
let itens = [];

function adicionarItem() {
    const sel = document.getElementById('sel_produto');
    const id = sel.value;
    const nome = sel.options[sel.selectedIndex].getAttribute('data-nome');
    const sku = sel.options[sel.selectedIndex].getAttribute('data-sku');
    const qtd = parseFloat(document.getElementById('item_qtd').value);
    const preco = parseFloat(document.getElementById('item_preco').value);
    const lote = document.getElementById('item_lote').value;

    if(!id || !qtd || !preco) { alert("Fill all item fields!"); return; }

    const subtotal = qtd * preco;
    itens.push({ id, sku, nome, qtd, preco, lote, subtotal });
    atualizarTabela();
}

function removerItem(index) {
    itens.splice(index, 1);
    atualizarTabela();
}

function atualizarTabela() {
    const table = document.getElementById('tabela_itens');
    let html = '<tr bgcolor="#C0C0C0"><td><font face="Arial" size="2"><b>SKU</b></font></td><td><font face="Arial" size="2"><b>PRODUCT</b></font></td><td><font face="Arial" size="2"><b>QTY</b></font></td><td><font face="Arial" size="2"><b>UNIT</b></font></td><td><font face="Arial" size="2"><b>SUBTOTAL</b></font></td><td><font face="Arial" size="2"><b>X</b></font></td></tr>';
    let soma = 0;

    itens.forEach((it, index) => {
        soma += it.subtotal;
        html += `<tr bgcolor="#FFFFFF">
            <td><font face="Arial" size="2">${it.sku}</font></td>
            <td><font face="Arial" size="2">${it.nome} (Lot: ${it.lote})</font></td>
            <td><font face="Arial" size="2">${it.qtd}</font></td>
            <td><font face="Arial" size="2">${it.preco.toFixed(2)}</font></td>
            <td><font face="Arial" size="2">${it.subtotal.toFixed(2)}</font></td>
            <td><button type="button" onclick="removerItem(${index})">X</button></td>
            <input type="hidden" name="prod_id[]" value="${it.id}">
            <input type="hidden" name="prod_qtd[]" value="${it.qtd}">
            <input type="hidden" name="prod_lote[]" value="${it.lote}">
        </tr>`;
    });

    table.innerHTML = html;
    document.getElementById('disp_soma_itens').innerText = soma.toFixed(2);
    validarTotais();
}

function validarTotais() {
    const totalNota = parseFloat(document.getElementById('valor_total_nota').value) || 0;
    const somaItens = itens.reduce((acc, obj) => acc + obj.subtotal, 0);
    
    document.getElementById('disp_total_nota').innerText = totalNota.toFixed(2);
    
    const btn = document.getElementById('btn_salvar');
    if (Math.abs(totalNota - somaItens) < 0.01 && somaItens > 0) {
        btn.disabled = false;
        btn.style.color = "green";
    } else {
        btn.disabled = true;
        btn.style.color = "red";
    }
}

function confirmarExclusao(num) {
    if(confirm("DANGER: Are you sure you want to delete Invoice #" + num + "?\nThis will remove all its pending items from the Pull List.")) {
        window.location.href = "<?= site_url('invoice/deletar/'); ?>" + num;
    }
}


</script>