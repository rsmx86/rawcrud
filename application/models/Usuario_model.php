<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function logar($email, $senha) {
        // Busca apenas pelo e-mail
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');

        // Se achou o e-mail, verifica a senha
        if ($query->num_rows() == 1) {
            $usuario = $query->row();

            // O PHP "descriptografa" e compara aqui:
            if (password_verify($senha, $usuario->senha)) {
                return $usuario;
            }
        }
        return false;
    }
}