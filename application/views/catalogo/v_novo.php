<center>
<form action="<?= site_url('catalogo/salvar'); ?>" method="post">
    <table width="600" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Add_New_Product // Wizard_Mode</b></font></td>
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
                            <input type="text" name="codigo_sku" size="20" style="width:95%; font-family:Courier New; font-weight:bold;">
                        </td>
                        <td width="50%">
                            <font face="Arial" size="1"><b>UNIDADE_MEDIDA (U.M):</b></font><br>
                            <select name="unidade_medida" style="width:100%;">
                                <option value="UN">UN - UNIDADE</option>
                                <option value="PC">PC - PEÇA</option>
                                <option value="KG">KG - QUILOGRAMA</option>
                                <option value="LT">LT - LITRO</option>
                                <option value="CJ">CJ - CONJUNTO</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <font face="Arial" size="1"><b>NOME_DO_PRODUTO:</b></font><br>
                            <input type="text" name="nome_produto" style="width:98%;">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <font face="Arial" size="1"><b>FABRICANTE:</b></font><br>
                            <input type="text" name="fabricante" style="width:95%;">
                        </td>
                        <td>
                            <font face="Arial" size="1"><b>MARCA:</b></font><br>
                            <input type="text" name="marca" style="width:95%;">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <font face="Arial" size="1"><b>VALOR_UNITÁRIO (BRL):</b></font><br>
                            <input type="number" step="0.01" min="0" required  name="valor_unitario" placeholder="0.00" style="width:95%; text-align:right;">
                        </td>
                        <td bgcolor="#D6D2C4" align="center">
                             <font face="Arial" size="1" color="#404040">Preencha todos os campos<br>antes de processar.</font>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <button type="button" onclick="window.location.href='<?= site_url('catalogo'); ?>'"><b>< &nbsp;Back</b></button>
                        </td>
                        <td align="right">
                            <button type="submit" style="width:120px; height:30px;"><b>Finish_Next ></b></button>
                            <button type="reset"><b>Clean</b></button>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</form>
</center>