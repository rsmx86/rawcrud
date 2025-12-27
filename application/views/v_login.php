<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GARAGE 90' - PARTS DB v0.1.0</title>
</head>
<body bgcolor="#C0C0C0" text="#000000" link="#0000FF" vlink="#800080">

    <table width="100%" border="0" cellspacing="0" cellpadding="20">
        <tr>
            <td align="center">
                
                <font size="6" face="Courier New, Courier, mono">
                    <b>GARAGE 90'</b>
                </font><br>
                <font size="2" face="Arial, Helvetica, sans-serif">
                    AUTHENTIC PARTS INVENTORY SYSTEM - EST. 1994
                </font>
                
                <hr width="500" size="1" noshade color="#808080">
                <br>

                <table width="350" border="2" cellspacing="0" cellpadding="0" bgcolor="#DEDEDE" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <tr>
                        <td bgcolor="#000080" height="20">
                            &nbsp;<font color="#FFFFFF" size="2" face="Arial"><b>System Login</b></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle">
                            <br>
                            <form action="<?php echo site_url('login/autenticar'); ?>" method="POST">
                                
                                <table border="0" cellpadding="5">
                                    <tr>
                                        <td align="right"><font size="2" face="MS Sans Serif, Arial">USER_ID:</font></td>
                                        <td><input type="email" name="email" size="20" style="border: 1px inset #808080;"></td>
                                    </tr>
                                    <tr>
                                        <td align="right"><font size="2" face="MS Sans Serif, Arial">PASS_KEY:</font></td>
                                        <td><input type="password" name="senha" size="20" style="border: 1px inset #808080;"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <br>
                                            <input type="submit" value="[ EXECUTE ]" style="font-weight:bold; cursor:pointer;">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <br>
                        </td>
                    </tr>
                </table>

                <br>
                <?php if (isset($erro) && $erro == 1): ?>
                    <table border="1" cellpadding="5" bgcolor="#FF0000">
                        <tr><td><font color="#FFFFFF" size="2"><b>!! INVALID_ACCESS_DATA !!</b></font></td></tr>
                    </table>
                <?php endif; ?>

                <?php if (isset($erro) && $erro == 2): ?>
                    <table border="1" cellpadding="5" bgcolor="#FFFF00">
                        <tr><td><font color="#000000" size="2"><b>!! RESTRICTED_AREA_LOG_IN_FIRST !!</b></font></td></tr>
                    </table>
                <?php endif; ?>

                <br><br>
                <hr width="500" size="1" noshade color="#808080">
                
                <font size="1" face="Courier New">
                    SERVER_STATUS: <font color="#008000"><b>READY</b></font><br>
                    DATABASE: 127.0.0.1 (IBM DB2)<br>
                    ENCRYPTION: BCRYPT_RAW_MODE
                </font>

            </td>
        </tr>
    </table>

</body>
</html>