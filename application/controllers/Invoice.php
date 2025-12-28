<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Verifica se o usuário está logado
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    public function index() {
    $dados['pagina_ativa'] = 'invoice'; 
    $dados['produtos_catalogo'] = $this->Estoque_model->listar_catalogo();
    
    // Nova linha: busca o histórico de notas
    $dados['historico_notas'] = $this->Estoque_model->listar_historico_invoices();
    
    $this->load->view('v_header', $dados);
    $this->load->view('v_invoice_novo', $dados);
}

    public function salvar() {
    // 1. Salva o cabeçalho
    $invoice_data = [
        'numero_nota'      => $this->input->post('numero_nota'),
        'fornecedor'       => $this->input->post('fornecedor'),
        'valor_total_nota' => $this->input->post('valor_total_nota'),
        'data_emissao'     => date('Y-m-d') // Registra a data atual do sistema
    ];
    
    $id_invoice = $this->Estoque_model->salvar_invoice($invoice_data);

    // 2. Salva os itens que o JavaScript enviou como array
    $ids_produtos = $this->input->post('prod_id');
    $quantidades  = $this->input->post('prod_qtd');
    $lotes        = $this->input->post('prod_lote');

    if (!empty($ids_produtos)) {
        for ($i = 0; $i < count($ids_produtos); $i++) {
            $item_data = [
                'id_invoice'      => $id_invoice,
                'id_catalogo'     => $ids_produtos[$i],
                'quantidade'      => $quantidades[$i],
                'lote'            => $lotes[$i],
                'status_alocacao' => 'Pendente'
            ];
            $this->Estoque_model->salvar_invoice_item($item_data);
        }
    }

    redirect('estoque');
}

public function deletar($numero_nota) {
    // 1. Primeiro, precisamos descobrir qual é o ID da nota 
    // porque o invoice_items usa o ID e não o número.
    $this->db->where('numero_nota', $numero_nota);
    $nota = $this->db->get('invoices')->row();

    if (!$nota) {
        $this->session->set_flashdata('erro', 'Invoice not found.');
        redirect('invoice');
        return;
    }

    $id_da_nota = $nota->id; // Aqui pegamos o ID (1, 2, 3...)

    // 2. Verificação de segurança: checa se algum item já foi para o estoque físico
    // Usamos o numero_nota aqui porque no estoque_v2  gravou como 'origem_nota'
    $this->db->where('origem_nota', $numero_nota);
    $estoque = $this->db->get('estoque_v2')->num_rows();

    if ($estoque > 0) {
        $this->session->set_flashdata('erro', 'Cannot delete! Items are already in Physical Stock.');
    } else {
        // 3. Deleta os itens usando o ID que descobrimos no passo 1
        $this->db->where('id_invoice', $id_da_nota); 
        $this->db->delete('invoice_items');

        // 4. Deleta a nota principal usando o número dela
        $this->db->where('numero_nota', $numero_nota);
        $this->db->delete('invoices');
        
        $this->session->set_flashdata('sucesso', 'Invoice #' . $numero_nota . ' purged successfully.');
    }
    
    redirect('invoice');
}
















}



