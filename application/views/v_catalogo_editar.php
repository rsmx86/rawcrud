<div style="padding: 15px;">
    <form action="<?= site_url('estoque/atualizar_catalogo'); ?>" method="POST">
        <input type="hidden" name="id" value="<?= $produto->id ?>">
        <table width="600" border="0" cellpadding="2" cellspacing="0" bgcolor="#808080">
            <tr>
                <td>
                    <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#C0C0C0">
                        <tr>
                            <td>
                                <font face="Arial" size="4"><b>Master_Catalog // Edit_Part: <?= $produto->codigo_sku ?></b></font>
                                <hr size="1" color="#808080" noshade>
                                <br>
                                <table border="0" cellpadding="4" cellspacing="0">
                                    <tr>
                                        <td><font face="Arial" size="2">SKU / PART_NUMBER:</font></td>
                                        <td><input type="text" 
       name="codigo_sku" 
       value="<?= $produto->codigo_sku ?>" 
       required 
       pattern="\[0-9]*" 
       title="Apenas números são permitidos"
       oninput="this.value = this.value.replace(/[^0-9]/g, '');"
       style="border: 2px inset #FFFFFF; background: #FFFFFF;">
                                    </tr>
                                    <tr>
                                        <td><font face="Arial" size="2">PRODUCT_NAME:</font></td>
                                        <td><input type="text" name="nome_produto" value="<?= $produto->nome_produto ?>" size="40" required style="border: 2px inset #FFFFFF;"></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><font face="Arial" size="2">TECH_DESCRIPTION:</font></td>
                                        <td><textarea name="descricao" rows="4" cols="38" style="border: 2px inset #FFFFFF;"><?= $produto->descricao ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><br>
                                            <input type="submit" value=" [ UPDATE_RECORD ] " style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; font-weight:bold; padding: 5px;">
                                            <input type="button" value=" [ CANCEL ] " onclick="window.location.href='<?= site_url('estoque/catalogo'); ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding: 5px;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</div>