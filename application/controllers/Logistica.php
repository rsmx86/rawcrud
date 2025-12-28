<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistica extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Logistica_model');
    }

    // Tela Principal do Estoque (Visão das Prateleiras)
    public function estoque() {
        $dados['ativa'] = 'estoque'; // Para o Header acender a aba
        $dados['itens'] = $this->Logistica_model->listar_estoque_geral();
        $this->load->view('v_header', $dados);
        $this->load->view('v_estoque_lista', $dados);
    }

    
// 2. Visão do Catálogo (Administrativo)
public function catalog() {
    $dados['ativa'] = 'catalog';
    $dados['produtos'] = $this->Logistica_model->listar_catalogo();
    $this->load->view('v_header', $dados);
    $this->load->view('v_catalog_list', $dados);
}


// 1. Visão do Inventário (Prateleiras)
public function inventory() {
    $dados['ativa'] = 'inventory'; 
    $dados['itens'] = $this->Logistica_model->listar_estoque_geral();
    $this->load->view('v_header', $dados);
    $this->load->view('v_inventory_list', $dados);
}
