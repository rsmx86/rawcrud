<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Persistência de Dados: Clientes e Veículos
 */
class Cliente_model extends CI_Model {

    /**
     * Insere novo registro de cliente
     */
    public function salvar($data) {
        return $this->db->insert('clientes', $data);
    }

    /**
     * Retorna lista alfabética de todos os clientes
     */
    public function listar_todos() {
        $this->db->order_by('nome_completo', 'ASC');
        return $this->db->get('clientes')->result();
    }

    public function listar_clientes() {
    return $this->db->get('clientes')->result(); // C
}

}