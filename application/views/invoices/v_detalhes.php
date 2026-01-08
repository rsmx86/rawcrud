<center>
<table width="95%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#000080">
        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Allocation_Station // Invoice: <?= $invoice->numero_nota ?></b></font></td>
        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" bgcolor="#D6D2C4" style="padding:15px;">
            
            <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <tr>
                    <td width="25%">
                        <font size="1">FORNECEDOR:</font><br>
                        <select name="fornecedor_visual" disabled style="width:100%; font-weight:bold; background:#F0F0F0;">
                            <option><?= $invoice->fornecedor ?></option>
                        </select>
                    </td>
                    <td width="20%"><font size="1">DATA EMISSÃO:</font><br><b><?= date(
                        "d/m/Y",
                        strtotime($invoice->data_emissao)
                    ) ?></b></td>
                    <td width="20%" bgcolor="#E1E1E1"><font size="1">VALOR TOTAL NOTA:</font><br><b>R$ <?= number_format(
                        $invoice->valor_total_nota,
                        2,
                        ",",
                        "."
                    ) ?></b></td>
                    <td width="20%"><font size="1">FUNCIONÁRIO (RESP.):</font><br><input type="text" value="ADMIN_SYS" disabled style="width:90%; font-size:10px;"></td>
                    <td align="center" bgcolor="#008000">
                        <font color="#FFFFFF" size="1">STATUS:</font><br>
                        <font color="#FFFFFF"><b><?= $invoice->status_nota ?></b></font>
                    </td>
                </tr>
            </table>

            <br>

            <table width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#D6D2C4" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <tr bgcolor="#B0B0B0">
                    <td><font face="Arial" size="1"><b>STEP_02: ADD_PRODUCTS_TO_INVOICE</b></font></td>
                </tr>
                <tr>
                    <td>
                        <form action="<?= site_url(
                            "invoices/adicionar_item_unitario"
                        ) ?>" method="post" style="margin:0;">
                            <input type="hidden" name="id_invoice" value="<?= $invoice->id ?>">
                            
                            <font size="1">PRODUTO (CATÁLOGO):</font>
                            <select name="id_catalogo" required style="width:300px;">
                                <option value="">-- SELECIONE UM PRODUTO --</option>
                                <?php foreach ($produtos_catalogo as $prod): ?>
                                    <option value="<?= $prod->id ?>"><?= $prod->codigo_sku ?> - <?= $prod->nome_produto ?> (R$ <?= $prod->valor_unitario ?>)</option>
                                <?php endforeach; ?>
                            </select>

                            &nbsp;<font size="1">LOTE:</font>
                            <input type="text" name="lote" required size="10" placeholder="Lote info">

                            &nbsp;<font size="1">QTD:</font>
                            <input type="number" name="quantidade" required step="0.01" style="width:60px;">

                            &nbsp;<button type="submit" style="background:#C0C0C0; font-weight:bold; cursor:pointer;">[+] INSERT_ITEM</button>
                        </form>
                    </td>
                </tr>
            </table>

            <br>

            <?php
            $diferenca = $invoice->valor_total_nota - $total_acumulado;
            $cor_status = $diferenca == 0 ? "green" : "red";
            ?>
            <div align="right">
                <font face="Arial" size="1">Total acumulado nos itens: <b>R$ <?= number_format(
                    $total_acumulado,
                    2,
                    ",",
                    "."
                ) ?></b></font><br>
                <font face="Arial" size="1" color="<?= $cor_status ?>">Diferença p/ fechar nota: <b>R$ <?= number_format(
    $diferenca,
    2,
    ",",
    "."
) ?></b></font>
            </div>

            <br>

            <table width="100%" border="2" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <thead>
                    <tr bgcolor="#808080">
                        <td><font color="#FFFFFF" size="1">SKU / PRODUTO</font></td>
                        <td align="center"><font color="#FFFFFF" size="1">LOTE</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">QTD TOTAL</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">ALOCADO</font></td>
                        <td align="right"><font color="#FFFFFF" size="1">SALDO</font></td>
                        <td align="center" width="250"><font color="#FFFFFF" size="1">ALLOCATION_ACTION</font></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($itens)): ?>
                        <tr><td colspan="6" align="center"><font size="2" color="gray"><i>Aguardando inserção de itens...</i></font></td></tr>
                    <?php else: ?>
                        <?php foreach ($itens as $item):
                            $saldo =
                                $item->quantidade_nota -
                                $item->quantidade_alocada; ?>
                        <tr <?php if ($saldo <= 0) {
                            echo 'bgcolor="#E8FFE8"';
                        } ?>>
                            <td><font face="Arial" size="2"><?= $item->nome_produto ?></font></td>
                            <td align="center"><font face="Arial" size="2"><?= $item->lote ?></font></td>
                            <td align="right"><font face="Arial" size="2"><?= number_format(
                                $item->quantidade_nota,
                                2,
                                ",",
                                "."
                            ) ?></font></td>
                            <td align="right"><font face="Arial" size="2" color="blue"><?= number_format(
                                $item->quantidade_alocada,
                                2,
                                ",",
                                "."
                            ) ?></font></td>
                            <td align="right">
                                <font face="Arial" size="2" color="<?= $saldo >
                                0
                                    ? "red"
                                    : "green" ?>">
                                    <b><?= number_format(
                                        $saldo,
                                        2,
                                        ",",
                                        "."
                                    ) ?></b>
                                </font>
                            </td>
                            <td align="center" bgcolor="#C0C0C0">
                                <?php if ($saldo > 0): ?>
                                    <form action="<?= site_url(
                                        "invoices/confirmar_alocacao"
                                    ) ?>" method="post" style="margin:0; display: flex; gap: 2px;">
    <input type="hidden" name="id_invoice" value="<?= $invoice->id ?>">
    <input type="hidden" name="id_invoice_item" value="<?= $item->id ?>">
    <input type="hidden" name="id_catalogo" value="<?= $item->id_catalogo ?>">
    <input type="hidden" name="lote" value="<?= $item->lote ?>">

    <select name="rua" required style="font-size:10px; font-family: 'Courier New'; font-weight: bold; width: 60px;">
        <option value="">RUA</option>
        <?php foreach (range("A", "Z") as $rua): ?>
            <option value="<?= $rua ?>"><?= $rua ?></option>
        <?php endforeach; ?>
    </select>

    <select name="posicao" required style="font-size:10px; font-family: 'Courier New'; font-weight: bold; width: 60px;">
        <option value="">POS</option>
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select>

    <input type="number" name="qtd_alocar" value="<?= $saldo ?>" max="<?= $saldo ?>" step="0.01" 
           style="width:45px; font-size:10px; font-family: 'Courier New';">
    
    <button type="submit" style="font-size:10px; font-weight:bold; cursor:pointer; background:#C0C0C0;">[ OK ]</button>
</form>
                                <?php else: ?>
                                    <font face="Arial" size="1" color="green"><b>STORED_COMPLETE</b></font>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                        endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <br>
            <table border="0" width="100%">
                <tr>
                    <td>
                        <button onclick="window.location.href='<?= site_url(
                            "invoices"
                        ) ?>'" style="width:150px; height:25px;">&lt;&lt; BACK_TO_LIST</button>
                    </td>
                    <td align="right">
                        <button onclick="window.print()" style="width:100px; height:25px;">[PRINT_TAGS]</button>
                    </td>
                </tr>
            </table>

            <hr>
            <table width="100%" border="0">
                <tr>
                    <td width="20%">
                        <table width="100%" border="2" cellspacing="0" cellpadding="5" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080" style="cursor: pointer;" onclick="window.location.href='<?= site_url(
                            "estoque"
                        ) ?>'">
                            <tr><td align="center"><font face="Arial Black" size="2">📦 STOCK_INV</font></td></tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</center>

<table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#F0F0F0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
    <tr bgcolor="#D6D2C4">
        <td colspan="5"><font size="1"><b>HISTÓRICO DE ALOCAÇÕES NESTA NOTA:</b></font></td>
    </tr>
    <tr bgcolor="#E1E1E1">
        <td><font size="1">PRODUTO</font></td>
        <td><font size="1">LOTE</font></td>
        <td align="center"><font size="1">POSIÇÃO</font></td>
        <td align="right"><font size="1">QTD</font></td>
        <td align="center"><font size="1">AÇÃO</font></td>
    </tr>
    <?php // Supondo que você carregue as alocações da nota no controller
    // $alocacoes = $this->db->get_where('estoque_v2', ['id_invoice_item' => ...])->result();
    foreach ($alocacoes_da_nota as $aloc): ?>
    <tr>
        <td><font size="2"><?= $aloc->nome_produto ?></font></td>
        <td><font size="2"><?= $aloc->lote ?></font></td>
        <td align="center"><font size="2"><?= $aloc->rua ?>-<?= $aloc->posicao ?></font></td>
        <td align="right"><font size="2"><?= number_format(
            $aloc->quantidade,
            2,
            ",",
            "."
        ) ?></font></td>
        <td align="center">
            <a href="<?= site_url(
                "invoices/remover_alocacao/" . $aloc->id . "/" . $invoice->id
            ) ?>" 
               onclick="return confirm('Deseja remover este produto deste endereço? O saldo voltará para a nota.')"
               style="color:red; font-size:10px; font-weight:bold; text-decoration:none;">
               [ ESTORNAR ]
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>