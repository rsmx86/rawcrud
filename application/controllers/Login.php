<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        // Carrega a tela de login (View) que vamos criar já já
        $this->load->view('v_login');
    }

    public function autenticar() {
        $this->load->model('usuario_model');
        
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        $usuario = $this->usuario_model->logar($email, $senha);

        if ($usuario) {
            // Se logou, guarda os dados na SESSÃO
            $dados_sessao = array(
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'nivel' => $usuario->nivel,
                'logado' => TRUE
            );
            $this->session->set_userdata($dados_sessao);
            
            echo "Logado com sucesso! Bem-vindo, " . $usuario->nome;
            // No futuro, aqui redirecionamos para o painel
        } else {
            echo "E-mail ou senha incorretos.";
        }
    }
}