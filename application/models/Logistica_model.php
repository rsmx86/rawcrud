<?php
class Logistica_model extends CI_Model {

    // --- LÓGICA DE CATÁLOGO ---
    public function registrar_no_catalogo($data) {
        return $this->db->insert('catalogo_produtos', $data);
    }

    public function listar_catalogo() {
        return $this->db->get('catalogo_produtos')->result();
    }

    // --- LÓGICA DE ESTOQUE ---
    public function listar_estoque_geral() {
        $this->db->select('e.*, c.nome_produto, c.codigo_sku');
        $this->db->from('estoque_v2 e');
        $this->db->join('catalogo_produtos c', 'c.id = e.id_catalogo');
        return $this->db->get()->result();
    }
}