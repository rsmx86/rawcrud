<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    // Seu método de logar (mantenha como está)
    public function logar($email, $senha) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');

        if ($query->num_rows() == 1) {
            $usuario = $query->row();
            if (password_verify($senha, $usuario->senha)) {
                return $usuario;
            }
        }
        return false;
    }

     /**
     * Lista todos os operadores para a tabela do Windows NT
     */
    public function listar_todos() {
        return $this->db->get('usuarios')->result();
    }

    /**
     * Salva o novo operador vindo da "Ficha de Registro"
     */
    public function salvar_novo($dados) {
        return $this->db->insert('usuarios', $dados);
    }
}