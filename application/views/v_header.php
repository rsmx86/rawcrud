<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>G90_STATION // ENTERPRISE_v0.2.1</title>
</head>
<body bgcolor="#D6D2C4" text="#000000" link="#000000" vlink="#000000" style="margin:0; padding:0;">

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
        <td height="38" valign="bottom">
            &nbsp;
            <?php 
                $ativa = (isset($pagina_ativa)) ? $pagina_ativa : 'dashboard'; 
            ?>

            <table border="0" cellspacing="0" cellpadding="8" style="display:inline-table; 
                border: 2px solid #FFFFFF; border-right: 2px solid #808080; 
                border-bottom: <?= ($ativa == 'dashboard') ? '0px' : '2px solid #808080'; ?>; 
                background: <?= ($ativa == 'dashboard') ? '#D6D2C4' : '#C0C0C0'; ?>; 
                position:relative; top: 2px; z-index: 10;">
                <tr>
                    <td>
                        <a href="<?= site_url('painel'); ?>" style="text-decoration:none;">
                            <font face="Arial" size="<?= ($ativa == 'dashboard') ? '3' : '2'; ?>">
                                <b><u>M</u>ain_Panel</b>
                            </font>
                        </a>
                    </td>
                </tr>
            </table>

            <?php if($ativa == 'clientes'): ?>
            <table border="0" cellspacing="0" cellpadding="8" style="display:inline-table; 
                border: 2px solid #FFFFFF; border-right: 2px solid #808080; 
                border-bottom: 0px; background: #D6D2C4; 
                position:relative; top: 2px; margin-left: -2px; z-index: 10;">
                <tr>
                    <td>
                        <font face="Arial" size="3"><b><u>C</u>lients_DB</b></font>
                    </td>
                </tr>
            </table>
            <?php endif; ?>

            <?php if($ativa == 'usuarios'): ?>
            <table border="0" cellspacing="0" cellpadding="8" style="display:inline-table; 
                border: 2px solid #FFFFFF; border-right: 2px solid #808080; 
                border-bottom: 0px; background: #D6D2C4; 
                position:relative; top: 2px; margin-left: -2px; z-index: 10;">
                <tr>
                    <td>
                        <font face="Arial" size="3"><b><u>O</u>perators_DB</b></font>
                    </td>
                </tr>
            </table>
            <?php endif; ?>

        </td>
        <td align="right" valign="middle">
            <font face="Arial" size="3">
                <a href="<?= site_url('login/sair'); ?>" style="text-decoration:none;"><b>[ LOGOFF ]</b></a>&nbsp;
            </font>
        </td>
    </tr>
</table>

<div style="border-top: 1px solid #FFFFFF; border-bottom: 2px solid #808080; height: 1px; background: #D6D2C4; position:relative; z-index:1; top:-1px;"></div>
<br>