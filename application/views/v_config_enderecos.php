<div style="padding: 15px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <button onclick="window.location.href='<?= site_url('configuracoes') ?>'" style="background:#C0C0C0; border: 2px solid #FFFFFF; border-right-color: #808080; border-bottom-color: #808080; cursor:pointer; padding:2px 10px;">
                    <b>< BACK</b>
                </button>
                <br><br>
                <font face="Arial" size="4"><b>Storage_Infrastructure_Management</b></font>
                <hr size="1" color="#808080" noshade>
            </td>
        </tr>
    </table>

    <br>

    <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#808080">
        <tr bgcolor="#C0C0C0">
            <td width="20%"><font face="Arial" size="2"><b>LOCATION (R/P)</b></font></td>
            <td width="30%"><font face="Arial" size="2"><b>CURRENT_ITEM</b></font></td>
            <td width="20%"><font face="Arial" size="2"><b>STATUS</b></font></td>
            <td width="30%"><font face="Arial" size="2"><b>ADMIN_ACTION</b></font></td>
        </tr>

        <?php if(empty($posicoes)): ?>
            <tr bgcolor="#FFFFFF">
                <td colspan="4" align="center"><font face="Arial" size="2" color="gray">No active slots found in database.</font></td>
            </tr>
        <?php else: ?>
            <?php foreach($posicoes as $p): ?>
                <?php 
                    $cor_status = "#FFFFFF";
                    if($p->status_posicao == 'NON_COMPLIANCE') $cor_status = "#FFFF00"; // Amarelo
                    if($p->status_posicao == 'QUARANTINE') $cor_status = "#FF8080"; // Vermelho claro
                ?>
                <tr bgcolor="<?= $cor_status ?>">
                    <td><font face="Arial" size="2">RUA: <b><?= $p->rua ?></b> / POS: <b><?= $p->posicao ?></b></font></td>
                    <td><font face="Arial" size="2"><?= $p->id_catalogo ?> (Lot: <?= $p->lote ?>)</font></td>
                    <td align="center">
                        <font face="Arial" size="1"><b>[ <?= $p->status_posicao ?> ]</b></font>
                    </td>
                    <td>
                        <select onchange="if(this.value!='') window.location.href='<?= site_url('configuracoes/mudar_status/'.$p->id.'/') ?>' + this.value" style="font-family: Arial; font-size: 10px;">
                            <option value="">-- Change State --</option>
                            <option value="ACTIVE">✅ ACTIVE (Normal)</option>
                            <option value="NON_COMPLIANCE">⚠️ NON_COMPLIANCE</option>
                            <option value="QUARANTINE">☢️ QUARANTINE</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>