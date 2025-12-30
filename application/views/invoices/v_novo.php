<center>
<form action="<?= site_url('invoices/salvar'); ?>" method="post" id="form_principal">
    <table width="850" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td colspan="2">&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Invoice_Entry_Station_v2.0</b></font></td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:15px;">
                
                <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <tr bgcolor="#808080">
                        <td colspan="4"><font face="Arial" size="2" color="#FFFFFF"><b>1. HEADER_VALIDATION</b></font></td>
                    </tr>
                    <tr>
                        <td><font size="1">Nº NOTA:</font><br><input type="text" name="numero_nota" required style="width:80px"></td>
                        <td><font size="1">EMISSÃO:</font><br><input type="date" name="data_emissao" id="data_emissao" max="<?= date('Y-m-d'); ?>" required></td>
                        <td><font size="1">FORNECEDOR:</font><br><input type="text" name="fornecedor" required style="width:200px"></td>
                        <td bgcolor="#FFFFCC">
                            <font size="1"><b>VALOR TOTAL DA NF:</b></font><br>
                            <input type="number" name="valor_total_nota" id="valor_capa" step="0.01" required style="width:120px; font-weight:bold;" oninput="validarDiferenca()">
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0">
                    <tr bgcolor="#808080">
                        <td colspan="5"><font face="Arial" size="2" color="#FFFFFF"><b>2. ITEM_INPUT_BUFFER</b></font></td>
                    </tr>
                    <tr>
                        <td width="35%">
                            <font size="1">PRODUTO (CATÁLOGO):</font><br>
                            <select id="sel_produto" style="width:100%">
                                <option value="">-- SELECIONE --</option>
                                <?php foreach($produtos_catalogo as $p): ?>
                                    <option value="<?= $p->id; ?>" data-nome="<?= $p->nome_produto; ?>" data-sku="<?= $p->codigo_sku; ?>">
                                        <?= $p->codigo_sku; ?> - <?= $p->nome_produto; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><font size="1">LOTE:</font><br><input type="text" id="ipt_lote" style="width:100px"></td>
                        <td><font size="1">QTD:</font><br><input type="number" id="ipt_qtd" step="0.01" style="width:60px"></td>
                        <td><font size="1">V. UNIT:</font><br><input type="number" id="ipt_unit" step="0.01" style="width:80px"></td>
                        <td align="center" valign="bottom">
                            <button type="button" onclick="adicionarItemBuffer()" style="height:30px; font-weight:bold;">[ ADD_ITEM ]</button>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" id="grid_itens">
                    <thead>
                        <tr bgcolor="#E0E0E0">
                            <td><font size="1">PRODUTO</font></td>
                            <td align="center"><font size="1">LOTE</font></td>
                            <td align="right"><font size="1">QTD</font></td>
                            <td align="right"><font size="1">V. UNIT</font></td>
                            <td align="right"><font size="1">V. TOTAL</font></td>
                            <td align="center"><font size="1">X</font></td>
                        </tr>
                    </thead>
                    <tbody id="corpo_itens">
                        </tbody>
                </table>

                <br>

                <table width="100%" border="2" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0">
                    <tr>
                        <td align="right" width="70%"><b>SOMA DOS ITENS:</b></td>
                        <td align="right" bgcolor="#FFFFFF" width="30%">R$ <span id="label_soma_itens">0,00</span></td>
                    </tr>
                    <tr>
                        <td align="right"><b>DIFERENÇA (PENDENTE):</b></td>
                        <td align="right" bgcolor="#FFFFFF"><font color="red"><b>R$ <span id="label_diferenca">0,00</span></b></font></td>
                    </tr>
                </table>

                <br>

                <div align="right">
                    <font face="Arial" size="1" color="#800000" id="msg_trava">
                        * O botão de salvar será habilitado apenas quando a diferença for R$ 0,00.
                    </font> &nbsp;
                    <button type="submit" id="btn_salvar" disabled style="height:40px; width:220px; font-weight:bold;">
                        [ FLASH_SAVE_DATABASE ]
                    </button>
                </div>

            </td>
        </tr>
    </table>
</form>
</center>

<script>
let totalItens = 0;

function adicionarItemBuffer() {
    const sel = document.getElementById('sel_produto');
    const idProd = sel.value;
    const nomeProd = sel.options[sel.selectedIndex].getAttribute('data-nome');
    const skuProd = sel.options[sel.selectedIndex].getAttribute('data-sku');
    const lote = document.getElementById('ipt_lote').value;
    const qtd = parseFloat(document.getElementById('ipt_qtd').value);
    const unit = parseFloat(document.getElementById('ipt_unit').value);

    if(!idProd || !lote || isNaN(qtd) || isNaN(unit)) {
        alert("Preencha todos os campos do item!");
        return;
    }

    const valorTotalItem = qtd * unit;
    const rowId = Date.now();
    const corpo = document.getElementById('corpo_itens');

    const tr = document.createElement('tr');
    tr.id = 'row_' + rowId;
    tr.innerHTML = `
        <td><font size="2">${skuProd} - ${nomeProd}</font><input type="hidden" name="itens[id_catalogo][]" value="${idProd}"></td>
        <td align="center"><font size="2">${lote}</font><input type="hidden" name="itens[lote][]" value="${lote}"></td>
        <td align="right"><font size="2">${qtd.toFixed(2)}</font><input type="hidden" name="itens[quantidade][]" value="${qtd}"></td>
        <td align="right"><font size="2">${unit.toFixed(2)}</font><input type="hidden" name="itens[valor_unitario][]" value="${unit}"></td>
        <td align="right"><font size="2"><b>${valorTotalItem.toFixed(2)}</b></font><input type="hidden" name="itens[valor_total_item][]" value="${valorTotalItem}"></td>
        <td align="center"><button type="button" onclick="removerItemBuffer('${rowId}', ${valorTotalItem})">X</button></td>
    `;
    
    corpo.appendChild(tr);
    totalItens += valorTotalItem;
    validarDiferenca();
    
    // Limpa campos de entrada
    document.getElementById('ipt_lote').value = '';
    document.getElementById('ipt_qtd').value = '';
    document.getElementById('ipt_unit').value = '';
    sel.value = '';
}

function removerItemBuffer(rowId, valor) {
    const row = document.getElementById('row_' + rowId);
    row.parentNode.removeChild(row);
    totalItens -= valor;
    validarDiferenca();
}

function validarDiferenca() {
    const valorCapa = parseFloat(document.getElementById('valor_capa').value) || 0;
    const diferenca = valorCapa - totalItens;
    
    document.getElementById('label_soma_itens').innerText = totalItens.toLocaleString('pt-br', {minimumFractionDigits: 2});
    document.getElementById('label_diferenca').innerText = Math.abs(diferenca).toLocaleString('pt-br', {minimumFractionDigits: 2});
    
    const btn = document.getElementById('btn_salvar');
    const msg = document.getElementById('msg_trava');

    // Tolerância para erros de centavos em float
    if (Math.abs(diferenca) < 0.001 && valorCapa > 0) {
        btn.disabled = false;
        btn.style.backgroundColor = "#C0C0C0";
        msg.innerHTML = "<font color='green'><b>✓ VALORES BATIDOS. PRONTO PARA SALVAR.</b></font>";
    } else {
        btn.disabled = true;
        btn.style.backgroundColor = "#E0E0E0";
        msg.innerHTML = "<font color='red'>* A SOMA DOS ITENS DEVE SER IGUAL AO VALOR DA CAPA.</font>";
    }
}
</script>