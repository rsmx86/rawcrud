<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Verifica se o usuário está logado
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    // Lista todas as notas registradas
    public function index() {
    $dados['invoices'] = $this->db->get('invoices')->result();
    $dados['pagina_ativa'] = 'invoice';
    $this->load->view('v_header', $dados);
    $this->load->view('invoices/v_lista', $dados);
}

    // Abre o formulário de nova nota
    public function novo() {
    // Buscamos os produtos para o select do formulário
    $dados['produtos_catalogo'] = $this->db->get('catalogo_produtos')->result();
    $dados['pagina_ativa'] = 'invoice';

    $this->load->view('v_header', $dados);
    $this->load->view('invoices/v_novo', $dados); // Aqui você chama o seu arquivo v_novo.php
}

    // Processa o salvamento da nota e do item
    public function salvar() {
    $data_emissao = $this->input->post('data_emissao');
    $data_atual = date('Y-m-d');

    // Validação de Data
    if ($data_emissao > $data_atual) {
        die("<script>alert('ERRO: A data de emissao nao pode ser maior que a data atual!'); history.back();</script>");
    }

    $this->db->trans_start(); // Inicia transação para garantir integridade

    // 1. Salva a Capa da Nota
    $dados_nota = [
        'numero_nota'      => $this->input->post('numero_nota'),
        'data_emissao'     => $data_emissao,
        'fornecedor'       => $this->input->post('fornecedor'),
        'valor_total_nota' => $this->input->post('valor_total_nota'),
        'status_nota'      => 'VALIDATED' 
    ];

    $this->db->insert('invoices', $dados_nota);
    $id_nota = $this->db->insert_id();

    // 2. Captura os itens vindos do Buffer do JavaScript
    $itens_post = $this->input->post('itens');
    
    if (!empty($itens_post) && isset($itens_post['id_catalogo'])) {
        for ($i = 0; $i < count($itens_post['id_catalogo']); $i++) {
            $item_data = [
                'id_invoice'         => $id_nota,
                'id_catalogo'        => $itens_post['id_catalogo'][$i],
                'quantidade_nota'    => $itens_post['quantidade'][$i],
                'lote'               => $itens_post['lote'][$i],
                'valor_unitario'     => $itens_post['valor_unitario'][$i],
                'valor_total_item'   => $itens_post['valor_total_item'][$i],
                'quantidade_alocada' => 0
            ];
            $this->db->insert('invoice_items', $item_data);
        }
    } else {
        // Se tentarem salvar sem itens, cancela tudo
        $this->db->trans_rollback();
        die("<script>alert('ERRO: Voce precisa adicionar ao menos um item!'); history.back();</script>");
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        die("Erro fatal ao salvar a nota e seus itens.");
    }

    // Agora sim, redireciona para detalhes onde os itens aparecerão para alocação
    redirect('invoices/detalhes/' . $id_nota);
}

 public function detalhes($id) {
    // 1. Busca os dados da Capa
    $this->db->where('id', $id);
    $dados['invoice'] = $this->db->get('invoices')->row();

    // 2. Busca os Itens vinculados a esta nota (Join com catálogo para pegar o nome)
    $this->db->select('ii.*, cp.nome_produto, cp.codigo_sku');
    $this->db->from('invoice_items ii');
    $this->db->join('catalogo_produtos cp', 'cp.id = ii.id_catalogo');
    $this->db->where('ii.id_invoice', $id);
    $dados['itens'] = $this->db->get()->result();

    // 3. Busca as posições do armazém para o select de alocação
    $dados['posicoes'] = $this->db->get('armazem_posicoes')->result();

    $this->load->view('v_header', $dados);
    $this->load->view('invoices/v_detalhes', $dados);
}

public function confirmar_alocacao() {
    $id_invoice = $this->input->post('id_invoice');
    $id_invoice_item = $this->input->post('id_invoice_item');
    $id_catalogo = $this->input->post('id_catalogo');
    $lote = $this->input->post('lote');
    $qtd_alocar = $this->input->post('qtd_alocar');
    $endereco_bruto = $this->input->post('endereco_escolhido');

    if (empty($endereco_bruto)) {
        die("Erro: Nenhum endereço foi selecionado.");
    }

    $partes = explode('|', $endereco_bruto);
    $rua = $partes[0];
    $posicao = $partes[1];

    // --- NOVA REGRA DE VALIDAÇÃO DE ENDEREÇO ---
    
    // 1. Verificamos se já existe algum produto diferente ou lote diferente nesta posição
    $this->db->where('rua', $rua);
    $this->db->where('posicao', $posicao);
    $ocupacao_atual = $this->db->get('estoque_v2')->row();

    if ($ocupacao_atual) {
        // Regra A: Se o produto for diferente, bloqueia.
        if ($ocupacao_atual->id_catalogo != $id_catalogo) {
            die("<script>alert('ERRO: Esta posicao ja esta ocupada por um PRODUTO diferente!'); history.back();</script>");
        }
        
        // Regra B: Se o produto for igual, mas o lote for diferente, bloqueia.
        if ($ocupacao_atual->lote != $lote) {
            die("<script>alert('ERRO: Esta posicao ja contem este produto, mas com um LOTE diferente!'); history.back();</script>");
        }
    }

    // --- FIM DA VALIDAÇÃO ---

    $this->db->trans_start();

    // Se passou na validação ou a posição está vazia, prossegue:
    $dados_estoque = [
        'id_catalogo'      => $id_catalogo,
        'id_invoice_item'  => $id_invoice_item,
        'quantidade'       => $qtd_alocar,
        'lote'             => $lote,
        'rua'              => $rua,
        'posicao'          => $posicao,
        'status_posicao'   => 'ACTIVE'
    ];
    
    // Se já existir exatamente o mesmo produto/lote, podemos somar na mesma linha 
    // ou inserir uma nova linha (depende da sua preferência de rastreabilidade).
    // Aqui manteremos a inserção para rastrear por Nota Fiscal (id_invoice_item).
    $this->db->insert('estoque_v2', $dados_estoque);

    $this->db->set('quantidade_alocada', 'quantidade_alocada + ' . (float)$qtd_alocar, FALSE);
    $this->db->where('id', $id_invoice_item);
    $this->db->update('invoice_items');

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        redirect('invoices/detalhes/' . $id_invoice);
    } else {
        die("Erro no Banco de Dados ao processar alocação.");
    }
}

public function finalizar_saida() {
    $id_requisicao = $this->input->post('id_requisicao');

    $this->db->trans_start();

    // 1. Muda o status da Requisição para FINALIZADA
    $this->db->where('id', $id_requisicao);
    $this->db->update('requisicoes', ['status_requisicao' => 'FINALIZADA']);

    // 2. Remove o saldo físico do estoque_v2 
    // (Poderíamos mudar para status 'OFF', mas deletar limpa o banco como você pediu)
    $this->db->where('reserva_requisicao_id', $id_requisicao);
    $this->db->delete('estoque_v2');

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        redirect('requisicoes/detalhes/' . $id_requisicao);
    } else {
        die("Erro ao processar baixa final.");
    }
}

public function deletar($id) {
    // 1. Iniciamos uma transação para garantir que apague tudo ou nada
    $this->db->trans_start();

    // 2. Apagamos o saldo físico no estoque_v2 que veio desta nota
    // Primeiro buscamos os IDs dos itens da nota
    $this->db->select('id');
    $this->db->where('id_invoice', $id);
    $itens = $this->db->get('invoice_items')->result_array();
    
    if(!empty($itens)){
        $ids_itens = array_column($itens, 'id');
        $this->db->where_in('id_invoice_item', $ids_itens);
        $this->db->delete('estoque_v2');
    }

    // 3. Apagamos os itens da nota
    $this->db->where('id_invoice', $id);
    $this->db->delete('invoice_items');

    // 4. Apagamos a cabeçalho da nota
    $this->db->where('id', $id);
    $this->db->delete('invoices');

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        // Se algo deu errado, podemos logar o erro
        die("Erro ao tentar deletar a nota e seus vínculos.");
    } else {
        redirect('invoices');
    }
}



}