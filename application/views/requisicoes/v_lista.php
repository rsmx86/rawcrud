<style>
    #searchPanel { display: none; background: #D6D2C4; border: 2px solid #808080; padding: 10px; margin: 10px auto; width: 98%; box-shadow: inset 1px 1px #FFF, inset -1px -1px #000; }
    .filter-label { font-family: Arial; font-size: 10px; font-weight: bold; color: #000; display: block; margin-bottom: 2px; }
    .btn-plus { background: #C0C0C0; border: 2px solid; border-color: #FFF #808080 #808080 #FFF; cursor: pointer; padding: 3px 10px; font-family: Arial; font-size: 11px; font-weight: bold; }
    .btn-plus:active { border-color: #808080 #FFF #FFF #808080; }
    input[type="text"], input[type="date"], select { font-family: 'Courier New'; font-size: 12px; border: 1px solid #808080; }
</style>

<center>
    <div style="width:98%; text-align:left; margin-bottom:5px;">
        <button class="btn-plus" onclick="toggleSearch()">[+] FILTER_RECORDS</button>
    </div>

    <div id="searchPanel">
        <form action="<?= site_url("requisicoes/index") ?>" method="GET">
            <table width="100%" border="0" cellspacing="5">
                <tr>
                    <td width="25%">
                        <span class="filter-label">BATCH_ID (LOTE):</span>
                        <input type="text" name="lote" value="<?= $this->input->get(
                            "lote"
                        ) ?>" style="width:100%" placeholder="Search lote...">
                    </td>
                    <td width="25%">
                        <span class="filter-label">CLIENT_NAME:</span>
                        <select name="cliente" style="width:100%">
                            <option value="">-- ALL_CLIENTS --</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c->id ?>" <?= $this->input->get(
    "cliente"
) == $c->id
    ? "selected"
    : "" ?>>
                                    <?= strtoupper($c->nome_completo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td width="20%">
                        <span class="filter-label">FROM_DATE:</span>
                        <input type="date" name="data_inicio" value="<?= $this->input->get(
                            "data_inicio"
                        ) ?>" style="width:100%">
                    </td>
                    <td width="20%">
                        <span class="filter-label">TO_DATE:</span>
                        <input type="date" name="data_fim" value="<?= $this->input->get(
                            "data_fim"
                        ) ?>" style="width:100%">
                    </td>
                    <td width="10%" align="right" valign="bottom">
                        <button type="submit" style="width:100%; background:#000080; color:#FFF; font-size:10px; height:22px; cursor:pointer;"><b>[EXE]</b></button>
                        <button type="button" onclick="window.location.href='<?= site_url(
                            "requisicoes"
                        ) ?>'" style="width:100%; background:#800000; color:#FFF; font-size:10px; height:20px; margin-top:2px; cursor:pointer;"><b>[CLR]</b></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <table width="98%" border="2" cellspacing="0" cellpadding="2" bgcolor="#000000">
        <tr bgcolor="#000080">
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>📂 Requisitions_Explorer // C:\WMS\OUTBOUND\*.*</b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[?] [X]</b></font>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D6D2C4" style="padding:10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td>
                            <button onclick="window.location.href='<?= site_url(
                                "requisicoes/nova"
                            ) ?>'"><b>[ NEW_REQUEST ]</b></button>
                            <button onclick="window.location.href='<?= site_url(
                                "invoices"
                            ) ?>'"><b>[ UP_DIR ]</b></button>
                            <button onclick="window.location.href='<?= site_url(
                                "devolucao"
                            ) ?>'" style="background-color:#FFD700;"><b>[ RETURNS_DEVOLUCAO ]</b></button>
                        </td>
                    </tr>
                </table>

                <br>

                <table width="100%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#808080">
                    <thead>
                        <tr bgcolor="#C0C0C0">
                            <td width="5%"><font face="Arial" size="1"><b>ID</b></font></td>
                            <td width="10%" align="center"><font face="Arial" size="1"><b>CODE_6</b></font></td>
                            <td width="30%"><font face="Arial" size="1"><b>CLIENTE_NAME</b></font></td>
                            <td width="15%"><font face="Arial" size="1"><b>DATE_TIME</b></font></td>
                            <td width="15%" align="center"><font face="Arial" size="1"><b>STATUS</b></font></td>
                            <td width="25%" align="center"><font face="Arial" size="1"><b>ACTIONS</b></font></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requisicoes)): ?>
                            <?php foreach ($requisicoes as $r): ?>
                            <tr>
                                <td bgcolor="#F0F0F0" align="center"><font face="Courier New" size="2"><?= str_pad(
                                    $r->id,
                                    4,
                                    "0",
                                    STR_PAD_LEFT
                                ) ?></font></td>
                                <td align="center" bgcolor="#FFFFE1">
                                    <font face="Courier New" size="2"><b><?= $r->codigo_despacho
                                        ? $r->codigo_despacho
                                        : "------" ?></b></font>
                                </td>
                                <td><font face="Arial" size="2"><?= strtoupper(
                                    $r->nome_cliente
                                ) ?></font></td>
                                <td><font face="Arial" size="2"><?= date(
                                    "d/m/Y H:i",
                                    strtotime($r->data_requisicao)
                                ) ?></font></td>
                                <td align="center">
                                    <?php if (
                                        $r->status_requisicao == "FINALIZADA"
                                    ): ?>
                                        <font face="Arial" size="1" color="green"><b>[ FINALIZADA ]</b></font>
                                    <?php else: ?>
                                        <font face="Arial" size="1" color="#808000"><b>[ EM_ABERTO ]</b></font>
                                    <?php endif; ?>
                                </td>
                                <td align="center" bgcolor="#F0F0F0">
                                    <button onclick="window.location.href='<?= site_url(
                                        "requisicoes/detalhes/" . $r->id
                                    ) ?>'" style="font-size:10px;">[ OPEN ]</button>
                                    <?php if (
                                        $r->status_requisicao !== "FINALIZADA"
                                    ): ?>
                                        <button onclick="window.location.href='<?= site_url(
                                            "requisicoes/editar/" . $r->id
                                        ) ?>'" style="font-size:10px; color:blue;">[ EDIT ]</button>
                                        <button onclick="if(confirm('CANCELAR REGISTRO?')) window.location.href='<?= site_url(
                                            "requisicoes/deletar/" . $r->id
                                        ) ?>'" style="font-size:10px; color:red;">[ DEL ]</button>
                                    <?php else: ?>
                                        <font face="Arial" size="1" color="#808080"><b>(LOCKED)</b></font>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" align="center" bgcolor="#FFFFFF"><font face="Arial" size="2" color="red">NO_RECORDS_FOUND_WITH_CURRENT_FILTERS</font></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <br>
                <font face="Arial" size="1">Total: <?= count(
                    $requisicoes
                ) ?> object(s) in directory.</font>
            </td>
        </tr>
    </table>
</center>

<script>
function toggleSearch() {
    var x = document.getElementById("searchPanel");
    if (x.style.display === "none" || x.style.display === "") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>