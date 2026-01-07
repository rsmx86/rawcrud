<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque_model extends CI_Model {

    // --- SEÇÃO 1: INVENTÁRIO ---

    public function get_inventario_consolidado() {
        $this->db->select('cp.codigo_sku, cp.nome_produto, e.rua, e.posicao, e.lote, SUM(e.quantidade) as saldo_disponivel, e.status_posicao');
        $this->db->from('estoque_v2 e');
        $this->db->join('catalogo_produtos cp', 'cp.id = e.id_catalogo');
        $this->db->group_by(['cp.codigo_sku', 'cp.nome_produto', 'e.rua', 'e.posicao', 'e.lote', 'e.status_posicao']);
        return $this->db->get()->result();
    }

    public function get_catalogo() {
        return $this->db->order_by('nome_produto', 'ASC')->get('catalogo_produtos')->result();
    }

    // --- SEÇÃO 2: ENTRADAS (INVOICES) ---

    public function get_invoice_com_total($id) {
        $this->db->where('id', $id);
        $invoice = $this->db->get('invoices')->row();
        if ($invoice) {
            $this->db->select_sum('valor_total_item');
            $this->db->where('id_invoice', $id);
            $query = $this->db->get('invoice_items')->row();
            $invoice->total_acumulado = $query->valor_total_item ?? 0;
        }
        return $invoice;
    }

    public function get_itens_invoice($id_invoice) {
        $this->db->select('ii.*, cp.nome_produto, cp.codigo_sku');
        $this->db->from('invoice_items ii');
        $this->db->join('catalogo_produtos cp', 'cp.id = ii.id_catalogo');
        $this->db->where('ii.id_invoice', $id_invoice);
        return $this->db->get()->result();
    }

    


    public function get_itens_devolucao_por_codigo($codigo) {
    $this->db->select('ri.*, cp.nome_produto, cp.codigo_sku, r.codigo_despacho');
    $this->db->from('requisicao_itens ri');
    $this->db->join('requisicoes r', 'r.id = ri.id_requisicao');
    $this->db->join('catalogo_produtos cp', 'cp.id = ri.id_catalogo');
    $this->db->where('r.codigo_despacho', $codigo);
    
    return $this->db->get()->result();
}


    

    // --- SEÇÃO 3: ALOCAÇÃO FÍSICA ---

    public function alocar_no_estoque($dados_estoque, $id_invoice_item, $qtd_alocada) {
        $this->db->trans_start();
        $this->db->insert('estoque_v2', $dados_estoque);
        $this->db->set('quantidade_alocada', 'quantidade_alocada + ' . (float)$qtd_alocada, FALSE);
        $this->db->where('id', $id_invoice_item);
        $this->db->update('invoice_items');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function verificar_posicao_ocupada($rua, $posicao, $id_catalogo, $lote) {
        $this->db->where(['rua' => $rua, 'posicao' => $posicao]);
        $check = $this->db->get('estoque_v2')->row();
        if ($check) {
            return ($check->id_catalogo != $id_catalogo || $check->lote != $lote);
        }
        return false;
    }

    // --- SEÇÃO 4: SAÍDAS (REQUISIÇÕES) ---

    public function listar_requisicoes() {
        $this->db->select('r.*, c.nome_completo as nome_cliente');
        $this->db->from('requisicoes r');
        $this->db->join('clientes c', 'c.id = r.id_cliente');
        $this->db->order_by('r.id', 'DESC');
        return $this->db->get()->result();
    }

    public function listar_disponivel() {
    $this->db->select('id, nome_produto, quantidade, valor_venda');
    $this->db->from('estoque'); // Mude para o nome da sua tabela
    $this->db->where('quantidade >', 0); // Só mostra o que tem saldo
    return $this->db->get()->result();
}


    public function get_requisicao_detalhes($id) {
        // O select r.* garante que o campo 'status' seja retornado para a View
        $this->db->select('r.*, c.nome_completo as nome_cliente');
        $this->db->from('requisicoes r');
        $this->db->join('clientes c', 'c.id = r.id_cliente');
        $this->db->where('r.id', $id);
        return $this->db->get()->row();
    }


   public function get_estoque_disponivel() {
    //
    $this->db->select('id, nome_produto, valor_unitario as valor_venda, codigo_sku as sku');
    $this->db->from('catalogo_produtos');
    
    $query = $this->db->get();
    return $query->result();
}

    public function estornar_itens_requisicao($id_requisicao) {
        // Busca o que foi retirado nesta requisição
        $itens = $this->db->get_where('requisicao_itens', ['id_requisicao' => $id_requisicao])->result();
        
        foreach ($itens as $item) {
            // Devolve o saldo para a linha exata da estoque_v2 usando o id_estoque_v2
            $this->db->set('quantidade', 'quantidade + ' . (float)$item->quantidade_pedida, FALSE);
            $this->db->where('id', $item->id_estoque_v2);
            $this->db->update('estoque_v2');
        }
        
        // Remove os registros de saída da requisição (limpa o picking)
        $this->db->where('id_requisicao', $id_requisicao)->delete('requisicao_itens');
        return true;
    }

    public function item_possui_saida($id_invoice_item) {
        $this->db->where('id_invoice_item', $id_invoice_item);
        return $this->db->count_all_results('requisicao_itens') > 0;
    }

    public function listar_requisicoes_filtradas($f) {
    $this->db->select('r.*, c.nome_completo as nome_cliente');
    $this->db->from('requisicoes r');
    $this->db->join('clientes c', 'c.id = r.id_cliente');
    
    // Filtro por LOTE (Pesquisa nos itens da requisição)
    if(!empty($f['lote'])){
        $this->db->join('requisicao_itens ri', 'ri.id_requisicao = r.id');
        $this->db->like('ri.lote_alocado', $f['lote']);
    }

    // Filtro por CLIENTE
    if(!empty($f['cliente'])){
        $this->db->where('r.id_cliente', $f['cliente']);
    }

    // Filtro por DATA INÍCIO
    if(!empty($f['inicio'])){
        $this->db->where('DATE(r.data_requisicao) >=', $f['inicio']);
    }

    // Filtro por DATA FIM
    if(!empty($f['fim'])){
        $this->db->where('DATE(r.data_req uisicao) <=', $f['fim']);
    }

    $this->db->group_by('r.id'); // Evita duplicar se houver vários itens do mesmo lote
    $this->db->order_by('r.id', 'DESC');
    return $this->db->get()->result();
}

   public function registrar_log($acao, $tabela = '', $detalhes = '') {
    $dados = [
        'id_usuario'     => $this->session->userdata('id_usuario'),
        'usuario_nome'   => $this->session->userdata('nome_usuario'),
        'acao'           => $acao,
        'tabela_afetada' => $tabela,
        'detalhes'       => $detalhes
    ];
    return $this->db->insert('logs_sistema', $dados);
}

   public function salvar_produto($dados) {
        $this->db->where('codigo_sku', $dados['codigo_sku']);
    $existe = $this->db->get('catalogo_produtos')->num_rows();

    if ($existe > 0) {
        // Se o SKU já existe, eu retorno "false" sem o insert
        return false;
    }

    // 
    if ($this->db->insert('catalogo_produtos', $dados)) {
        
        //a
        $this->registrar_log(
            "Cadastrou novo produto", 
            "catalogo_produtos", 
            "SKU: " . $dados['codigo_sku'] . " - Item: " . $dados['nome_produto']
        );
        
        return true;
    }

    return false;
}

    public function atualizar_produto($id, $dados) {
    $this->db->where('codigo_sku', $dados['codigo_sku']);
    $this->db->where('id !=', $id);
    $existe = $this->db->get('catalogo_produtos')->num_rows();

    if ($existe > 0) {
        return false;
    }

    $this->db->where('id', $id);
    if ($this->db->update('catalogo_produtos', $dados)) {
        $this->registrar_log("Editou produto", "catalogo_produtos", "ID: $id | Novo SKU: " . $dados['codigo_sku']);
        return true;
    }
    return false;
}
    


}