<?php 
    $is_edit = isset($cliente); 
    $title = $is_edit ? "EDIT_CUSTOMER_DATA.EXE" : "CUSTOMER_REGISTRY_V0.3.5.EXE";
    $action = $is_edit ? site_url('clientes/atualizar/'.$cliente->id) : site_url('clientes/salvar');
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { background-color: #008080; font-family: 'Courier New', Courier, monospace; color: #000; margin: 0; padding: 0; }
        .window { background-color: #c0c0c0; border: 2px outset #fff; width: 800px; margin: 20px auto; padding: 2px; box-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
        .title-bar { background: linear-gradient(90deg, #000080, #1084d0); color: white; padding: 3px 5px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 15px; border: 1px inset #fff; margin: 2px; background-color: #c0c0c0; }
        fieldset { border: 2px groove #fff; padding: 10px; margin-bottom: 15px; }
        legend { font-weight: bold; font-size: 13px; font-family: Arial, sans-serif; }
        label { display: inline-block; width: 140px; margin-bottom: 5px; font-size: 13px; font-weight: bold; }
        input, select, textarea { background-color: #fff; border: 2px inset #eee; padding: 2px; font-family: 'Courier New'; font-size: 13px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .btn-win { background-color: #c0c0c0; border: 2px outset #fff; padding: 4px 15px; cursor: pointer; font-weight: bold; font-family: Arial; }
        .btn-win:active { border-style: inset; }
    </style>
</head>
<body>

<div class="window">
    <div class="title-bar">
        <span><img src="https://win98icons.alexmeub.com/icons/png/directory_open_file_mydocs-4.png" width="16" style="vertical-align:middle"> <?= $title ?></span>
        <div style="cursor:pointer" onclick="window.location='<?= site_url('clientes'); ?>'">[X]</div>
    </div>
    
    <div class="content">
        <form action="<?= $action ?>" method="POST">
            
            <fieldset>
                <legend>Identification & Location</legend>
                <label>Full Name:</label> <input type="text" name="nome_completo" style="width: 350px;" value="<?= $is_edit ? $cliente->nome_completo : '' ?>" required><br>
                <label>Nickname/Nick:</label> <input type="text" name="nick" style="width: 150px;" value="<?= $is_edit ? $cliente->nick : '' ?>">
                <label>Phone Line:</label> <input type="text" name="telefone" id="telefone" value="<?= $is_edit ? $cliente->telefone : '' ?>" placeholder="(00) 00000-0000"><br>
                
                <hr style="border: 0; border-top: 1px inset #fff; margin: 10px 0;">
                
                <label>Country:</label>
                <select name="pais" id="pais" onchange="limparEndereco()">
                    <option value="Brasil" <?= ($is_edit && $cliente->pais == 'Brasil') ? 'selected' : '' ?>>Brazil (BR)</option>
                    <option value="Japan" <?= ($is_edit && $cliente->pais == 'Japan') ? 'selected' : '' ?>>Japan (JP)</option>
                </select>
                <label style="width: 70px; margin-left: 20px;">Zip/CEP:</label> 
                <input type="text" name="cep" id="cep" onblur="buscarEndereco()" style="width: 100px;" value="<?= $is_edit ? $cliente->cep : '' ?>">
                <br>
                
                <label>City/Prefecture:</label> <input type="text" name="cidade_provincia" id="cidade_provincia" style="width: 250px;" value="<?= $is_edit ? $cliente->cidade_provincia : '' ?>">
                <label style="width: 80px; margin-left: 10px;">District:</label> <input type="text" name="bairro" id="bairro" style="width: 175px;" value="<?= $is_edit ? $cliente->bairro : '' ?>"><br>
                
                <label>Address:</label> <input type="text" name="endereco" id="endereco" style="width: 535px;" value="<?= $is_edit ? $cliente->endereco : '' ?>">
            </fieldset>

            <fieldset>
                <legend>Vehicle Technical Specs</legend>
                <div class="grid">
                    <div>
                        <label>Maker/Brand:</label> <input type="text" name="carro_fabricante" value="<?= $is_edit ? $cliente->carro_fabricante : '' ?>"><br>
                        <label>Model:</label> <input type="text" name="carro_modelo" value="<?= $is_edit ? $cliente->carro_modelo : '' ?>"><br>
                        <label>Year:</label> <input type="number" name="carro_ano" style="width: 80px;" value="<?= $is_edit ? $cliente->carro_ano : '' ?>"><br>
                        <label>Chassis ID:</label> <input type="text" name="carro_chassi" value="<?= $is_edit ? $cliente->carro_chassi : '' ?>"><br>
                        <label>Engine:</label> <input type="text" name="carro_motor" value="<?= $is_edit ? $cliente->carro_motor : '' ?>">
                    </div>
                    <div>
                        <label>Transmission:</label>
                        <select name="carro_cambio" style="width: 155px;">
                            <option value="Manual" <?= ($is_edit && $cliente->carro_cambio == 'Manual') ? 'selected' : '' ?>>Manual</option>
                            <option value="Automatic" <?= ($is_edit && $cliente->carro_cambio == 'Automatic') ? 'selected' : '' ?>>Automatic</option>
                        </select><br>
                        <label>Induction:</label>
                        <select name="carro_turbo" style="width: 155px;">
                            <option value="Aspirado" <?= ($is_edit && $cliente->carro_turbo == 'Aspirado') ? 'selected' : '' ?>>Aspirado</option>
                            <option value="Turbo" <?= ($is_edit && $cliente->carro_turbo == 'Turbo') ? 'selected' : '' ?>>Turbo</option>
                            <option value="Supercharger" <?= ($is_edit && $cliente->carro_turbo == 'Supercharger') ? 'selected' : '' ?>>Supercharger</option>
                        </select><br>
                        <label>ECU/System:</label> <input type="text" name="carro_ecu" value="<?= $is_edit ? $cliente->carro_ecu : '' ?>"><br>
                        <label>Suspension:</label> <input type="text" name="carro_suspensao" value="<?= $is_edit ? $cliente->carro_suspensao : '' ?>"><br>
                        <label>Wheels/Tires:</label> <input type="text" name="carro_rodas" value="<?= $is_edit ? $cliente->carro_rodas : '' ?>">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Usage & Observations</legend>
                <input type="checkbox" name="uso_drift" id="d" value="1" <?= ($is_edit && $cliente->uso_drift) ? 'checked' : '' ?>> <label for="d" style="width: auto;">Drift</label> &nbsp;&nbsp;
                <input type="checkbox" name="uso_track_day" id="t" value="1" <?= ($is_edit && $cliente->uso_track_day) ? 'checked' : '' ?>> <label for="t" style="width: auto;">Track Day</label> &nbsp;&nbsp;
                <input type="checkbox" name="uso_rua" id="r" value="1" <?= ($is_edit && $cliente->uso_rua) ? 'checked' : '' ?>> <label for="r" style="width: auto;">Street</label> &nbsp;&nbsp;
                <input type="checkbox" name="uso_competicao" id="c" value="1" <?= ($is_edit && $cliente->uso_competicao) ? 'checked' : '' ?>> <label for="c" style="width: auto;">Competition</label>
                <br><br>
                <textarea name="observacoes" rows="4" style="width: 98%;" placeholder="Additional technical notes..."><?= $is_edit ? $cliente->observacoes : '' ?></textarea>
            </fieldset>

            <div style="text-align: right; padding-top: 10px;">
                <button type="button" class="btn-win" onclick="window.location.href='<?= site_url('clientes'); ?>'">Cancel</button>
                <button type="submit" class="btn-win"><?= $is_edit ? '[ UPDATE_RECORD ]' : '[ REGISTER_ENTRY ]' ?></button>
            </div>
        </form>
    </div>
</div>

<script>
// Máscara de Telefone
document.getElementById('telefone').addEventListener('input', function (e) {
    let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
    if (!x) return;
    e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
});

async function buscarEndereco() {
    const pais = document.getElementById('pais').value;
    const cepInput = document.getElementById('cep');
    const cepValue = cepInput.value.replace(/\D/g, '');

    // BRASIL (ViaCEP)
    if (pais === 'Brasil' && cepValue.length === 8) {
        fetch(`https://viacep.com.br/ws/${cepValue}/json/`)
            .then(res => res.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('cidade_provincia').value = data.localidade + ' / ' + data.uf;
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('endereco').value = data.logradouro || '';
                }
            });
    } 
    // JAPÃO (ZipCloud + MyMemory Translation)
    else if (pais === 'Japan' && cepValue.length === 7) {
        try {
            const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${cepValue}`);
            const data = await response.json();

            if (data.results && data.results[0]) {
                const res = data.results[0];
                const cityText = `${res.address1} ${res.address2}`;
                const neighborhoodText = res.address3;
                
                // Tradução Cidade
                const transCity = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(cityText)}&langpair=ja|en`);
                const cityData = await transCity.json();
                
                // Tradução Bairro
                const transNeighborhood = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(neighborhoodText)}&langpair=ja|en`);
                const neighborhoodData = await transNeighborhood.json();

                document.getElementById('cidade_provincia').value = cityData.responseData.translatedText || cityText;
                
                let bairroTraduzido = neighborhoodData.responseData.translatedText;
                if (!bairroTraduzido || bairroTraduzido.includes("MYMEMORY")) {
                    bairroTraduzido = res.address3;
                }
                document.getElementById('bairro').value = bairroTraduzido;
                document.getElementById('endereco').value = 'Zip Code Area: ' + cepValue; 
            }
        } catch (err) {
            console.error("Fetch Error:", err);
        }
    }
}

function limparEndereco() {
    document.getElementById('cep').value = '';
    document.getElementById('cidade_provincia').value = '';
    document.getElementById('bairro').value = '';
    document.getElementById('endereco').value = '';
}
</script>

</body>
</html>