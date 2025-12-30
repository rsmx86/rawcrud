<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    public function index() {
        $dados['produtos'] = $this->Estoque_model->get_catalogo();
        $this->load->view('v_header');
        $this->load->view('catalogo/v_lista', $dados);
    }

    public function novo() {
        $this->load->view('v_header');
        $this->load->view('catalogo/v_novo');
    }

    public function salvar() {
        $data = [
            'codigo_sku'   => strtoupper($this->input->post('sku')),
            'nome_produto' => strtoupper($this->input->post('nome')),
            'fabricante'   => strtoupper($this->input->post('fabricante')),
            'unidade_medida' => $this->input->post('unidade')
        ];

        if ($this->Estoque_model->salvar_produto($data)) {
            redirect('catalogo');
        } else {
            die("Erro ao salvar: SKU possivelmente duplicado.");
        }
    }
}