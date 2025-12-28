<!DOCTYPE html>
<html>
<head>
    <title>Customer Technical Sheet</title>
    <style>
        body { background-color: #008080; font-family: 'Courier New', Courier, monospace; color: #000; }
        .window { background-color: #c0c0c0; border: 2px outset #fff; width: 700px; margin: 30px auto; padding: 2px; }
        .title-bar { background: linear-gradient(90deg, #000080, #1084d0); color: white; padding: 3px 5px; font-weight: bold; display: flex; justify-content: space-between; }
        .content { padding: 20px; border: 1px inset #fff; margin: 2px; background-color: #fff; }
        .header-sheet { border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; display: flex; justify-content: space-between; }
        .section-title { background-color: #000; color: #fff; padding: 3px 10px; font-weight: bold; margin-top: 15px; text-transform: uppercase; }
        .info-row { display: flex; border-bottom: 1px dotted #ccc; padding: 5px 0; font-size: 13px; }
        .label { font-weight: bold; width: 180px; color: #555; }
        .value { color: #000; text-transform: uppercase; }
        .footer-btns { margin-top: 20px; text-align: right; background-color: #c0c0c0; padding: 10px; border: 2px outset #fff; }
        .btn-win { background-color: #c0c0c0; border: 2px outset #fff; padding: 5px 15px; cursor: pointer; font-weight: bold; }
        .btn-win:active { border-style: inset; }
    </style>
</head>
<body>

<div class="window">
    <div class="title-bar">
        <span>CUSTOMER_FILE_VIEWER.EXE - <?= $cliente->nome_completo ?></span>
        <span style="cursor:pointer" onclick="window.location='<?= site_url('clientes'); ?>'">[X]</span>
    </div>
    
    <div class="content">
        <div class="header-sheet">
            <div>
                <h2 style="margin:0;">PERFORMANCE UNIT</h2>
                <small>Technical Database v0.3.5</small>
            </div>
            <div style="text-align:right">
                <strong>ID: #<?= str_pad($cliente->id, 5, "0", STR_PAD_LEFT) ?></strong><br>
                <span>DATE: <?= date('d/m/Y') ?></span>
            </div>
        </div>

        <div class="section-title">Owner Information</div>
        <div class="info-row"><span class="label">FULL NAME:</span> <span class="value"><?= $cliente->nome_completo ?></span></div>
        <div class="info-row"><span class="label">NICKNAME/CALLSIGN:</span> <span class="value"><?= $cliente->nick ?></span></div>
        <div class="info-row"><span class="label">CONTACT:</span> <span class="value"><?= $cliente->telefone ?></span></div>
        <div class="info-row"><span class="label">LOCATION:</span> <span class="value"><?= $cliente->cidade_provincia ?> (<?= $cliente->pais ?>)</span></div>
        <div class="info-row"><span class="label">ZIP CODE:</span> <span class="value"><?= $cliente->cep ?></span></div>

        <div class="section-title">Vehicle Specs</div>
        <div class="info-row"><span class="label">MAKER/MODEL:</span> <span class="value"><?= $cliente->carro_fabricante ?> <?= $cliente->carro_modelo ?> (<?= $cliente->carro_ano ?>)</span></div>
        <div class="info-row"><span class="label">ENGINE:</span> <span class="value"><?= $cliente->carro_motor ?></span></div>
        <div class="info-row"><span class="label">INDUCTION:</span> <span class="value"><?= $cliente->carro_turbo ?></span></div>
        <div class="info-row"><span class="label">ECU SYSTEM:</span> <span class="value"><?= $cliente->carro_ecu ?></span></div>
        <div class="info-row"><span class="label">TRANSMISSION:</span> <span class="value"><?= $cliente->carro_cambio ?></span></div>

        <div class="section-title">Field Notes</div>
        <div style="padding: 10px; font-style: italic; font-size: 12px; min-height: 50px;">
            <?= nl2br($cliente->observacoes) ?>
        </div>
    </div>

    <div class="footer-btns">
    <button class="btn-win" onclick="window.print()">[ PRINT_FILE ]</button>
    
    <button class="btn-win" onclick="window.location='<?= site_url('clientes/editar/'.$cliente->id); ?>'" style="color: #000080;">[ EDIT_DATA ]</button>
    
    <button class="btn-win" onclick="confirmarExclusao(<?= $cliente->id ?>)" style="color: #a00000;">[ DELETE_RECORD ]</button>
    
    <button class="btn-win" onclick="window.location='<?= site_url('clientes'); ?>'">[ CLOSE ]</button>
</div>

<script>
function confirmarExclusao(id) {
    if (confirm("WARNING: You are about to permanently delete this record.\n\nAre you sure you want to proceed?")) {
        window.location.href = '<?= site_url('clientes/deletar/'); ?>' + id;
    }
}
</script>>
</div>

</body>
</html>