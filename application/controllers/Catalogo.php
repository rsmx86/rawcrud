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
        $dados['pagina_ativa'] = 'catalogo/v_lista';
        $this->load->view('v_header', $dados);
        $this->load->view('catalogo/v_lista', $dados);
    }

    public function novo() {
        $dados['pagina_ativa'] = 'catalogo/v_novo';
        $this->load->view('v_header', $dados);
        $this->load->view('catalogo/v_novo', $dados);
    }

    public function salvar() {
    $data = [
        'codigo_sku'     => strtoupper($this->input->post('codigo_sku')),
        'nome_produto'   => strtoupper($this->input->post('nome_produto')),
        'fabricante'     => strtoupper($this->input->post('fabricante')),
        'unidade_medida' => $this->input->post('unidade_medida'),
        'valor_unitario' => $this->input->post('valor_unitario')
    ];

    // Validação simples para não salvar vazio
    if (empty($data['codigo_sku']) || empty($data['nome_produto'])) {
        die("Erro: SKU e Nome são obrigatórios.");
    }

    if ($this->Estoque_model->salvar_produto($data)) {
        // 
        $this->Estoque_model->registrar_log("Criou produto", "catalogo_produtos", $data['nome_produto']);
        
        redirect('catalogo');
    } else {
        die("Erro ao salvar no banco de dados.");
    }
}

    public function editar($id) {
        $this->db->where('id', $id);
        $dados['pagina_ativa'] = 'catalogo/lista'; 
        $dados['produto'] = $this->db->get('catalogo_produtos')->row();
        
        if(!$dados['produto']) {
            echo "<script>alert('Record not found!'); window.location.href='" . site_url('catalogo') . "';</script>";
            return;
        }

        $this->load->view('v_header', $dados);
        $this->load->view('catalogo/v_editar', $dados);
    }


    public function excluir($id) {
    // 1. Verifica se o ID foi passado para evitar erros
    if ($id) {
        // 2. Define qual registro será apagado
        $this->db->where('id', $id);
        
        // 3. Executa a exclusão na tabela correta
        $this->db->delete('catalogo_produtos');
    }

    // 4. Redireciona de volta para a lista com a página atualizada
    redirect('catalogo');
}



    public function atualizar() {
    $id = $this->input->post('id');
    
    $data = [
        'codigo_sku'     => $this->input->post('codigo_sku'),
        'nome_produto'   => $this->input->post('nome_produto'),
        'fabricante'     => $this->input->post('fabricante'),
        'unidade_medida' => $this->input->post('unidade_medida'),
        'valor_unitario' => $this->input->post('valor_unitario')
    ];

    $this->db->where('id', $id);
    $this->db->update('catalogo_produtos', $data);
    
    redirect('catalogo');
}


}

