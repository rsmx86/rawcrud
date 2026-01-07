<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    public function index() {
        $dados['invoices'] = $this->db->order_by('id', 'DESC')->get('invoices')->result();
        $dados['pagina_ativa'] = 'invoice';
        $this->load->view('v_header', $dados);
        $this->load->view('invoices/v_lista', $dados);
    }

    public function novo() {
        $dados['pagina_ativa'] = 'invoice';
        $this->load->view('v_header', $dados);
        $this->load->view('invoices/v_novo', $dados); 
    }

    public function salvar_capa() {
        $data_emissao = $this->input->post('data_emissao');
        if ($data_emissao > date('Y-m-d')) {
            die("<script>alert('ERRO: Data de emissão não pode ser futura!'); history.back();</script>");
        }

        $dados_nota = [
            'numero_nota'      => preg_replace('/[^0-9]/', '', $this->input->post('numero_nota')),
            'data_emissao'     => $data_emissao,
            'fornecedor'       => $this->input->post('fornecedor'),
            'valor_total_nota' => $this->input->post('valor_total_nota'),
            'status_nota'      => 'PENDENTE' 
        ];

        $this->db->insert('invoices', $dados_nota);
        redirect('invoices/montar_itens/' . $this->db->insert_id());
    }

    
    public function salvar_item_unitario() {
    $id_invoice = $this->input->post('id_invoice');
    $id_prod = $this->input->post('id_catalogo');

    
    $produto = $this->db->get_where('catalogo_produtos', ['id' => $id_prod])->row();
    $qtd = (float)$this->input->post('quantidade');
    $v_unit = $produto->valor_unitario;

    $data = [
        'id_invoice'       => $id_invoice,
        'id_catalogo'      => $id_prod,
        'lote'             => strtoupper($this->input->post('lote')), 
        'quantidade_nota'  => $qtd, 
        'valor_unitario'   => $v_unit,
        'valor_total_item' => $qtd * $v_unit
    ];

    $this->db->insert('invoice_items', $data);
    redirect('invoices/montar_itens/' . $id_invoice);
}

    public function montar_itens($id) {
    
    $invoice = $this->Estoque_model->get_invoice_com_total($id);
    
    
    if (!$invoice) {
        redirect('invoices');
    }

    $dados['invoice'] = $invoice;
    $dados['itens'] = $this->Estoque_model->get_itens_invoice($id);
    $dados['produtos_catalogo'] = $this->Estoque_model->get_catalogo();
    $dados['pagina_ativa'] = 'invoice';

    
    $dados['total_acumulado'] = $invoice->total_acumulado;

    $this->load->view('v_header', $dados);
    $this->load->view('invoices/v_montar_itens', $dados);
}

    public function detalhes($id) {
    
    $invoice = $this->Estoque_model->get_invoice_com_total($id);
    
    if (!$invoice) {
        redirect('invoices');
    }

    $dados['invoice'] = $invoice;
    $dados['itens'] = $this->Estoque_model->get_itens_invoice($id);
    $dados['pagina_ativa'] = 'invoice';
    $dados['total_acumulado'] = $invoice->total_acumulado;

    
    $this->db->select('e.*, cp.nome_produto');
    $this->db->from('estoque_v2 e');
    $this->db->join('catalogo_produtos cp', 'cp.id = e.id_catalogo');
    $this->db->where('e.id_invoice_item IN (SELECT id FROM invoice_items WHERE id_invoice = '.$id.')');
    $dados['alocacoes_da_nota'] = $this->db->get()->result();

    $this->load->view('v_header', $dados);
    $this->load->view('invoices/v_detalhes', $dados);
}

    public function confirmar_alocacao() {
        $id_invoice = $this->input->post('id_invoice');
        $id_catalogo = $this->input->post('id_catalogo');
        $lote = strtoupper($this->input->post('lote'));
        $rua = strtoupper($this->input->post('rua'));
        $posicao = strtoupper($this->input->post('posicao'));

        
        if ($this->Estoque_model->verificar_posicao_ocupada($rua, $posicao, $id_catalogo, $lote)) {
            die("<script>alert('ERRO: A RUA $rua - POS $posicao já está ocupada por outro produto ou lote!'); history.back();</script>");
        }

        $data_estoque = [
            'id_catalogo'     => $id_catalogo,
            'id_invoice_item' => $this->input->post('id_invoice_item'),
            'lote'            => $lote,
            'quantidade'      => $this->input->post('qtd_alocar'),
            'rua'             => $rua,
            'posicao'         => $posicao,
            'status_posicao'  => 'ACTIVE'
        ];

        if ($this->Estoque_model->alocar_no_estoque($data_estoque, $data_estoque['id_invoice_item'], $data_estoque['quantidade'])) {
            redirect('invoices/detalhes/' . $id_invoice);
        } else {
            die("Erro crítico ao salvar alocação.");
        }
    }

    public function deletar($id_invoice) {
        $this->db->trans_start();
        $itens = $this->db->get_where('invoice_items', ['id_invoice' => $id_invoice])->result();

        foreach ($itens as $item) {
            if ($this->Estoque_model->item_possui_saida($item->id)) {
                $this->db->trans_rollback(); 
                die("<script>alert('BLOQUEIO: Esta nota não pode ser deletada pois itens dela já saíram em requisições!'); history.back();</script>");
            }
            $this->db->where('id_invoice_item', $item->id)->delete('estoque_v2');
        }

        $this->db->where('id_invoice', $id_invoice)->delete('invoice_items');
        $this->db->where('id', $id_invoice)->delete('invoices');
        $this->db->trans_complete();

        redirect('invoices');
    }

    public function remover_item($id_item, $id_invoice) {
        $this->db->where('id', $id_item)->delete('invoice_items');
        redirect('invoices/montar_itens/' . $id_invoice);
    }

    public function remover_alocacao($id_estoque, $id_invoice) {
    
    $alocacao = $this->db->get_where('estoque_v2', ['id' => $id_estoque])->row();

    if ($alocacao) {
        
        if ($this->Estoque_model->item_possui_saida($alocacao->id_invoice_item)) {
            die("<script>alert('ERRO: Não é possível remover pois este item já possui saídas registradas!'); history.back();</script>");
        }

        $this->db->trans_start();

        
        $this->db->set('quantidade_alocada', 'quantidade_alocada - ' . (float)$alocacao->quantidade, FALSE);
        $this->db->where('id', $alocacao->id_invoice_item);
        $this->db->update('invoice_items');

        
        $this->db->where('id', $id_estoque)->delete('estoque_v2');

        $this->db->trans_complete();
    }

    redirect('invoices/detalhes/' . $id_invoice);
}


}