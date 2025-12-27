<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // SEGURANÇA JDM: Se não houver sessão ativa, expulsa para o login
        if (!$this->session->userdata('logado')) {
            redirect('login?erro=2');
        }
        
        $this->load->model('usuario_model');
    }

    public function index() {
        // Definimos qual aba está ativa para o Header
        $dados['pagina_ativa'] = 'dashboard';
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_painel');
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect('login');
    }
}