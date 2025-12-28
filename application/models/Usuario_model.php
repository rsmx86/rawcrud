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
    // Ordem personalizada: Garage Chief (1º), Chief Mechanic (2º), Mechanic (3º)
    $this->db->order_by("FIELD(nivel, 'Garage Chief', 'Chief Mechanic', 'Mechanic')");
    return $this->db->get('usuarios')->result();
}

    /**
     * Salva o novo operador vindo da "Ficha de Registro"
     */
    public function salvar_novo($dados) {
        return $this->db->insert('usuarios', $dados);
    }

    public function inserir($dados) {
    return $this->db->insert('usuarios', $dados);
}

public function buscar_por_id($id) {
    $this->db->where('id', $id);
    return $this->db->get('usuarios')->row(); // row() retorna apenas um objeto
}

public function atualizar($id, $dados) {
    $this->db->where('id', $id);
    return $this->db->update('usuarios', $dados);
}

public function deletar($id) {
    $this->db->where('id', $id);
    return $this->db->delete('usuarios');
}


}