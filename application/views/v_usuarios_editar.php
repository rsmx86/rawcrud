<center>
    <br><br>
    <table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 3px solid #808080; border-bottom: 3px solid #808080;">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#000080">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Edit Operator Profile: [ID #<?= $usuario->id ?>]</b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                    </tr>
                </table>

                <form action="<?= site_url('usuarios/atualizar'); ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $usuario->id ?>">

                    <table width="100%" border="0" cellpadding="25" cellspacing="0" bgcolor="#D6D2C4">
                        <tr>
                            <td>
                                <font face="Arial Black" size="5" color="#000080">UPDATE_OPERATOR_DATA</font>
                                <hr size="1" color="#808080" noshade>
                                <br>
                                
                                <table width="100%" border="0" cellspacing="10" cellpadding="0">
                                    <tr>
                                        <td width="30%"><font face="Arial" size="3"><b>First_Name:</b></font></td>
                                        <td><input type="text" name="nome" value="<?= $usuario->nome ?>" required style="width:100%; font-family: 'Courier New'; font-size:16px; border:2px inset #FFFFFF; padding:4px; background: #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Last_Name:</b></font></td>
                                        <td><input type="text" name="sobrenome" value="<?= $usuario->sobrenome ?>" required style="width:100%; font-family: 'Courier New'; font-size:16px; border:2px inset #FFFFFF; padding:4px; background: #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Operator_Nick:</b></font></td>
                                        <td><input type="text" name="nick" value="<?= $usuario->nick ?>" required style="width:100%; font-family: 'Courier New'; font-size:16px; border:2px inset #FFFFFF; padding:4px; background: #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Access_Email:</b></font></td>
                                        <td><input type="email" name="email" value="<?= $usuario->email ?>" required style="width:100%; font-family: 'Courier New'; font-size:16px; border:2px inset #FFFFFF; padding:4px; background: #FFFFFF;"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Access_Rank:</b></font></td>
                                        <td>
                                            <select name="nivel" style="width:100%; font-family: 'Courier New'; font-size:16px; border:2px inset #FFFFFF; padding:4px; background: #FFFFFF; height:32px;">
                                                <option value="Mechanic" <?= ($usuario->nivel == 'Mechanic') ? 'selected' : '' ?>>Mechanic</option>
                                                <option value="Chief Mechanic" <?= ($usuario->nivel == 'Chief Mechanic') ? 'selected' : '' ?>>Chief Mechanic</option>
                                                <option value="Garage Chief" <?= ($usuario->nivel == 'Garage Chief') ? 'selected' : '' ?>>Garage Chief</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><font face="Arial" size="3"><b>New_Password:</b></font></td>
                                        <td>
                                            <input type="password" name="senha" placeholder="Leave empty to keep current" style="width:100%; font-family: 'Courier New'; font-size:16px; border:2px inset #FFFFFF; padding:4px; background: #FFFFFF;">
                                        </td>
                                    </tr>
                                </table>
                                
                                <br><br>

                                <div align="right">
                                    <button type="button" onclick="window.location='<?= site_url('usuarios'); ?>'" style="width:130px; height:35px; font-family: Arial; font-size:12px; cursor:pointer; background:#C0C0C0; border: 2px solid #FFFFFF; border-right:2px solid #5A5A5A; border-bottom:2px solid #5A5A5A;">
                                        CANCEL
                                    </button>
                                    &nbsp;
                                    <button type="submit" style="width:180px; height:35px; font-family: Arial; font-size:12px; font-weight:bold; cursor:pointer; background:#C0C0C0; border: 2px solid #FFFFFF; border-right:2px solid #5A5A5A; border-bottom:2px solid #5A5A5A;">
                                        [ UPDATE_REGISTRY ]
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</center>