<center>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left">
            <button onclick="window.location.href='<?= site_url(
                "catalogo/novo"
            ) ?>'" style="cursor:pointer; padding: 5px 10px;">
                <b>[+] ADD_NEW_PRODUCT</b>
            </button>
        </td>
    </tr>
</table>

<br>

<table width="98%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#000080">
        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>SYSTEM_CATALOG // PRODUCT_INDEX_v0.1</b></font></td>
    </tr>
    <tr>
        <td bgcolor="#D6D2C4">
            
            <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                <thead>
                    <tr bgcolor="#C0C0C0">
                        <td width="10%"><font face="Arial" size="1"><b>SKU</b></font></td>
                        <td width="30%"><font face="Arial" size="1"><b>PRODUTO / DESCRIÇÃO</b></font></td>
                        <td width="20%"><font face="Arial" size="1"><b>FABRICANTE</b></font></td>
                        <td width="10%" align="center"><font face="Arial" size="1"><b>U.M</b></font></td>
                        <td width="15%" align="right"><font face="Arial" size="1"><b>VALOR_UNIT</b></font></td>
                        <td width="15%" align="center"><font face="Arial" size="1"><b>OP_CMD</b></font></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produtos)): ?>
                        <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td bgcolor="#F0F0F0"><font face="Courier New" size="2"><b><?= $p->codigo_sku ?></b></font></td>
                            <td><font face="Arial" size="2"><?= strtoupper(
                                $p->nome_produto
                            ) ?></font></td>
                            <td>
                                <font face="Arial" size="1">
                                    <?= strtoupper($p->fabricante) ?> 
                                    </font>
                            </td>
                            <td align="center"><font face="Arial" size="2"><?= $p->unidade_medida ?></font></td>
                            <td align="right" bgcolor="#F9F9F9">
                                <font face="Courier New" size="2">R$ <?= number_format(
                                    $p->valor_unitario,
                                    2,
                                    ",",
                                    "."
                                ) ?></font>
                            </td>
                            <td align="center">
                                <button onclick="window.location.href='<?= site_url(
                                    "catalogo/editar/" . $p->id
                                ) ?>'" title="EDIT_ENTRY">
                                    <b>[ EDIT ]</b>
                                </button>
                                <button onclick="if(confirm('Confirm Delete?')) window.location.href='<?= site_url(
                                    "catalogo/excluir/" . $p->id
                                ) ?>'" title="DELETE_ENTRY">
                                    <b>[ X ]</b>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" align="center" bgcolor="#FFFFCC">
                                <font face="Arial" size="2" color="red"><b>EMPTY_CATALOG_DATABASE</b></font>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </td>
    </tr>
</table>
</center>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Popup de Erro (SKU Duplicado ou campos vazios)
        <?php if ($this->session->flashdata("erro_sku")): ?>
            Swal.fire({
                icon: 'error',
                title: 'Atenção!',
                text: '<?php echo $this->session->flashdata("erro_sku"); ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>

        // Popup de Sucesso
        <?php if ($this->session->flashdata("sucesso")): ?>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '<?php echo $this->session->flashdata("sucesso"); ?>',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>