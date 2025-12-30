<center>
<table width="95%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#000080">
        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Allocation_Station // Invoice: <?= $invoice->numero_nota; ?></b></font></td>
        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" bgcolor="#D6D2C4" style="padding:15px;">
            
            <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <tr>
                    <td><font size="1">FORNECEDOR:</font><br><b><?= $invoice->fornecedor; ?></b></td>
                    <td><font size="1">DATA EMISSÃO:</font><br><b><?= date('d/m/Y', strtotime($invoice->data_emissao)); ?></b></td>
                    <td bgcolor="#E1E1E1"><font size="1">VALOR TOTAL:</font><br><b>R$ <?= number_format($invoice->valor_total_nota, 2, ',', '.'); ?></b></td>
                    <td align="center" bgcolor="#008000">
                        <font color="#FFFFFF" size="1">STATUS:</font><br>
                        <font color="#FFFFFF"><b>VALIDATED_OK</b></font>
                    </td>
                </tr>
            </table>

            <br>

            <table width="100%" border="2" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <thead>
                    <tr bgcolor="#808080">
                        <td><font color="#FFFFFF" size="1">SKU / PRODUTO</font></td>
                        <td align="center"><font color="#FFFFFF" size="1">LOTE</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">QTD TOTAL</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">ALOCADO</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">SALDO</font></td>
                        <td align="center" width="250"><font color="#FFFFFF" size="1">ALLOCATION_ACTION</font></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($itens as $item): 
                        $saldo = $item->quantidade_nota - $item->quantidade_alocada;
                    ?>
                    <tr <?php if($saldo <= 0) echo 'bgcolor="#E8FFE8"'; ?>>
                        <td><font face="Arial" size="2"><?= $item->nome_produto; ?></font></td>
                        <td align="center"><font face="Arial" size="2"><?= $item->lote; ?></font></td>
                        <td align="right"><font face="Arial" size="2"><?= number_format($item->quantidade_nota, 2, ',', '.'); ?></font></td>
                        <td align="right"><font face="Arial" size="2" color="blue"><?= number_format($item->quantidade_alocada, 2, ',', '.'); ?></font></td>
                        <td align="right">
                            <font face="Arial" size="2" color="<?= ($saldo > 0) ? 'red' : 'green'; ?>">
                                <b><?= number_format($saldo, 2, ',', '.'); ?></b>
                            </font>
                        </td>
                        <td align="center" bgcolor="#C0C0C0">
                            <?php if($saldo > 0): ?>
                                <form action="<?= site_url('invoices/confirmar_alocacao'); ?>" method="post" style="margin:0;">
                                    <input type="hidden" name="id_invoice" value="<?= $invoice->id; ?>">
                                    <input type="hidden" name="id_invoice_item" value="<?= $item->id; ?>">
                                    <input type="hidden" name="id_catalogo" value="<?= $item->id_catalogo; ?>">
                                    <input type="hidden" name="lote" value="<?= $item->lote; ?>">
                                    
                                    <select name="endereco_escolhido" required style="font-size:10px;">
                                        <option value="">-- POS --</option>
                                        <?php foreach($posicoes as $pos): ?>
                                            <option value="<?= $pos->rua.'|'.$pos->posicao; ?>"><?= $pos->rua; ?>-<?= $pos->posicao; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" name="qtd_alocar" value="<?= $saldo; ?>" max="<?= $saldo; ?>" step="0.01" style="width:45px; font-size:10px;">
                                    <button type="submit" style="font-size:10px; font-weight:bold;">[ OK ]</button>
                                </form>
                            <?php else: ?>
                                <font face="Arial" size="1" color="green"><b>STORED_COMPLETE</b></font>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <table border="0" width="100%">
                <tr>
                    <td>
                        <button onclick="window.location.href='<?= site_url('invoices'); ?>'" style="width:150px; height:25px;">&lt;&lt; BACK_TO_LIST</button>
                    </td>
                    <td align="right">
                        <button onclick="window.print()" style="width:100px; height:25px;">[PRINT_TAGS]</button>
                    </td>



                    

                </tr>
            
            <td width="28%">
                                                <table width="10%" border="2" cellspacing="0" cellpadding="1" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer;" onclick="window.location.href='<?= site_url('estoque'); ?>'">
                                                    <tr><td><font face="Arial Black" size="3">📦 STOCK_INV</font><br><font face="Arial" size="1">Gestão física</font></td></tr>
                                                
                                            </td>
            </table>

        </td>
    </tr>
</table>
</center>

