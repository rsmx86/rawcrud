<center>
    <br>
    <table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 3px solid #808080; border-bottom: 3px solid #808080;">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#000080">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Customer_Management_Console_v0.3.5</b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[ ? ] [ X ]</b></font>&nbsp;</td>
                    </tr>
                </table>

                <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#D6D2C4">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <font face="Arial Black" size="5" color="#000080">CUSTOMER_DATABASE</font>
                                    </td>
                                    <td align="right">
                                        <button onclick="window.location='<?= site_url('clientes/novo'); ?>'" style="width:120px; height:25px; font-family:Arial; font-size:11px; font-weight:bold; cursor:pointer; background:#C0C0C0; border: 2px solid #FFFFFF; border-right:2px solid #5A5A5A; border-bottom:2px solid #5A5A5A;">
                                            [+] NEW_ENTRY
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            
                            <hr size="1" color="#808080" noshade>
                            <br>

                            <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#808080">
                                <tr bgcolor="#C0C0C0">
                                    <td><font face="Arial" size="2"><b>ID</b></font></td>
                                    <td><font face="Arial" size="2"><b>Customer_Name</b></font></td>
                                    <td><font face="Arial" size="2"><b>Nick</b></font></td>
                                    <td><font face="Arial" size="2"><b>Car_Model</b></font></td>
                                    <td><font face="Arial" size="2"><b>Location</b></font></td>
                                    <td align="center"><font face="Arial" size="2"><b>CMD</b></font></td>
                                </tr>

                                <?php if(!empty($clientes)): ?>
                                    <?php foreach($clientes as $c): ?>
                                    <tr bgcolor="#FFFFFF">
                                        <td align="center"><font face="Courier New" size="2"><?= $c->id; ?></font></td>
                                        <td>
                                            <font face="Courier New" size="2" title="Registry Info" style="cursor: help;">
                                                <?= strtoupper($c->nome_completo); ?>
                                            </font>
                                        </td>
                                        <td><font face="Courier New" size="2"><b><?= $c->nick; ?></b></font></td>
                                        <td><font face="Courier New" size="2"><?= $c->carro_modelo; ?></font></td>
                                        <td><font face="Courier New" size="2"><?= $c->cidade_provincia; ?></font></td>
                                        
                                        <td align="center">
                                            <button onclick="window.location='<?= site_url('clientes/visualizar/'.$c->id); ?>'" style="width:60px; height:20px; font-family:Arial; font-size:10px; cursor:pointer; background:#C0C0C0; border: 1px solid #FFFFFF; border-right:1px solid #5A5A5A; border-bottom:1px solid #5A5A5A;">
                                                [OPEN]
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr bgcolor="#FFFFFF">
                                        <td colspan="6" align="center" height="50">
                                            <font face="Courier New" size="2" color="#808080">DATABASE_EMPTY: NO_RECORDS_FOUND</font>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>

                            <br>
                            <font face="Arial" size="1" color="#404040">Total Objects: <?= count($clientes); ?> entry(s) | STATUS: SELECTED</font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>