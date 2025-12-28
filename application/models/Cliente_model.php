<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function salvar($data) {
        return $this->db->insert('clientes', $data);
    }

    public function listar_todos() {
        $this->db->order_by('nome_completo', 'ASC');
        return $this->db->get('clientes')->result();
    }
}