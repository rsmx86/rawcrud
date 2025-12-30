<a href="<?php echo site_url('catalogo/novo'); ?>">CADASTRAR NOVO PRODUTO</a>

<br><br>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>SKU (CÓDIGO)</th>
            <th>PRODUTO</th>
            <th>FABRICANTE</th>
            <th>UNIDADE</th>
            <th>AÇÕES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($produtos as $p): ?>
        <tr>
            <td><?php echo $p->id; ?></td>
            <td><?php echo $p->codigo_sku; ?></td>
            <td><?php echo $p->nome_produto; ?></td>
            <td><?php echo $p->fabricante; ?></td>
            <td><?php echo $p->unidade_medida; ?></td>
            <td>
                <a href="<?php echo site_url('catalogo/editar/'.$p->id); ?>">EDITAR</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>