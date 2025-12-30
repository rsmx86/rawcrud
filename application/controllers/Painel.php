<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Painel Administrativo Principal
 * Gerencia a tela de boas-vindas e encerramento de sessão.
 */
class Painel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // SEGURANÇA JDM: Verifica se o operador está autenticado
        if (!$this->session->userdata('logado')) {
            redirect('login?erro=2');
        }
        
        $this->load->model('usuario_model');
    }

    /**
     * Tela Inicial do Sistema (Dashboard)
     */
    public function index() {
        // Controle de UI: Define a aba selecionada no Header
        $dados['pagina_ativa'] = 'dashboard';
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_painel', $dados); // v_painel é a view Windows NT style
    }

    /**
     * Terminar Sessão do Operador
     */
    public function sair() {
        $this->session->sess_destroy();
        redirect('login');
    }
}