<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logado')) {
            redirect('login');
        }
        $this->load->model('usuario_model');
    }

    public function index() {
        // 1. Busca os dados no banco
        $dados['usuarios'] = $this->usuario_model->listar_todos();
        
        // 2. Define a aba ativa como 'usuarios'
        $dados['pagina_ativa'] = 'usuarios';
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_usuarios', $dados);
    }

    public function novo() {
        $dados['pagina_ativa'] = 'usuarios';
        $this->load->view('v_header', $dados);
        $this->load->view('v_form_usuario');
    }
    
    public function salvar() {
        $data = array(
            'nome'      => $this->input->post('nome'),
            'sobrenome' => $this->input->post('sobrenome'),
            'email'     => $this->input->post('email'),
            'nivel'     => $this->input->post('nivel'),
            'senha'     => password_hash($this->input->post('senha'), PASSWORD_BCRYPT)
        );

        $this->usuario_model->salvar_novo($data);
        redirect('usuarios');
    }
}