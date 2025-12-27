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

    /**
     * Exibe a tela de login inicial
     * Captura eventuais erros de autenticação passados via GET
     */
    public function index() {
        $data['erro'] = $this->input->get('erro');
        $this->load->view('v_login', $data);
    }

    /**
     * Processa a tentativa de login do operador
     * Valida as credenciais e estabelece a hierarquia de acesso (Rank)
     */
    public function autenticar() {
        // Carrega o modelo de dados do usuário
        $this->load->model('usuario_model');
        
        // Captura os dados vindos do formulário (v_login)
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        // Consulta o banco de dados via Model
        $usuario = $this->usuario_model->logar($email, $senha);

        if ($usuario) {
            /**
             * SESSÃO ESTABELECIDA:
             * Aqui definimos o "Crachá Virtual" do usuário.
             * Se o campo 'nivel' estiver vazio no banco, o sistema assume 'Mechanic' por padrão.
             */
            $dados_sessao = [
                'nome'   => $usuario->nome,
                'nivel'  => (!empty($usuario->nivel)) ? $usuario->nivel : 'Mechanic',
                'logado' => TRUE
            ];

            $this->session->set_userdata($dados_sessao);

            // Redireciona para o Painel Principal (Workstation)
            redirect(site_url('painel')); 
        } else {
            /**
             * FALHA NA AUTENTICAÇÃO:
             * Redireciona de volta para o login com a flag de erro.
             */
            redirect(site_url('login?erro=1'));
        }
    }

    /**
     * Finaliza a sessão atual (Logoff)
     * Limpa todos os dados do 'Crachá' e retorna à tela de entrada
     */
    public function sair() {
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }
}