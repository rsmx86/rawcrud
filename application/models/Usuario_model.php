<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Gestão de Operadores e Autenticação
 */
class Usuario_model extends CI_Model
{
    public function logar($email, $senha)
    {
        $this->db->where("email", $email);
        $query = $this->db->get("usuarios");

        if ($query->num_rows() == 1) {
            $usuario = $query->row();
            // Validação de Hash (Segurança PHP 7+)
            if (password_verify($senha, $usuario->senha)) {
                return $usuario;
            }
        }
        return false;
    }

    public function listar_todos()
    {
        // Ordenação por hierarquia do WMS
        $this->db->order_by(
            "FIELD(nivel, 'Garage Chief', 'Chief Mechanic', 'Mechanic', 'ADM')"
        );
        return $this->db->get("usuarios")->result();
    }

    public function inserir($dados)
    {
        return $this->db->insert("usuarios", $dados);
    }

    public function buscar_por_id($id)
    {
        return $this->db->get_where("usuarios", ["id" => $id])->row();
    }

    public function atualizar($id, $dados)
    {
        $this->db->where("id", $id);
        return $this->db->update("usuarios", $dados);
    }

    public function deletar($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("usuarios");
    }
}
