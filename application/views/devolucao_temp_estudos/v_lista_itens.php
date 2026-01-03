<center>
    <table width="98%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#008080"> <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Listing_Items // CODE: <?= $codigo_buscado ?></b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:10px;">
                
                <table width="100%" border="0" cellpadding="5">
                    <tr>
                        <td>
                            <font face="Arial" size="2">Verified at: <b><?= date('d/m/Y H:i') ?></b></font>
                        </td>
                        <td align="right">
                            <button onclick="window.location.href='<?= site_url('devolucao') ?>'"><b>[ NEW_SEARCH ]</b></button>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <thead>
                        <tr bgcolor="#C0C0C0">
                            <td><font face="Arial" size="1"><b>PRODUCT_NAME / SKU</b></font></td>
                            <td align="center"><font face="Arial" size="1"><b>BATCH (LOTE)</b></font></td>
                            <td align="center"><font face="Arial" size="1"><b>ORIGIN_ADDR</b></font></td>
                            <td align="center"><font face="Arial" size="1"><b>QTY</b></font></td>
                            <td align="center"><font face="Arial" size="1"><b>CMD</b></font></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($itens)): ?>
                            <?php foreach($itens as $item): ?>
                            <tr>
                                <td>
                                    <font face="Arial" size="2"><b><?= $item->nome_produto ?></b></font><br>
                                    <font face="Courier New" size="1">REF: <?= $item->id_catalogo ?></font>
                                </td>
                                <td align="center" bgcolor="#F0F0F0"><font face="Arial" size="2"><?= $item->lote_alocado ?></font></td>
                                <td align="center"><b><font face="Courier New" size="2" color="#000080"><?= $item->endereco_origem ?></font></b></td>
                                <td align="center"><font face="Arial" size="2"><?= $item->quantidade_pedida ?> un.</font></td>
                                <td align="center" bgcolor="#F0F0F0">
                                    <button style="color:red; font-size:10px;" 
                                            onclick="if(confirm('Devolver item para o estoque?')) window.location.href='<?= site_url('devolucao/processar_estorno/'.$item->id) ?>'">
                                        <b>[ ESTORNAR ]</b>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" align="center"><font face="Arial" size="2">EMPTY_DIRECTORY</font></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <br>
                <font face="Arial" size="1">Status: Items loaded from Dispatch_Code <?= $codigo_buscado ?>.</font>
            </td>
        </tr>
    </table>
</center>