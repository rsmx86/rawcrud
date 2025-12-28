<center>
    <br><br>
    <table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 3px solid #808080; border-bottom: 3px solid #808080;">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#000080">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>User Account Setup Wizard</b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[X]</b></font>&nbsp;</td>
                    </tr>
                </table>

                <form action="<?= site_url('usuarios/salvar'); ?>" method="POST">
                    <table width="100%" border="0" cellpadding="25" cellspacing="0" bgcolor="#D6D2C4">
                        <tr>
                            <td>
                                <font face="Arial Black" size="5" color="#000080">ADD_NEW_OPERATOR</font>
                                <hr size="1" color="#808080" noshade>
                                <br>
                                <table width="100%" border="0" cellspacing="10" cellpadding="0">
                                    <tr>
                                        <td width="30%"><font face="Arial" size="3"><b>First_Name:</b></font></td>
                                        <td><input type="text" name="nome" required style="width:100%; font-size:16px; font-family:Courier New; border:2px inset #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Last_Name:</b></font></td>
                                        <td><input type="text" name="sobrenome" required style="width:100%; font-size:16px; font-family:Courier New; border:2px inset #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Operator_Nick:</b></font></td>
                                        <td><input type="text" name="nick" required style="width:100%; font-size:16px; font-family:Courier New; border:2px inset #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Access_Email:</b></font></td>
                                        <td><input type="email" name="email" required style="width:100%; font-size:16px; font-family:Courier New; border:2px inset #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="3"><b>Access_Rank:</b></font></td>
                                        <td>
                                            <select name="nivel" style="width:100%; font-size:16px; font-family:Courier New; border:2px inset #FFFFFF;">
                                                <option value="Mechanic">Mechanic</option>
                                                <option value="Chief Mechanic">Chief Mechanic</option>
                                                <option value="Garage Chief">Garage Chief</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#FFFFE1" style="border:1px solid #808080;">
                                                <tr>
                                                    <td><font face="Arial" size="2">⚠️ <b>SECURITY_NOTICE:</b> A temporary system-generated password has been assigned. Update upon first login.</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <div align="right">
                                    <button type="button" onclick="window.location='<?= site_url('usuarios'); ?>'">Cancel</button>
                                    <button type="submit"><b>[ COMMIT_REGISTRY ]</b></button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</center>