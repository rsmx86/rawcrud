    <center>
    <table width="98%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>SYSTEM_INVENTORY // STOCK_LOCATION_REPORT</b></font></td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:10px;">
                
                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <thead>
                        <tr bgcolor="#C0C0C0">
                            <td width="8%"><font face="Arial" size="1"><b>CÓDIGO PRODUTO</b></font></td>
                            <td width="30%"><font face="Arial" size="1"><b>PRODUTO</b></font></td>
                            <td width="30%" align="center"><font face="Arial" size="1"><b>ENDEREÇO</b></font></td>
                            <td width="8%" align="center"><font face="Arial" size="2"><b>LOTE</b></font></td>
                            <td width="8%" align="right"><font face="Arial" size="1"><b>SALDO DISPONÍVEL</b></font></td>
                            <td width="8%" align="center"><font face="Arial" size="1"><b>STATUS</b></font></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($estoque)): ?>
                            <?php foreach ($estoque as $e): ?>
                            <tr>
                                <td bgcolor="#F0F0F0">
                                    <font face="Courier New" size="2"><b><?= $e->codigo_sku ?></b></font>
                                </td>
                                
                                <td>
                                    <font face="Arial" size="2"><?= $e->nome_produto ?></font>
                                </td>
                                
                                <td align="center">
                                    <font face="Arial" size="2"><b><?= $e->rua ?>-<?= $e->posicao ?></b></font>
                                </td>
                                
                                <td align="center">
                                    <font face="Arial" size="2"><?= strtoupper(
                                        $e->lote
                                    ) ?></font>
                                </td>
                                
                                <td align="right" bgcolor="#E8FFE8">
                                    <font face="Arial" size="2"><b><?= number_format(
                                        $e->saldo_disponivel,
                                        0,
                                        "",
                                        "."
                                    ) ?></b></font>
                                </td>
                                
                                <td align="center">
                                    <font face="Arial" size="1" color="<?= $e->status_posicao ==
                                    "ACTIVE"
                                        ? "green"
                                        : "red" ?>">
                                        <b>[ <?= $e->status_posicao ?> ]</b>
                                    </font>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" align="center" bgcolor="#FFFFCC" height="50">
                                    <font face="Arial" size="2" color="red"><b>NENHUM ITEM EM STOCK FÍSICO ENCONTRADO.</b></font>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <br>
                <table width="100%" border="0">
                    <tr>
                        <td>
                            <button onclick="window.location.href='<?= site_url(
                                "painel"
                            ) ?>'">[ VOLTAR ]</button>
                            <button onclick="window.print()">[ IMPRIMIR RELATÓRIO ]</button>
                        </td>
                        <td align="right">
                            <font face="Arial" size="1"><b>TOTAL DE LINHAS NO INVENTÁRIO: <?= count(
                                $estoque
                            ) ?></b></font>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    </center>