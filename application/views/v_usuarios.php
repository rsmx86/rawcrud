<center>
    <br>
    <table width="900" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 3px solid #808080; border-bottom: 3px solid #808080;">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#000080">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Operators_Database_Query</b></font></td>
                        <td align="right"><font face="Arial" size="1" color="#FFFFFF">[X]</font>&nbsp;</td>
                    </tr>
                </table>

                <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#D6D2C4">
                    <tr>
                        <td>
                            <font face="Arial Black" size="4">TEAM_DIRECTORY</font>
                            <hr size="1" color="#808080" noshade>
                            <br>
                            
                            <table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#FFFFFF">
                                <tr bgcolor="#C0C0C0">
                                    <td><font face="Arial" size="1"><b>ID</b></font></td>
                                    <td><font face="Arial" size="1"><b>NAME</b></font></td>
                                    <td><font face="Arial" size="1"><b>EMAIL</b></font></td>
                                    <td><font face="Arial" size="1"><b>RANK</b></font></td>
                                </tr>
                                <?php foreach($usuarios as $u): ?>
                                <tr>
                                    <td><font face="Courier New" size="3">#<?= str_pad($u->id, 3, '0', STR_PAD_LEFT); ?></font></td>
                                    <td><font face="Arial" size="2"><b><?= $u->nome . " " . $u->sobrenome; ?></b></font></td>
                                    <td><font face="Arial" size="2"><?= $u->email; ?></font></td>
                                    <td align="center">
                                        <font face="Courier New" size="3"><b>[<?= strtoupper($u->nivel); ?>]</b></font>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>

                            <br>
                            <table border="2" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                                <tr>
                                    <td>
                                        <a href="<?= site_url('usuarios/novo'); ?>" style="text-decoration:none;">
                                            <font face="Arial" size="2"><b>+ ADD_NEW_ENTRY</b></font>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>