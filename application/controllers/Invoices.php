<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    public function index() {
        $dados['invoices'] = $this->db->get('invoices')->result();
        $dados['pagina_ativa'] = 'invoice';
        $this->load->view('v_header', $dados);
        $this->load->view('invoices/v_lista', $dados);
    }

    public function novo() {
        $dados['pagina_ativa'] = 'invoice';
        $this->load->view('v_header', $dados);
        $this->load->view('invoices/v_novo', $dados); 
    }

    //Capa da Nota
    public function salvar() {
        $data_emissao = $this->input->post('data_emissao');
        if ($data_emissao > date('Y-m-d')) {
            die("<script>alert('ERRO: Data inválida!'); history.back();</script>");
        }

        $dados_nota = [
            'numero_nota'      => $this->input->post('numero_nota'),
            'data_emissao'     => $data_emissao,
            'fornecedor'       => $this->input->post('fornecedor'),
            'valor_total_nota' => $this->input->post('valor_total_nota'),
            'status_nota'      => 'OPEN' 
        ];

        $this->db->insert('invoices', $dados_nota);
        $id_nota = $this->db->insert_id();

        // Redireciona para adicionar os produtos um por um
        redirect('invoices/detalhes/' . $id_nota);
    }

    // Função NOVA para adicionar item buscando do catálogo
    // Salva os dados básicos e trava o valor alvo
public function salvar_capa() {
    $data_emissao = $this->input->post('data_emissao');
    $valor_nota = $this->input->post('valor_total_nota');
    
    // Regra de data (não superior a hoje)
    if ($data_emissao > date('Y-m-d')) {
        die("<script>alert('ERRO: Data de emissão não pode ser futura!'); history.back();</script>");
    }

    $dados_nota = [
        'numero_nota'      => preg_replace('/[^0-9]/', '', $this->input->post('numero_nota')), // Apenas números
        'data_emissao'     => $data_emissao,
        'fornecedor'       => $this->input->post('fornecedor'),
        'valor_total_nota' => $valor_nota,
        'status_nota'      => 'OPEN' 
    ];

    $this->db->insert('invoices', $dados_nota);
    $id_nota = $this->db->insert_id();

    // Redireciona para a tela de montagem de itens
    redirect('invoices/montar_itens/' . $id_nota);
}

//  Tela de conferência (Adicionar Itens)
public function montar_itens($id) {
    $this->db->where('id', $id);
    $dados['invoice'] = $this->db->get('invoices')->row();

    // Busca itens já inseridos com Join no catálogo
    $this->db->select('ii.*, cp.nome_produto');
    $this->db->from('invoice_items ii');
    $this->db->join('catalogo_produtos cp', 'cp.id = ii.id_catalogo');
    $this->db->where('ii.id_invoice', $id);
    $dados['itens'] = $this->db->get()->result();

    // Soma o total que já foi adicionado
    $this->db->select_sum('valor_total_item');
    $this->db->where('id_invoice', $id);
    $query_soma = $this->db->get('invoice_items')->row();
    $dados['total_acumulado'] = $query_soma->valor_total_item ?? 0;

    $dados['produtos_catalogo'] = $this->db->get('catalogo_produtos')->result();
    $dados['pagina_ativa'] = 'invoice';

    $this->load->view('v_header', $dados);
    $this->load->view('invoices/v_montar_itens', $dados);
}

//  Processa a adição buscando valor no catálogo
public function adicionar_item_unitario() {
    $id_invoice = $this->input->post('id_invoice');
    $id_catalogo = $this->input->post('id_catalogo');
    $qtd = $this->input->post('quantidade');

    // Busca valor unitário no catálogo
    $produto = $this->db->get_where('catalogo_produtos', ['id' => $id_catalogo])->row();

    if ($produto) {
        $item_data = [
            'id_invoice'         => $id_invoice,
            'id_catalogo'        => $id_catalogo,
            'quantidade_nota'    => $qtd,
            'lote'               => $this->input->post('lote'),
            'valor_unitario'     => $produto->valor_unitario, // Puxa do catálogo
            'valor_total_item'   => ($produto->valor_unitario * $qtd),
            'quantidade_alocada' => 0
        ];
        $this->db->insert('invoice_items', $item_data);
    }
    redirect('invoices/montar_itens/' . $id_invoice);
}

    public function detalhes($id) {
        $this->db->where('id', $id);
        $dados['invoice'] = $this->db->get('invoices')->row();

        //JOIN nomes de colunas
        $this->db->select('ii.*, cp.nome_produto, cp.codigo_sku');
        $this->db->from('invoice_items ii');
        $this->db->join('catalogo_produtos cp', 'cp.id = ii.id_catalogo');
        $this->db->where('ii.id_invoice', $id);
        $dados['itens'] = $this->db->get()->result();

        // Variável para conferência de valores na View
        $this->db->select_sum('valor_total_item');
        $this->db->where('id_invoice', $id);
        $query_soma = $this->db->get('invoice_items')->row();
        $dados['total_acumulado'] = $query_soma->valor_total_item ?? 0;

        $dados['produtos_catalogo'] = $this->db->get('catalogo_produtos')->result();
        $dados['posicoes'] = $this->db->get('armazem_posicoes')->result();
        $dados['pagina_ativa'] = 'invoice';

        $this->load->view('v_header', $dados);
        $this->load->view('invoices/v_detalhes', $dados);
    }

    //
public function confirmar_alocacao() {
    $id_invoice = $this->input->post('id_invoice');
    $id_catalogo = $this->input->post('id_catalogo');
    $lote = $this->input->post('lote');
    $rua = $this->input->post('rua');
    $posicao = $this->input->post('posicao');

    // 1. VERIFICAÇÃO DE OCUPAÇÃO
    $this->db->where('rua', $rua);
    $this->db->where('posicao', $posicao);
    $check = $this->db->get('estoque_v2')->row();

    if ($check) {
        // Se a posição está ocupada, verificamos se é o MESMO produto e MESMO lote
        // Se for diferente, barramos a alocação para evitar mistura
        if ($check->id_catalogo != $id_catalogo || $check->lote != $lote) {
            echo "<script>
                alert('ERRO: A RUA $rua - POS $posicao já está ocupada por outro produto ou lote diferente! Escolha outro endereço.');
                history.back();
            </script>";
            return; // Interrompe a execução
        }
    }

    // 2. SE PASSOU NA VERIFICAÇÃO, SEGUE O PROCESSO DE SALVAR
    $data_estoque = [
        'id_catalogo'     => $id_catalogo,
        'id_invoice_item' => $this->input->post('id_invoice_item'),
        'lote'            => $lote,
        'quantidade'      => $this->input->post('qtd_alocar'),
        'rua'             => $rua,
        'posicao'         => $posicao,
        'status_posicao'  => 'ACTIVE'
    ];

    $this->db->trans_start(); // Inicia transação para garantir integridade

    $this->db->insert('estoque_v2', $data_estoque);
    
    $this->db->set('quantidade_alocada', 'quantidade_alocada + ' . (float)$data_estoque['quantidade'], FALSE);
    $this->db->where('id', $this->input->post('id_invoice_item'));
    $this->db->update('invoice_items');

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        echo "<script>alert('Erro crítico ao salvar no banco de dados.'); history.back();</script>";
    } else {
        redirect('invoices/detalhes/' . $id_invoice);
    }
}

    public function remover_alocacao($id_estoque, $id_invoice) {
    // 1. Busca os dados da alocação antes de deletar para saber o que devolver ao saldo
    $alocacao = $this->db->get_where('estoque_v2', ['id' => $id_estoque])->row();

    if ($alocacao) {
        $this->db->trans_start();

        // 2. Subtrai a quantidade alocada do item da nota
        $this->db->set('quantidade_alocada', 'quantidade_alocada - ' . (float)$alocacao->quantidade, FALSE);
        $this->db->where('id', $alocacao->id_invoice_item);
        $this->db->update('invoice_items');

        // 3. Remove o registo do estoque físico
        $this->db->where('id', $id_estoque);
        $this->db->delete('estoque_v2');

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            echo "<script>alert('Alocação removida com sucesso! O saldo retornou para conferência.');</script>";
        } else {
            echo "<script>alert('Erro ao processar a remoção no banco de dados.');</script>";
        }
    }

    redirect('invoices/detalhes/' . $id_invoice);
}

public function remover_item($id_item, $id_invoice) {
    // Remove o item específico
    $this->db->where('id', $id_item);
    $this->db->delete('invoice_items');
    
    // Retorna para a tela de montagem para continuar a conferência
    redirect('invoices/montar_itens/' . $id_invoice);
}



}