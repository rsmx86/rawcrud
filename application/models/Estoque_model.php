<?php
class Estoque_model extends CI_Model {

    // Lista o estoque físico real
    public function listar_estoque_geral() {
        if (!$this->db->table_exists('estoque_v2')) return array(); 

        $this->db->select('e.*, c.nome_produto, c.codigo_sku as codigo_produto');
        $this->db->from('estoque_v2 e');
        $this->db->join('catalogo_produtos c', 'c.id = e.id_catalogo');
        return $this->db->get()->result();
    }

    // Lista apenas os produtos cadastrados no catálogo
    public function listar_catalogo() {
        return $this->db->get('catalogo_produtos')->result();
    }
    
    public function inserir_catalogo($data) {
        return $this->db->insert('catalogo_produtos', $data);
    }

    public function buscar_produto_catalogo($id) {
        return $this->db->get_where('catalogo_produtos', array('id' => $id))->row();
    }

    public function atualizar_catalogo($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('catalogo_produtos', $data);
    }

    public function eliminar_catalogo($id) {
        $this->db->where('id', $id);
        return $this->db->delete('catalogo_produtos');
    }

    // --- INVOICE METHODS ---

    public function salvar_invoice($data) {
    // Verifica se já existe uma nota com esse número
    $this->db->where('numero_nota', $data['numero_nota']);
    $query = $this->db->get('invoices');

    if ($query->num_rows() > 0) {
        // Se já existe, você pode retornar falso ou disparar um erro amigável
        // Aqui vamos apenas dar um stop para não quebrar o SQL
        die("<script>alert('ERROR: Invoice # " . $data['numero_nota'] . " already exists in system!'); history.back();</script>");
    }

    $this->db->insert('invoices', $data);
    return $this->db->insert_id();
}

    public function salvar_invoice_item($data) {
        return $this->db->insert('invoice_items', $data);
    }

    public function buscar_itens_pendentes_nota($numero_nota) {
        $this->db->select('ii.*, c.nome_produto');
        $this->db->from('invoice_items ii');
        $this->db->join('invoices i', 'i.id = ii.id_invoice');
        $this->db->join('catalogo_produtos c', 'c.id = ii.id_catalogo');
        $this->db->where('i.numero_nota', $numero_nota);
        $this->db->where('ii.status_alocacao', 'Pendente');
        return $this->db->get()->result();
    }

    public function finalizar_alocacao($data_estoque, $id_item_nota) {
        $this->db->insert('estoque_v2', $data_estoque);
        $this->db->where('id', $id_item_nota);
        return $this->db->update('invoice_items', array('status_alocacao' => 'Concluido'));
    }


    public function listar_historico_invoices() {
        $this->db->order_by('data_emissao', 'DESC');
        $this->db->limit(10); // Mostra as últimas 10 notas para não poluir a tela
        return $this->db->get('invoices')->result();
}



public function posicao_esta_livre($rua, $posicao) {
    $this->db->where('rua', $rua);
    $this->db->where('posicao', $posicao);
    $query = $this->db->get('estoque_v2');
    
    // Retorna TRUE se não encontrar nada (está livre)
    return $query->num_rows() === 0;
}






}