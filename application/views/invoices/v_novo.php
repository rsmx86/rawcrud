<center>
<table width="60%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#000080">
        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>New_Invoice_Entry // Step_01: Header_Setup</b></font></td>
        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" bgcolor="#D6D2C4" style="padding:20px;">
            
            <form action="<?= site_url('invoices/salvar_capa'); ?>" method="post">
                
                <table width="100%" border="1" cellspacing="0" cellpadding="8" bgcolor="#C0C0C0" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <tr>
                        <td colspan="2" bgcolor="#808080">
                            <font face="Arial" size="1" color="#FFFFFF"><b>INVOICE_IDENTIFICATION</b></font>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="40%"><font face="Arial" size="2">Invoice Number (Digits Only):</font></td>
                        <td>
                            <input type="text" name="numero_nota" required 
                                   pattern="\d*" title="Apenas números são permitidos"
                                   style="width:95%; font-family: 'Courier New'; font-weight: bold;">
                        </td>
                    </tr>

                    <tr>
                        <td><font face="Arial" size="2">Supplier / Fornecedor:</font></td>
                        <td>
                            <select name="fornecedor" required style="width:98%;">
                                <option value="">-- SELECT_SUPPLIER --</option>
                                <option value="FORNECEDOR_PADRAO_A">Fornecedor Padrão A</option>
                                <option value="FORNECEDOR_PADRAO_B">Fornecedor Padrão B</option>
                                </select>
                        </td>
                    </tr>

                    <tr>
                        <td><font face="Arial" size="2">Issue Date (Data Emissão):</font></td>
                        <td>
                            <input type="date" name="data_emissao" required 
                                   max="<?= date('Y-m-d'); ?>" 
                                   style="width:95%;">
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#E1E1E1"><font face="Arial" size="2"><b>Total NF Value (R$):</b></font></td>
                        <td bgcolor="#E1E1E1">
                            <input type="number" name="valor_total_nota" required step="0.01" 
                                   placeholder="0.00"
                                   style="width:95%; font-weight:bold; color:blue;">
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="0">
                    <tr>
                        <td>
                            <button type="button" onclick="window.location.href='<?= site_url('invoices'); ?>'" style="width:100px; height:30px;">
                                <font size="2">&lt;&lt; CANCEL</font>
                            </button>
                        </td>
                        <td align="right">
                            <button type="submit" style="width:150px; height:30px; font-weight:bold; background:#C0C0C0; cursor:pointer;">
                                <font size="2">NEXT: ADD_ITEMS &gt;&gt;</font>
                            </button>
                        </td>
                    </tr>
                </table>

            </form>

        </td>
    </tr>
</table>

<br>
<font face="Arial" size="1" color="#808080">
    <i>*Note: After clicking "Next", the invoice header will be locked for editing.</i>
</font>
</center>