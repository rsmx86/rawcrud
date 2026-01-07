<center>
<form action="<?= site_url('catalogo/atualizar'); ?>" method="post">
    <input type="hidden" name="id" value="<?= $produto->id ?>">

    <table width="600" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Edit_Product // ID: <?= $produto->id ?></b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td bgcolor="#D6D2C4" style="padding:15px;">
                
                <table width="100%" border="1" cellspacing="0" cellpadding="8" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <tr>
                        <td width="50%">
                            <font face="Arial" size="1"><b>CÓDIGO_ÚNICO (SKU):</b></font><br>
                            <input type="text" name="codigo_sku" value="<?= $produto->codigo_sku ?>" size="20" style="width:95%; font-family:Courier New; font-weight:bold;">
                        </td>
                        <td width="50%">
                            <font face="Arial" size="1"><b>UNIDADE_MEDIDA:</b></font><br>
                            <select name="unidade_medida" style="width:100%;">
                                <option value="UN" <?= ($produto->unidade_medida == 'UN') ? 'selected' : '' ?>>UN - UNIDADE</option>
                                <option value="PC" <?= ($produto->unidade_medida == 'PC') ? 'selected' : '' ?>>PC - PEÇA</option>
                                <option value="KG" <?= ($produto->unidade_medida == 'KG') ? 'selected' : '' ?>>KG - QUILOGRAMA</option>
                                <option value="LT" <?= ($produto->unidade_medida == 'LT') ? 'selected' : '' ?>>LT - LITRO</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <font face="Arial" size="1"><b>NOME_DO_PRODUTO:</b></font><br>
                            <input type="text" name="nome_produto" value="<?= $produto->nome_produto ?>" style="width:98%;">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <font face="Arial" size="1"><b>FABRICANTE:</b></font><br>
                            <input type="text" name="fabricante" value="<?= $produto->fabricante ?>" style="width:98%;">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <font face="Arial" size="1"><b>VALOR_UNITÁRIO (BRL):</b></font><br>
                            <input type="number" step="0.01" name="valor_unitario" value="<?= $produto->valor_unitario ?>" style="width:95%; text-align:right;">
                        </td>
                        <td bgcolor="#D6D2C4" align="center">
                             <font face="Arial" size="1" color="#404040">Modifique os campos necessários<br>e clique em Update.</font>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <button type="button" onclick="window.location.href='<?= site_url('catalogo'); ?>'"><b>< &nbsp;Cancel</b></button>
                        </td>
                        <td align="right">
                            <button type="submit" style="width:120px; height:30px; background-color:#C0C0C0;"><b>Update_Record ></b></button>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</form>
</center>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Popup de Erro (SKU Duplicado ou campos vazios)
        <?php if($this->session->flashdata('erro_sku')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Atenção!',
                text: '<?php echo $this->session->flashdata('erro_sku'); ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>

        // Popup de Sucesso
        <?php if($this->session->flashdata('sucesso')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '<?php echo $this->session->flashdata('sucesso'); ?>',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>
