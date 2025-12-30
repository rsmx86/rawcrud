<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>G90_STATION // ENTERPRISE_v0.2.1</title>
</head>
<body bgcolor="#D6D2C4" text="#000000" link="#000000" vlink="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#000080">
    <tr>
        <td>
            &nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>🎌 GARAGE_90_STATION_MANAGER.EXE</b></font>
        </td>
        <td align="right">
            <font face="Arial" size="2" color="#FFFFFF">
                <b>USER:</b> <?php echo strtoupper($this->session->userdata('nome')); ?> &nbsp;
                <b>RANK:</b> [<?php echo strtoupper($this->session->userdata('nivel')); ?>] &nbsp;
            </font>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0">
    <tr>
        <td height="34" valign="bottom">
            &nbsp;
            <?php $ativa = (isset($pagina_ativa)) ? $pagina_ativa : 'dashboard'; ?>

            <table border="2" cellspacing="0" cellpadding="6" align="left" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="<?= ($ativa == 'dashboard') ? '#D6D2C4' : '#C0C0C0'; ?>">
                <tr>
                    <td>
                        <a href="<?= site_url('painel'); ?>" style="text-decoration:none;">
                            <font face="MS Sans Serif, Arial" size="2">
                                <b><?= ($ativa == 'dashboard') ? '<u>M</u>ain_Panel' : 'Main_Panel'; ?></b>
                            </font>
                        </a>
                    </td>
                </tr>
            </table>

            <?php if($ativa == 'clientes'): ?>
            <table border="2" cellspacing="0" cellpadding="6" align="left" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="#D6D2C4">
                <tr><td><font face="MS Sans Serif, Arial" size="2"><b><u>C</u>lients_DB</b></font></td></tr>
            </table>
            <?php endif; ?>

            <?php if($ativa == 'usuarios'): ?>
            <table border="2" cellspacing="0" cellpadding="6" align="left" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="#D6D2C4">
                <tr><td><font face="MS Sans Serif, Arial" size="2"><b><u>O</u>perators_DB</b></font></td></tr>
            </table>
            <?php endif; ?>

            <?php if($ativa == 'estoque' || $ativa == 'inventory'): ?>
            <table border="2" cellspacing="0" cellpadding="6" align="left" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="#D6D2C4">
                <tr><td><font face="MS Sans Serif, Arial" size="2"><b><u>S</u>tock_Inventory</b></font></td></tr>
            </table>
            <?php endif; ?>

            <?php if($ativa == 'invoice'): ?>
            <table border="2" cellspacing="0" cellpadding="6" align="left" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="#D6D2C4">
                <tr><td><font face="MS Sans Serif, Arial" size="2"><b><u>I</u>nvoice_Entry</b></font></td></tr>
            </table>
            <?php endif; ?>

        </td>
        <td align="right" valign="middle">
            <font face="Arial" size="2">
                <a href="<?= site_url('login/sair'); ?>" style="text-decoration:none;"><b>[ LOGOFF ]</b></a>&nbsp;
            </font>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr><td bgcolor="#FFFFFF" height="1"></td></tr>
    <tr><td bgcolor="#808080" height="1"></td></tr>
</table>
<br>