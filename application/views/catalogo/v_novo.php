<h2>Cadastro de Produto no Catálogo</h2>

<form action="<?php echo site_url('catalogo/salvar'); ?>" method="post">
    
    <label>Código SKU (Único):</label><br>
    <input type="text" name="sku" required><br><br>

    <label>Nome do Produto:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Fabricante / Marca:</label><br>
    <input type="text" name="fabricante"><br><br>

    <label>Unidade de Medida:</label><br>
    <select name="unidade">
        <option value="UN">Unidade (UN)</option>
        <option value="PC">Peça (PC)</option>
        <option value="KG">Quilo (KG)</option>
        <option value="CX">Caixa (CX)</option>
    </select><br><br>

    <button type="submit">SALVAR PRODUTO NO CATÁLOGO</button>
    <a href="<?php echo site_url('catalogo'); ?>">VOLTAR</a>

</form>