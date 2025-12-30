<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque_model extends CI_Model {

    // --- CATALOGO ---
    public function get_catalogo() {
        return $this->db->order_by('nome_produto', 'ASC')->get('catalogo_produtos')->result();
    }

    public function salvar_produto($data) {
        return $this->db->insert('catalogo_produtos', $data);
    }

    // --- ENTRADAS (INVOICES) ---
    public function salvar_entrada_completa($dados_nota, $itens) {
        $this->db->trans_start();
        
        // Insere a nota
        $this->db->insert('invoices', $dados_nota);
        $id_invoice = $this->db->insert_id();

        // Insere os itens vinculados
        foreach ($itens as $item) {
            $item['id_invoice'] = $id_invoice;
            $this->db->insert('invoice_items', $item);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function listar_invoices_pendentes() {
        $this->db->select('i.*, (SELECT COUNT(*) FROM invoice_items WHERE id_invoice = i.id) as total_itens');
        $this->db->from('invoices i');
        $this->db->where('i.status_nota', 'PENDENTE');
        return $this->db->get()->result();
    }


    
    public function alocar_no_estoque($dados_estoque, $id_invoice_item, $qtd_alocada) {
    $this->db->trans_start();

    // 1. Insere o registro no estoque físico
    $this->db->insert('estoque_v2', $dados_estoque);

    // 2. Atualiza a quantidade alocada na tabela da nota para controle
    $this->db->set('quantidade_alocada', 'quantidade_alocada + ' . (float)$qtd_alocada, FALSE);
    $this->db->where('id', $id_invoice_item);
    $this->db->update('invoice_items');

    $this->db->trans_complete();
    return $this->db->trans_status();
}



}