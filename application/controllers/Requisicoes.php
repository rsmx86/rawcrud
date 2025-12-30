<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisicoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    // Listagem de todas as ordens de saída
    public function index() {
        $this->db->select('r.*, c.nome_completo as nome_cliente');
        $this->db->from('requisicoes r');
        $this->db->join('clientes c', 'c.id = r.id_cliente');
        $this->db->order_by('r.id', 'DESC');
        $dados['requisicoes'] = $this->db->get()->result();

        $this->load->view('v_header');
        $this->load->view('requisicoes/v_lista', $dados);
    }

    // Formulário de nova requisição
    public function nova() {
        $dados['clientes'] = $this->db->get('clientes')->result();
        $dados['produtos'] = $this->Estoque_model->get_catalogo();
        
        $this->load->view('v_header');
        $this->load->view('requisicoes/v_nova', $dados);
    }

    public function detalhes($id) {
    // Busca a requisição com o nome do cliente
    $this->db->select('r.*, c.nome_completo as nome_cliente');
    $this->db->from('requisicoes r');
    $this->db->join('clientes c', 'c.id = r.id_cliente');
    $this->db->where('r.id', $id);
    $dados['requisicao'] = $this->db->get()->row();

    // Busca os itens que foram reservados pelo auto-picking
    $this->db->select('ri.*, cp.nome_produto, cp.codigo_sku');
    $this->db->from('requisicao_itens ri');
    $this->db->join('catalogo_produtos cp', 'cp.id = ri.id_catalogo');
    $this->db->where('ri.id_requisicao', $id);
    $dados['itens'] = $this->db->get()->result();

    $this->load->view('v_header', $dados);
    $this->load->view('requisicoes/v_detalhes', $dados); // Certifique-se do nome do arquivo
}

public function reservar($id_requisicao) {
    // Busca os itens que precisam ser reservados
    $itens = $this->db->get_where('requisicao_itens', ['id_requisicao' => $id_requisicao])->result();

    $this->db->trans_start();

    foreach ($itens as $item) {
        $qtd_falta_reservar = $item->quantidade_pedida;

        // Busca as linhas de estoque disponíveis (FIFO - mais antigas primeiro)
        $this->db->where('id_catalogo', $item->id_catalogo);
        $this->db->where('status_posicao', 'ACTIVE');
        $this->db->where('reserva_requisicao_id', NULL);
        $this->db->order_by('id', 'ASC');
        $estoque_disponivel = $this->db->get('estoque_v2')->result();

        foreach ($estoque_disponivel as $linha) {
            if ($qtd_falta_reservar <= 0) break;

            // Se a linha tem mais ou igual ao que preciso, carimbo e encerro
            // Se tem menos, carimbo o que tem e continuo procurando
            $this->db->where('id', $linha->id);
            $this->db->update('estoque_v2', ['reserva_requisicao_id' => $id_requisicao]);

            $qtd_falta_reservar -= $linha->quantidade;
        }
    }

    // Muda o status da requisição para VALIDADA (Fator 2 concluído)
    $this->db->where('id', $id_requisicao);
    $this->db->update('requisicoes', ['status_requisicao' => 'VALIDADA']);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        redirect('requisicoes/detalhes/' . $id_requisicao);
    } else {
        die("Erro ao processar reserva de estoque.");
    }
}






    // Salva o rascunho (Fator 1: Intenção de Saída)
    public function salvar() {
    $id_cliente = $this->input->post('id_cliente');
    $itens = $this->input->post('itens');

    $this->db->trans_start();

    // 1. Cria a Capa da Requisição
    $dados_req = [
        'id_cliente' => $id_cliente,
        'data_requisicao' => date('Y-m-d H:i:s'),
        'status_requisicao' => 'PICKING' // Status inicial
    ];
    $this->db->insert('requisicoes', $dados_req);
    $id_requisicao = $this->db->insert_id();

    // 2. Processa cada item e busca no estoque
    for ($i = 0; $i < count($itens['id_catalogo']); $i++) {
        $id_prod = $itens['id_catalogo'][$i];
        $qtd_necessaria = $itens['quantidade'][$i];

        // Busca saldo disponível no estoque para esse produto, ordenando por lote (FIFO opcional)
        $this->db->where('id_catalogo', $id_prod);
        $this->db->where('quantidade >', 0);
        $this->db->order_by('lote', 'ASC'); 
        $estoque_disponivel = $this->db->get('estoque_v2')->result();

        foreach ($estoque_disponivel as $est) {
            if ($qtd_necessaria <= 0) break;

            $qtd_a_reservar = min($qtd_necessaria, $est->quantidade);

            // Registra o item da requisição vinculado à posição de estoque
            $dados_item = [
                'id_requisicao' => $id_requisicao,
                'id_catalogo' => $id_prod,
                'quantidade_pedida' => $qtd_a_reservar,
                'lote_alocado' => $est->lote,
                'endereco_origem' => $est->rua . '-' . $est->posicao,
                'id_estoque_v2' => $est->id // Referência para a baixa
            ];
            $this->db->insert('requisicao_itens', $dados_item);

            $qtd_necessaria -= $qtd_a_reservar;
        }

        if ($qtd_necessaria > 0) {
            // Opcional: Alerta se não houver estoque suficiente para o item total
        }
    }

    $this->db->trans_complete();
    redirect('requisicoes/detalhes/' . $id_requisicao);
}

public function finalizar_saida() {
    $id_req = $this->input->post('id_requisicao');

    $this->db->trans_start();

    // 1. Busca os itens da requisição para saber o que tirar do estoque
    $this->db->where('id_requisicao', $id_req);
    $itens = $this->db->get('requisicao_itens')->result();

    foreach ($itens as $item) {
        // 2. Subtrai a quantidade do registro específico no estoque_v2
        $this->db->set('quantidade', 'quantidade - ' . (float)$item->quantidade_pedida, FALSE);
        $this->db->where('id', $item->id_estoque_v2);
        $this->db->update('estoque_v2');

        // 3. Limpeza: Se a quantidade chegou a zero, removemos o registro do estoque
        $this->db->where('id', $item->id_estoque_v2);
        $this->db->where('quantidade <=', 0);
        $this->db->delete('estoque_v2');
    }

    // 4. Muda o status da Requisição para FINALIZADA
    $this->db->where('id', $id_req);
    $this->db->update('requisicoes', ['status_requisicao' => 'FINALIZADA']);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        redirect('requisicoes');
    } else {
        die("Erro ao processar a baixa de estoque.");
    }
}

public function atualizar() {
    $id_req = $this->input->post('id_requisicao');
    $itens = $this->input->post('itens');

    $this->db->trans_start();

    // 1. Removemos os itens antigos da requisição para refazer o cálculo de picking
    $this->db->where('id_requisicao', $id_req);
    $this->db->delete('requisicao_itens');

    // 2. Repetimos a lógica de Auto-Picking (mesma que usamos no salvar)
    for ($i = 0; $i < count($itens['id_catalogo']); $i++) {
        $id_prod = $itens['id_catalogo'][$i];
        $qtd_necessaria = $itens['quantidade'][$i];

        // Busca saldo no estoque
        $this->db->where('id_catalogo', $id_prod);
        $this->db->where('quantidade >', 0);
        $this->db->order_by('lote', 'ASC'); 
        $estoque = $this->db->get('estoque_v2')->result();

        foreach ($estoque as $est) {
            if ($qtd_necessaria <= 0) break;
            $qtd_a_reservar = min($qtd_necessaria, $est->quantidade);

            $this->db->insert('requisicao_itens', [
                'id_requisicao' => $id_req,
                'id_catalogo' => $id_prod,
                'quantidade_pedida' => $qtd_a_reservar,
                'lote_alocado' => $est->lote,
                'endereco_origem' => $est->rua . '-' . $est->posicao,
                'id_estoque_v2' => $est->id
            ]);
            $qtd_necessaria -= $qtd_a_reservar;
        }
    }

    $this->db->trans_complete();
    redirect('requisicoes/detalhes/' . $id_req);
}



public function editar($id) {
    // 1. Busca os dados básicos da requisição
    $this->db->select('r.*, c.nome_completo as nome_cliente');
    $this->db->from('requisicoes r');
    $this->db->join('clientes c', 'c.id = r.id_cliente');
    $this->db->where('r.id', $id);
    $req = $this->db->get()->row();

    // Segurança: Não permite editar se já estiver finalizada
    if (!$req || $req->status_requisicao == 'FINALIZADA') {
        redirect('requisicoes');
    }

    $dados['requisicao'] = $req;

    // 2. Busca os itens atuais (agrupados por produto para facilitar a edição)
    // Note que usamos GROUP BY porque o auto-picking pode ter quebrado o mesmo item em vários lotes/endereços
    $this->db->select('ri.id_catalogo, cp.nome_produto, cp.codigo_sku, SUM(ri.quantidade_pedida) as quantidade_pedida');
    $this->db->from('requisicao_itens ri');
    $this->db->join('catalogo_produtos cp', 'cp.id = ri.id_catalogo');
    $this->db->where('ri.id_requisicao', $id);
    $this->db->group_by('ri.id_catalogo');
    $dados['itens_atuais'] = $this->db->get()->result();

    // 3. Dados auxiliares para os selects da tela
    $dados['produtos'] = $this->Estoque_model->get_catalogo();
    
    $this->load->view('v_header');
    $this->load->view('requisicoes/v_editar', $dados);
}

// Função para o botão DEL (Cancela a requisição e limpa os itens)
public function deletar($id) {
    $this->db->where('id', $id);
    $req = $this->db->get('requisicoes')->row();

    // Só deleta se não estiver finalizada (segurança de estoque)
    if ($req && $req->status_requisicao !== 'FINALIZADA') {
        $this->db->trans_start();
        $this->db->where('id_requisicao', $id);
        $this->db->delete('requisicao_itens');
        
        $this->db->where('id', $id);
        $this->db->delete('requisicoes');
        $this->db->trans_complete();
    }

    redirect('requisicoes');
}

}