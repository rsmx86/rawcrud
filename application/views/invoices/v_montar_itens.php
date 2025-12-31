<table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
    <tr>
        <td width="30%"><font size="1">FORNECEDOR:</font><br><b><?= $invoice->fornecedor; ?></b></td>
        <td width="20%"><font size="1">NF NÚMERO:</font><br><b><?= $invoice->numero_nota; ?></b></td>
        <td width="25%"><font size="1">DATA EMISSÃO:</font><br><b><?= date('d/m/Y', strtotime($invoice->data_emissao)); ?></b></td>
        <td width="25%" bgcolor="#E1E1E1"><font size="1">VALOR ALVO (NF):</font><br><font color="blue"><b>R$ <?= number_format($invoice->valor_total_nota, 2, ',', '.'); ?></b></font></td>
    </tr>
</table>

<br>

<table width="100%" border="2" cellspacing="0" cellpadding="5" bgcolor="#D6D2C4" bordercolorlight="#FFFFFF" bordercolordark="#808080">
    <tr bgcolor="#808080">
        <td><font color="white" size="1"><b>ADD_NEW_ITEM_TO_INVOICE</b></font></td>
    </tr>
    <tr>
        <td>
            <form action="<?= site_url('invoices/adicionar_item_unitario'); ?>" method="post" style="margin:0;">
                <input type="hidden" name="id_invoice" value="<?= $invoice->id; ?>">

                <font size="1">PRODUTO (CATÁLOGO):</font><br>
                <select name="id_catalogo" required style="width: 40%;">
                    <option value="">-- SELECIONE O PRODUTO --</option>
                    <?php foreach($produtos_catalogo as $p): ?>
                        <option value="<?= $p->id; ?>"><?= $p->nome_produto; ?> (REF: R$ <?= number_format($p->valor_unitario, 2, ',', '.'); ?>)</option>
                    <?php endforeach; ?>
                </select>

                &nbsp;&nbsp;
                <font size="1">LOTE:</font>
                <input type="text" name="lote" required size="10">

                &nbsp;&nbsp;
                <font size="1">QUANTIDADE:</font>
                <input type="number" name="quantidade" step="0.01" required style="width:70px;">

                &nbsp;&nbsp;
                <button type="submit" style="font-weight:bold; cursor:pointer; height:25px;">[+] INSERT_PRODUCT</button>
            </form>
        </td>
    </tr>
</table>

<br>

<table width="100%" border="1" cellspacing="0" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
    <thead>
        <tr bgcolor="#808080">
            <td><font color="white" size="1">PRODUTO / SKU</font></td>
            <td align="center"><font color="white" size="1">LOTE</font></td>
            <td align="right"><font color="white" size="1">QTD</font></td>
            <td align="right"><font color="white" size="1">V. UNIT</font></td>
            <td align="right"><font color="white" size="1">V. TOTAL</font></td>
            <td align="center"><font color="white" size="1">ACTION</font></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($itens as $i): ?>
        <tr>
            <td><font size="2"><?= $i->nome_produto ?></font></td>
            <td align="center"><font size="2"><?= $i->lote ?></font></td>
            <td align="right"><font size="2"><?= number_format($i->quantidade_nota, 2, ',', '.') ?></font></td>
            <td align="right"><font size="2">R$ <?= number_format($i->valor_unitario, 2, ',', '.') ?></font></td>
            <td align="right"><font size="2"><b>R$ <?= number_format($i->valor_total_item, 2, ',', '.') ?></b></font></td>
            <td align="center" bgcolor="#F0F0F0">
                <a href="<?= site_url('invoices/remover_item/'.$i->id.'/'.$invoice->id); ?>" 
                   onclick="return confirm('Deseja realmente remover este item da nota?')"
                   style="text-decoration:none; color:red; font-weight:bold; font-size:12px;">
                   [ REMOVE ]
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if(empty($itens)): ?>
        <tr>
            <td colspan="6" align="center" height="50"><font size="2" color="gray"><i>Aguardando inclusão de produtos...</i></font></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<br>

<table width="100%" border="0">
    <tr>
        <td align="right">
            <div style="border: 2px dashed #808080; padding: 10px; background: #EEE;">
                <font face="Arial" size="2">
                    VALOR TOTAL DA NF: <b>R$ <?= number_format($invoice->valor_total_nota, 2, ',', '.'); ?></b><br>
                    SOMA DOS ITENS: <b>R$ <?= number_format($total_acumulado, 2, ',', '.'); ?></b>
                </font>
                <hr>
                <?php if(round($total_acumulado, 2) == round($invoice->valor_total_nota, 2)): ?>
                    <button onclick="window.location.href='<?= site_url('invoices/detalhes/'.$invoice->id); ?>'" 
                            style="background:green; color:white; font-weight:bold; padding:5px 20px; cursor:pointer;">
                        [ FINALIZE_CONFERENCE & ALLOCATE ]
                    </button>
                <?php else: ?>
                    <font color="red" size="1"><b>A soma dos itens deve ser igual ao valor da NF para prosseguir.</b></font>
                <?php endif; ?>
            </div>
        </td>
    </tr>
</table>