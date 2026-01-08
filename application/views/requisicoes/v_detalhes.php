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
                    <td><font size="1">DATA SOLICITAÇÃO:</font><br><b><?= date(
                        "d/m/Y H:i",
                        strtotime($requisicao->data_requisicao)
                    ) ?></b></td>
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
                    <?php foreach ($itens as $item): ?>
                    <tr>
                        <td bgcolor="#FFFFCC" align="center">
                            <font face="Courier New" size="3"><b><?= $item->endereco_origem ?></b></font>
                        </td>
                        <td><font face="Arial" size="2"><?= $item->codigo_sku ?> - <?= $item->nome_produto ?></font></td>
                        <td align="center"><font face="Arial" size="2"><?= strtoupper(
                            $item->lote_alocado
                        ) ?></font></td>
                        <td align="right">
                            <font face="Arial" size="3"><b><?= number_format(
                                $item->quantidade_pedida,
                                0,
                                "",
                                "."
                            ) ?></b></font>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <table border="0" width="100%">
                <tr>
                    <td>
                        <button onclick="window.location.href='<?= site_url(
                            "requisicoes"
                        ) ?>'" style="width:150px; height:25px;">&lt;&lt; BACK_TO_LIST</button>
                    </td>
                    <td align="right">
    <?php if ($requisicao->status_requisicao != "FINALIZADA"): ?>
    <button onclick="if(confirm('CONFIRM SHIPMENT? This will deduct from physical stock.')) 
            window.location.href='<?= site_url(
                "requisicoes/confirmar_picking/" . $requisicao->id
            ) ?>'" 
            style="background:#008000; color:#FFF; font-weight:bold; padding:10px;">
        [ CONFIRM PICKING AND SHIP ]
    </button>
<?php else: ?>
    <div style="border:2px dashed #008000; color:#008000; padding:10px; text-align:center;">
        <b>ORDER SHIPPED / STOCK UPDATED</b>
    </div>
<?php endif; ?>
</td>
                </tr>
            </table>

        </td>
    </tr>
</table>

<?php if ($requisicao->status_requisicao == "PICKING"): ?>
    <div style="background:#FFF3CD; border:1px solid #FFEEBA; padding:15px; margin-top:20px; width:95%; text-align:left;">
        <font face="Arial" size="2" color="#856404">
            <b>CUIDADO:</b> O picking já foi iniciado. Se precisar de alterar produtos ou quantidades, deve estornar primeiro para o saldo voltar às prateleiras.
        </font>
        <br><br>
        <a href="<?= site_url("requisicoes/estornar/" . $requisicao->id) ?>" 
           onclick="return confirm('Deseja realmente cancelar o picking e devolver os produtos para as posições originais?')"
           style="background: #dc3545; color: white; padding: 8px 15px; text-decoration: none; font-weight: bold; border-radius: 3px; font-family: Arial; size: 2;">
           [X] ESTORNAR_PICKING_AND_ROLLBACK
        </a>
    </div>
<?php endif; ?>

</center>