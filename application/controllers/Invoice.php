<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Módulo de Entrada de Mercadorias (Inbound)
 * Gerencia o registro de Notas Fiscais e preparação para alocação física.
 */
class Invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Segurança: Proteção de acesso
        if (!$this->session->userdata('id_usuario')) redirect('login');
        
        // O Invoice utiliza o Estoque_model para persistência de dados
        $this->load->model('Estoque_model');
    }

    /**
     * Interface: Registro de Nova Invoice e Histórico
     */
    public function index() {
        $dados['pagina_ativa']     = 'invoice'; 
        $dados['produtos_catalogo'] = $this->Estoque_model->listar_catalogo();
        $dados['historico_notas']   = $this->Estoque_model->listar_historico_invoices();
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_invoice_novo', $dados);
    }

    /**
     * Processa a Gravação da Nota e seus Itens
     */
    public function salvar() {
        $this->db->trans_start();

        // 1. Gravação do Cabeçalho da Invoice
        $invoice_data = [
            'numero_nota'      => $this->input->post('numero_nota'),
            'fornecedor'       => $this->input->post('fornecedor'),
            'valor_total_nota' => $this->input->post('valor_total_nota'),
            'data_emissao'     => date('Y-m-d H:i:s')
        ];
        
        // Chamada ao Model para inserir e retornar o ID gerado
        $id_invoice = $this->Estoque_model->salvar_invoice($invoice_data);

        // 2. Processamento dos Itens (vindos via Array do Formulário)
        $ids_produtos = $this->input->post('prod_id');
        $quantidades  = $this->input->post('prod_qtd');
        $lotes        = $this->input->post('prod_lote');

        if (!empty($ids_produtos)) {
            for ($i = 0; $i < count($ids_produtos); $i++) {
                if ($quantidades[$i] > 0) {
                    $item_data = [
                        'id_invoice'      => $id_invoice,
                        'id_catalogo'     => $ids_produtos[$i],
                        'quantidade'      => $quantidades[$i],
                        'lote'            => $lotes[$i],
                        'status_alocacao' => 'PENDENTE' // Aguardando Put-away
                    ];
                    $this->Estoque_model->salvar_invoice_item($item_data);
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('erro', 'CRITICAL ERROR: Failed to save Invoice.');
            redirect('invoice');
        } else {
            // Após salvar a nota, o operador deve ir para o estoque para alocar os itens
            redirect('estoque');
        }
    }

    /**
     * Remove Invoice (Somente se nenhum item tiver sido alocado no estoque físico)
     */
    public function deletar($numero_nota) {
        $this->db->where('numero_nota', $numero_nota);
        $nota = $this->db->get('invoices')->row();

        if (!$nota) {
            $this->session->set_flashdata('erro', 'Invoice record not found.');
            redirect('invoice');
            return;
        }

        // Bloqueio de Segurança: Impede exclusão se o item já estiver na prateleira (estoque_v2)
        $this->db->where('origem_nota', $numero_nota);
        $ja_alocado = $this->db->get('estoque_v2')->num_rows();

        if ($ja_alocado > 0) {
            $this->session->set_flashdata('erro', 'SECURITY ALERT: Cannot delete. Items are already in Physical Stock.');
        } else {
            $this->db->trans_start();
            // Deleta itens vinculados
            $this->db->where('id_invoice', $nota->id); 
            $this->db->delete('invoice_items');

            // Deleta o cabeçalho
            $this->db->where('id', $nota->id);
            $this->db->delete('invoices');
            $this->db->trans_complete();
            
            $this->session->set_flashdata('sucesso', 'Invoice #' . $numero_nota . ' purged from system.');
        }
        
        redirect('invoice');
    }
}