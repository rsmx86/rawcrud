<center>
    <br>
    <table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" style="border: 2px solid #FFFFFF; border-right: 3px solid #808080; border-bottom: 3px solid #808080;">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#000080">
                    <tr>
                        <td>&nbsp;<font face="Arial" size="2" color="#FFFFFF"><b>Operator_Management_Console_v0.4.1</b></font></td>
                        <td align="right"><font face="Arial" size="2" color="#FFFFFF"><b>[ ? ] [ X ]</b></font>&nbsp;</td>
                    </tr>
                </table>

                <table width="100%" border="0" cellpadding="20" cellspacing="0" bgcolor="#D6D2C4">
                    <tr>
                        <td>
                            <font face="Arial Black" size="5" color="#000080">OPERATOR_DATABASE</font>
                            <hr size="1" color="#808080" noshade>
                            <br>

                            <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#808080">
                                <tr bgcolor="#C0C0C0">
                                    <td><font face="Arial" size="3"><b>Name</b></font></td>
                                    <td><font face="Arial" size="3"><b>Nick</b></font></td>
                                    <td><font face="Arial" size="3"><b>Rank</b></font></td>
                                    <td><font face="Arial" size="3"><b>Last_Login</b></font></td>
                                    <td align="center"><font face="Arial" size="3"><b>Operations</b></font></td>
                                </tr>

                                <?php if(!empty($usuarios)): ?>
                                    <?php foreach($usuarios as $user): ?>
                                    <tr bgcolor="#FFFFFF">
                                        <td><font face="Courier New" size="3" title="Operator Email: <?= $user->email; ?>" style="cursor: help;">
        <?= $user->nome; ?>
    </font></td>
                                        <td><font face="Courier New" size="3"><b><?= $user->nick; ?></b></font></td>
                                        <td><font face="Courier New" size="2"><?= $user->nivel; ?></font></td>
                                        <td><font face="Courier New" size="2">
                                            <?= ($user->ultimo_acesso) ? date('d/m/Y H:i', strtotime($user->ultimo_acesso)) : '---'; ?>
                                        </font></td>
                                        
                                        <td align="center">
                                            <?php if ($this->session->userdata('nivel') === 'Garage Chief'): ?>
                                                <button onclick="window.location='<?= site_url('usuarios/editar/'.$user->id); ?>'" style="width:70px; height:25px; font-family:Arial; font-size:11px; cursor:pointer;">Edit</button>
                                                
                                                <?php if ($user->id !== $this->session->userdata('id_usuario')): ?>
                                                    <button onclick="if(confirm('TERMINATE REGISTRY?')) window.location='<?= site_url('usuarios/excluir/'.$user->id); ?>'" 
                                                        style="width:70px; height:25px; font-family:Arial; font-size:11px; cursor:pointer; color:darkred; background:#C0C0C0; border: 2px solid #FFFFFF; border-right:2px solid #5A5A5A; border-bottom:2px solid #5A5A5A;">
                                                        Delete
                                                    </button>
                                                <?php else: ?>
                                                    <font face="Arial" size="1" color="#000080"><b></b></font>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <font face="Courier New" size="3" color="#808080"><b>[READ_ONLY]</b></font>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </table>

                            <br>
                            <div align="right">
                                <?php if ($this->session->userdata('nivel') === 'Garage Chief'): ?>
                                    <button onclick="window.location='<?= site_url('usuarios/novo'); ?>'" style="width:210px; height:45px; font-family:Arial; font-size:13px; font-weight:bold; cursor:pointer; background:#C0C0C0; border: 2px solid #FFFFFF; border-right:2px solid #5A5A5A; border-bottom:2px solid #5A5A5A;">
                                        [ + ] ADD_NEW_OPERATOR
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>