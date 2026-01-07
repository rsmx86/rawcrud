<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-history"></i> Logs do Sistema (Auditoria)</h5>
            <span class="badge badge-light"><?php echo count($logs); ?> registros</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="tabela_logs">
                    <thead class="thead-light">
                        <tr>
                            <th>Data/Hora</th>
                            <th>Operador</th>
                            <th>Ação</th>
                            <th>Tabela</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($logs)): ?>
                            <?php foreach($logs as $log): ?>
                                <tr>
                                    <td class="small"><?php echo date('d/m/Y H:i:s', strtotime($log->data_hora)); ?></td>
                                    <td><strong><?php echo $log->usuario_nome; ?></strong> <small class="text-muted">(ID: <?php echo $log->id_usuario; ?>)</small></td>
                                    <td><span class="badge badge-info"><?php echo $log->acao; ?></span></td>
                                    <td><code><?php echo $log->tabela_afetada; ?></code></td>
                                    <td><?php echo $log->detalhes; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhum log registrado ainda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>