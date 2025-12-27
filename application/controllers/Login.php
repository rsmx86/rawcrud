<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Anotações para o editor reconhecer as bibliotecas do CodeIgniter (IntelliSense)
 * @property Usuario_model $usuario_model Instância do nosso modelo de usuário
 * @property CI_Input $input Biblioteca de tratamento de dados de entrada (POST/GET)
 * @property CI_Session $session Biblioteca de gerenciamento de sessões
 * @property CI_Loader $load Biblioteca que carrega arquivos (views/models)
 */

class Login extends CI_Controller {

    // Exibe tela de login e captura erro da URL
    public function index() {
        $data['erro'] = $this->input->get('erro');
        $this->load->view('v_login', $data);
    }

    // Processa a tentativa de login
    public function autenticar() {
        $this->load->model('usuario_model');
        
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        $usuario = $this->usuario_model->logar($email, $senha);

        if ($usuario) {
            // Configura os dados da sessão (Crachá)
            $this->session->set_userdata([
                'nome'   => $usuario->nome,
                'nivel'  => $usuario->nivel,
                'logado' => TRUE
            ]);
            redirect(site_url('painel')); 
        } else {
            // Falha: Redireciona com flag de erro
            redirect(site_url('login?erro=1'));
        }
    }

    // Destrói a sessão e volta para o início
    public function sair() {
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }
}