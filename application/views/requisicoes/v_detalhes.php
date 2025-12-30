<center>
<table width="95%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#000080">
        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Picking_Instruction // Order: #<?= $requisicao->id ?></b></font></td>
        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" bgcolor="#D6D2C4" style="padding:15px;">
            
            <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <tr>
                    <td><font size="1">CLIENTE / DESTINO:</font><br><b><?= $requisicao->nome_cliente ?></b></td>
                    <td><font size="1">DATA SOLICITAÇÃO:</font><br><b><?= date('d/m/Y H:i', strtotime($requisicao->data_requisicao)) ?></b></td>
                    <td align="center" bgcolor="#FFFF00">
                        <font color="#000000" size="1">STATUS:</font><br>
                        <b><?= $requisicao->status_requisicao ?></b>
                    </td>
                </tr>
            </table>

            <br>

            <table width="100%" border="2" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <thead>
                    <tr bgcolor="#808080">
                        <td><font color="#FFFFFF" size="1">ENDEREÇO (ONDE COLETAR)</font></td>
                        <td><font color="#FFFFFF" size="1">SKU / PRODUTO</font></td>
                        <td align="center"><font color="#FFFFFF" size="1">LOTE</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">QTD PARA PEGAR</font></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($itens as $item): ?>
                    <tr>
                        <td bgcolor="#FFFFCC" align="center">
                            <font face="Courier New" size="3"><b><?= $item->endereco_origem ?></b></font>
                        </td>
                        <td><font face="Arial" size="2"><?= $item->codigo_sku ?> - <?= $item->nome_produto ?></font></td>
                        <td align="center"><font face="Arial" size="2"><?= strtoupper($item->lote_alocado) ?></font></td>
                        <td align="right">
                            <font face="Arial" size="3"><b><?= number_format($item->quantidade_pedida, 0, '', '.') ?></b></font>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <table border="0" width="100%">
                <tr>
                    <td>
                        <button onclick="window.location.href='<?= site_url('requisicoes'); ?>'" style="width:150px; height:25px;">&lt;&lt; BACK_TO_LIST</button>
                    </td>
                    <td align="right">
                        <form action="<?= site_url('requisicoes/finalizar_saida') ?>" method="post" style="margin:0;">
                            <input type="hidden" name="id_requisicao" value="<?= $requisicao->id ?>">
                            <button type="submit" style="background-color: #008000; color: white; font-weight: bold; height: 30px;">
                                [ CONFIRM_PICKING_AND_SHIP ]
                            </button>
                        </form>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</center>