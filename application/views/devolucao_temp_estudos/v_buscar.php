<center>
    <?php if($this->session->flashdata('sucesso')): ?>
        <table width="500" border="1" cellspacing="0" cellpadding="5" bgcolor="#E1FFE1" style="border-color:green; margin-bottom:10px;">
            <tr><td><font face="Arial" size="2" color="green"><b>OK:</b> <?= $this->session->flashdata('sucesso') ?></font></td></tr>
        </table>
    <?php endif; ?>

    <?php if($this->session->flashdata('erro')): ?>
        <table width="500" border="1" cellspacing="0" cellpadding="5" bgcolor="#FFE1E1" style="border-color:red; margin-bottom:10px;">
            <tr><td><font face="Arial" size="2" color="red"><b>ERROR:</b> <?= $this->session->flashdata('erro') ?></font></td></tr>
        </table>
    <?php endif; ?>

    <table width="500" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#808080">
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Estorno_Search.exe</b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:20px;">
                <form action="<?= site_url('devolucao/buscar') ?>" method="POST">
                    <fieldset style="border: 1px solid #808080; padding: 15px;">
                        <legend><font face="Arial" size="1"><b>DISPATCH_DATA_ENTRY</b></font></legend>
                        
                        <center>
                            <font face="Arial" size="2">Digite o Código de Despacho:</font><br><br>
                            <input type="text" name="codigo_despacho" maxlength="6" required 
                                   style="font-family:'Courier New'; font-size:24px; font-weight:bold; width:200px; text-align:center; border:2px inset #FFF;">
                            <br><br>
                            <button type="submit" style="width:200px; height:35px; cursor:pointer;"><b>[ LOCATE_ITEMS ]</b></button>
                        </center>
                    </fieldset>
                </form>
                <br>
                <center>
                    <a href="<?= site_url('painel') ?>"><font face="Arial" size="1">Cancel and return to Main_Panel</font></a>
                </center>
            </td>
        </tr>
    </table>
</center>