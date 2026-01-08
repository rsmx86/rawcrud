<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Controle de Acesso ao Terminal
 * Gerencia a autenticação e validação de credenciais.
 */
class Login extends CI_Controller
{
    public function index()
    {
        // Coleta códigos de erro via GET (1 = Dados inválidos, 2 = Acesso negado)
        $data["erro"] = $this->input->get("erro");
        $this->load->view("v_login", $data);
    }

    /**
     * Processa a Autenticação no Banco de Dados
     */
    public function autenticar()
    {
        $this->load->model("usuario_model");

        $email = $this->input->post("email");
        $senha = $this->input->post("senha");

        // Busca o usuário no Model
        $usuario = $this->usuario_model->logar($email, $senha);

        if ($usuario) {
            // REGISTRA O LOG DE ACESSO (Audit Trail)
            $this->db->where("id", $usuario->id);
            $this->db->update("usuarios", [
                "ultimo_acesso" => date("Y-m-d H:i:s"),
            ]);

            // ESTABELECE A SESSÃO GLOBAL DO SISTEMA
            $dados_sessao = [
                "id_usuario" => $usuario->id,
                "nome" => $usuario->nome,
                "nick" => $usuario->nick,
                "nivel" => !empty($usuario->nivel)
                    ? $usuario->nivel
                    : "Mechanic",
                "logado" => true,
            ];

            $this->session->set_userdata($dados_sessao);
            redirect("painel");
        } else {
            // Falha na autenticação
            redirect("login?erro=1");
        }
    }

    /**
     * Finaliza a sessão atual
     */
    public function sair()
    {
        $this->session->sess_destroy();
        redirect("login");
    }
}
