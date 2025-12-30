<center>
<table width="98%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#000080">
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>📂 Requisitions_Explorer // C:\WMS\OUTBOUND\*.*</b></font></td>
                    <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#D6D2C4" style="padding:10px;">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td>
                        <button onclick="window.location.href='<?= site_url('requisicoes/nova'); ?>'"><b>[ NEW_REQUEST ]</b></button>
                        <button onclick="window.location.href='<?= site_url('invoices'); ?>'"><b>[ UP_DIR ]</b></button>
                    </td>
                </tr>
            </table>

            <br>

            <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <thead>
                    <tr bgcolor="#C0C0C0">
                        <td width="5%"><font face="Arial" size="1"><b>ID</b></font></td>
                        <td width="35%"><font face="Arial" size="1"><b>CLIENTE_NAME</b></font></td>
                        <td width="20%"><font face="Arial" size="1"><b>DATE_TIME</b></font></td>
                        <td width="15%" align="center"><font face="Arial" size="1"><b>STATUS</b></font></td>
                        <td width="25%" align="center"><font face="Arial" size="1"><b>ACTIONS</b></font></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($requisicoes as $r): ?>
                    <tr>
                        <td bgcolor="#F0F0F0" align="center"><font face="Courier New" size="2"><?= str_pad($r->id, 4, '0', STR_PAD_LEFT); ?></font></td>
                        <td><font face="Arial" size="2"><?= strtoupper($r->nome_cliente); ?></font></td>
                        <td><font face="Arial" size="2"><?= date('d/m/Y H:i', strtotime($r->data_requisicao)); ?></font></td>
                        <td align="center">
                            <?php if($r->status_requisicao == 'FINALIZADA'): ?>
                                <font face="Arial" size="1" color="green"><b>[ FINALIZADA ]</b></font>
                            <?php else: ?>
                                <font face="Arial" size="1" color="#808000"><b>[ EM_ABERTO ]</b></font>
                            <?php endif; ?>
                        </td>
                        <td align="center" bgcolor="#F0F0F0">
                            <button onclick="window.location.href='<?= site_url('requisicoes/detalhes/'.$r->id); ?>'" style="font-size:10px;">[ OPEN ]</button>

                            <?php if($r->status_requisicao !== 'FINALIZADA'): ?>
                                <button onclick="window.location.href='<?= site_url('requisicoes/editar/'.$r->id); ?>'" style="font-size:10px; color:blue;">[ EDIT ]</button>
                                <button onclick="if(confirm('CANCELAR REGISTRO?')) window.location.href='<?= site_url('requisicoes/deletar/'.$r->id); ?>'" style="font-size:10px; color:red;">[ DEL ]</button>
                            <?php else: ?>
                                <font face="Arial" size="1" color="#808080"><b>(LOCKED)</b></font>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <font face="Arial" size="1">Total: <?= count($requisicoes); ?> object(s) in directory.</font>

        </td>
    </tr>
</table>
</center>