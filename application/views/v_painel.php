<center>
    <br>
    <table width="950" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 3px solid #808080; border-bottom: 3px solid #808080;">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#808080">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>System_Launcher // Workstation</b></font></td>
                        <td align="right"><font face="Arial" size="1" color="#C0C0C0">[?] [X]</font>&nbsp;</td>
                    </tr>
                </table>

                <table width="100%" border="0" cellpadding="25" cellspacing="0" bgcolor="#D6D2C4">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top">
                                        <font face="Arial Black" size="6" color="#000080">GARAGE_CONTROL_UNIT</font><br>
                                        <font face="Arial" size="3">Active Session: <b>Ready for processing.</b></font>
                                    </td>
                                    <td align="right" valign="top">
                                        <?php 
                                            $user_nivel = $this->session->userdata('nivel');
                                            if(in_array($user_nivel, ['Garage Chief', 'Chief Mechanic', 'ADM'])): 
                                        ?>
                                        <table border="0" cellpadding="8" cellspacing="0" bgcolor="#C0C0C0" style="display:inline-table; border: 2px solid #FFFFFF; border-right: 2px solid #808080; border-bottom: 2px solid #808080; cursor: pointer;" onclick="window.location='<?= site_url('usuarios'); ?>'">
                                            <tr>
                                                <td align="center">
                                                    <font size="5">👥</font><br>
                                                    <font face="Arial" size="1"><b>OPERATORS_DB</b></font>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php endif; ?>

                                        <table border="0" cellpadding="8" cellspacing="0" bgcolor="#C0C0C0" style="display:inline-table; border: 2px solid #FFFFFF; border-right: 2px solid #808080; border-bottom: 2px solid #808080; cursor: pointer; margin-left: 5px;" onclick="window.location='<?= site_url('clientes'); ?>'">
                                            <tr>
                                                <td align="center">
                                                    <font size="5">📇</font><br>
                                                    <font face="Arial" size="1"><b>CUSTOMER_DB</b></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>



                            <hr size="1" color="#808080" noshade style="margin: 20px 0;">

                            <table width="100%" border="0" cellspacing="10" cellpadding="0">
                                <tr>
                                    <td width="65%" valign="top">
                                        <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#C0C0C0" 
       style="border: 2px solid #FFFFFF; border-right: 2px solid #808080; border-bottom: 2px solid #808080; cursor: pointer; margin-bottom: 15px;"
       onclick="window.location.href='<?= site_url('invoice'); ?>'">
    <tr>
        <td>
            <font face="Arial Black" size="4" color="#A00000">📄 INVOICE_ENTRY</font><br>
            <font face="Arial" size="3">Registrar novas notas fiscais e entradas de estoque.</font>
        </td>
    </tr>
</table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="50%" style="padding-right:7px;">
    <a href="<?= site_url('estoque'); ?>" style="text-decoration:none;">
        <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#C0C0C0" 
               style="border: 2px solid #FFFFFF; border-right: 2px solid #808080; border-bottom: 2px solid #808080; cursor: pointer;"
               onmouseover="this.style.background='#D6D2C4'" 
               onmouseout="this.style.background='#C0C0C0'">
            <tr>
                <td>
                    <font face="Arial Black" size="3" color="#000000">📦 STOCK_INV</font><br>
                    <font face="Arial" size="2" color="#000000">Gestão de peças e componentes.</font>
                </td>
            </tr>
        </table>
    </a>
</td>
                                                <td width="50%" style="padding-left:7px;">
                                                    <?php if(in_array($user_nivel, ['Garage Chief', 'ADM'])): ?>
                                                    <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 2px solid #808080; border-bottom: 2px solid #808080; cursor: pointer;">
                                                        <tr>
                                                            <td>
                                                                <font face="Arial Black" size="3" color="#000080">📈 REPORTS</font><br>
                                                                <font face="Arial" size="2">Estatísticas de produtividade.</font>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php else: ?>
                                                    <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#C0C0C0" style="border: 1px solid #999999; opacity: 0.6;">
                                                        <tr>
                                                            <td>
                                                                <font face="Arial Black" size="3" color="#666666">📈 REPORTS</font><br>
                                                                <font face="Arial" size="2">Acesso restrito.</font>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td width="35%" valign="top">
                                        <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#000000" style="border: 2px inset #FFFFFF; height: 210px;">
                                            <tr>
                                                <td valign="top">
                                                    <font face="Courier New" size="2" color="#00FF00">
                                                        [SYSTEM_LOG]<br>
                                                        > session_init... OK<br>
                                                        > auth_level: <?= (!empty($user_nivel)) ? $user_nivel : 'NULL'; ?><br>
                                                        > db_link: established<br>
                                                        > status: AWAITING_CMD_<br>
                                                        > ready_for_input...
                                                    </font>
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <center><font face="Arial" size="1" color="#404040">STATION_ID: G90-TK-01</font></center>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#C0C0C0" style="border-top: 1px solid #808080;">
                    <tr>
                        <td><font face="Arial" size="2">&nbsp;<b>Status:</b> Ready</font></td>
                        <td align="right"><font face="Arial" size="2">RAW_CRUD_SYSTEM_0.3.1&nbsp;</font></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>