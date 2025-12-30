<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Inteligência de Inventário e Catálogo
 */
class Logistica_model extends CI_Model {

    public function registrar_no_catalogo($data) {
        return $this->db->insert('catalogo_produtos', $data);
    }

    public function listar_catalogo() {
        $this->db->order_by('nome_produto', 'ASC');
        return $this->db->get('catalogo_produtos')->result();
    }

    public function listar_estoque_geral() {
        $this->db->select('e.*, c.nome_produto, c.codigo_sku');
        $this->db->from('estoque_v2 e');
        $this->db->join('catalogo_produtos c', 'c.id = e.id_catalogo');
        $this->db->order_by('e.rua, e.posicao', 'ASC');
        return $this->db->get()->result();
    }
}