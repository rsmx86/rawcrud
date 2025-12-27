<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    // funcao para verificar login
    public function logar($email, $senha) {
        $this->db->where('email', $email);
        $this->db->where('senha', $senha); //depois mudamos para criptografia
        $query = $this->db->get('usuarios');

        if ($query->num_rows() == 1) {
            return $query->row(); // Retorna os dados do usuário se achar
        } else {
            return false; // Retorna falso se não achar nada
        }
    }

    // Função para o ADM listar todos os usuários
    public function listar_todos() {
        return $this->db->get('usuarios')->result();
    }
}