<div style="padding: 15px;">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080;">
        <tr>
            <td>
                <font face="Arial" size="4"><b>Warehouse_Allocation // Invoice_Ref: <?= $nota ?></b></font><br>
                <font face="Arial" size="2" color="#404040">Defina a localização física para cada item recebido.</font>
            </td>
        </tr>
    </table>

    <br>

    <form action="<?= site_url('estoque/confirmar_alocacao') ?>" method="POST">
        <input type="hidden" name="numero_nota_ref" value="<?= $nota ?>">

        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#808080">
            <tr bgcolor="#C0C0C0">
                <td width="300"><font face="Arial" size="2"><b>ITEM_DESCRIPTION</b></font></td>
                <td width="100"><font face="Arial" size="2"><b>LOT #</b></font></td>
                <td width="80"><font face="Arial" size="2"><b>QTY</b></font></td>
                <td width="150"><font face="Arial" size="2"><b>STREET (A-Z)</b></font></td>
                <td width="150"><font face="Arial" size="2"><b>POSITION (1-10)</b></font></td>
            </tr>

            <?php if(empty($itens_nota)): ?>
            <tr bgcolor="#FFFFFF">
                <td colspan="5" align="center" style="padding:20px;">
                    <font face="Arial" size="2" color="red"><b>No pending items found for this invoice or already allocated.</b></font>
                </td>
            </tr>
            <?php else: ?>
                <?php foreach($itens_nota as $item): ?>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <font face="Arial" size="2"><?= $item->nome_produto ?></font>
                        <input type="hidden" name="id_item_nota[]" value="<?= $item->id ?>">
                        <input type="hidden" name="id_catalogo[]" value="<?= $item->id_catalogo ?>">
                    </td>
                    <td><font face="Arial" size="2"><?= $item->lote ?></font></td>
                    <td>
                        <input type="number" name="qtd[]" value="<?= $item->quantidade ?>" max="<?= $item->quantidade ?>" min="1" 
                               style="width: 60px; border: 2px inset #FFF; background: #EEE;" readonly>
                    </td>
                    <td>
                        <select name="rua[]" required style="width: 100%; border: 2px inset #FFF;">
                            <option value="">-- SELECT --</option>
                            <?php foreach(range('A', 'Z') as $letra): ?>
                                <option value="<?= $letra ?>">STREET_<?= $letra ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="posicao[]" required style="width: 100%; border: 2px inset #FFF;">
                            <option value="">-- SELECT --</option>
                            <?php for($i=1; $i<=10; $i++): ?>
                                <option value="<?= $i ?>">POSITION_<?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <br>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php if(!empty($itens_nota)): ?>
                    <input type="submit" value=" [ CONFIRM_AND_STORE_ITEMS ] " 
                           style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; font-weight:bold; padding: 10px;">
                    <?php endif; ?>
                    
                    <input type="button" value=" [ CANCEL ] " onclick="window.location.href='<?= site_url('estoque'); ?>'" 
                           style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding: 10px;">
                </td>
            </tr>
        </table>
    </form>
</div>