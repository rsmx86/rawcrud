<center>
<table width="950" border="0" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#C0C0C0">
                <tr bgcolor="#808080">
                    <td height="22">
                        &nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>System_Launcher // Workstation_Command_Center</b></font>
                    </td>
                    <td align="right">
                        <font face="Arial" size="2" color="#C0C0C0"><b>[?] [X]</b></font>&nbsp;
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" bgcolor="#D6D2C4" align="left" style="padding: 25px;">
                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <font face="Arial Black" size="6" color="#000080">GARAGE_CONTROL_UNIT</font><br>
                                    <font face="Arial" size="3">Active Session: <b>Ready for processing.</b></font>
                                </td>
                                <td align="right" valign="top">
                                    <?php
                                    $user_nivel = $this->session->userdata(
                                        "nivel"
                                    );
                                    if (
                                        in_array($user_nivel, [
                                            "Garage Chief",
                                            "Chief Mechanic",
                                            "ADM",
                                        ])
                                    ): ?>
                                        <table border="2" cellpadding="5" cellspacing="0" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="display:inline-table; cursor: pointer;" onclick="window.location='<?= site_url(
                                            "usuarios"
                                        ) ?>'">
                                            <tr><td align="center"><font size="4">👥</font><br><font face="Arial" size="1"><b>OPERATORS</b></font></td></tr>
                                        </table>
                                    <?php endif;
                                    ?>

                                    <table border="2" cellpadding="5" cellspacing="0" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="display:inline-table; cursor: pointer; margin-left: 5px;" onclick="window.location='<?= site_url(
                                        "clientes"
                                    ) ?>'">
                                        <tr><td align="center"><font size="4">📇</font><br><font face="Arial" size="1"><b>CUSTOMERS</b></font></td></tr>
                                    </table>

                                    <table border="2" cellpadding="5" cellspacing="0" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="display:inline-table; cursor: pointer; margin-left: 5px;" onclick="window.location='<?= site_url(
                                        "catalogo"
                                    ) ?>'">
                                        <tr><td align="center"><font size="4">📚</font><br><font face="Arial" size="1"><b>CATALOG</b></font></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <hr size="1" noshade color="#808080" style="margin: 20px 0;">

                        <table width="100%" border="0" cellspacing="10" cellpadding="0">
                            <tr>
                                <td width="65%" valign="top">
                                    
                                    <table width="100%" border="2" cellspacing="0" cellpadding="15" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer; margin-bottom: 12px;" onclick="window.location.href='<?= site_url(
                                        "invoices"
                                    ) ?>'">
                                        <tr>
                                            <td>
                                                <font face="Arial Black" size="4" color="#A00000">📄 INVOICE_ENTRY</font><br>
                                                <font face="Arial" size="2">Registrar novas notas fiscais e entradas de estoque.</font>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 12px;">
                                        <tr>
                                            <td width="48%">
                                                <table width="100%" border="2" cellspacing="0" cellpadding="15" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer;" onclick="window.location.href='<?= site_url(
                                                    "estoque"
                                                ) ?>'">
                                                    <tr><td><font face="Arial Black" size="3">📦 STOCK_INV</font><br><font face="Arial" size="1">Gestão física de peças.</font></td></tr>
                                                </table>
                                            </td>
                                            <td width="4%"></td>
                                            <td width="48%">
                                                <table width="100%" border="2" cellspacing="0" cellpadding="15" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer;" onclick="window.location.href='<?= site_url(
                                                    "requisicoes"
                                                ) ?>'">
                                                    <tr><td><font face="Arial Black" size="3" color="#000080">🕊️ DISPATCH</font><br><font face="Arial" size="1">Saída e expedição.</font></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="100%" border="2" cellspacing="0" cellpadding="15" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer; margin-bottom: 12px;" onclick="window.location.href='<?= site_url(
                                        "devolucao"
                                    ) ?>'">
                                        <tr>
                                            <td>
                                                <font face="Arial Black" size="3" color="#808000">🔄 REVERSE_LOGISTICS [ESTORNO]</font><br>
                                                <font face="Arial" size="1">Devolução de mercadoria e restauração de saldo.</font>
                                            </td>
                                        </tr>
                                    </table>

                                    <div>
                                        <?php if (
                                            in_array($user_nivel, [
                                                "Garage Chief",
                                                "ADM",
                                            ])
                                        ): ?>
                                            <table width="100%" border="2" cellspacing="0" cellpadding="15" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer;">
                                                <tr><td><font face="Arial Black" size="3" color="#000000">📈 SYSTEM_REPORTS</font></td></tr>
                                            </table>
                                        <?php else: ?>
                                            <table width="100%" border="1" cellspacing="0" cellpadding="15" bgcolor="#D6D2C4" bordercolor="#808080">
                                                <tr><td><font face="Arial Black" size="3" color="#808080">📈 REPORTS [RESTRICTED]</font></td></tr>
                                            </table>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td width="35%" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#808080">
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#000000">
                                                    <tr>
                                                        <td height="330" valign="top"> <font face="Courier New" size="2" color="#00FF00">
                                                                [SYSTEM_LOG]<br>
                                                                > session_init... OK<br>
                                                                > auth_level: <?= $user_nivel ?><br>
                                                                > db_link: established<br>
                                                                > status: AWAITING_CMD_<br>
                                                                > station_id: G90-TK-01<br>
                                                                > loading_modules... DONE<br>
                                                                > rev_logistics: active
                                                            </font>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr bgcolor="#C0C0C0">
                    <td colspan="2" style="border-top: 1px solid #808080; padding: 4px;">
                        <font face="Arial" size="2">&nbsp;<b>Status:</b> Ready for input</font>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</center>