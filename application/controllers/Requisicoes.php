<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisicoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('id_usuario')) redirect('login');
        $this->load->model('Estoque_model');
    }

    public function index() {
    
    $filtros = [
        'lote'   => $this->input->get('lote'),
        'cliente'=> $this->input->get('cliente'),
        'inicio' => $this->input->get('data_inicio'),
        'fim'    => $this->input->get('data_fim')
    ];

    // O Model agora recebe os filtros
    $dados['requisicoes'] = $this->Estoque_model->listar_requisicoes_filtradas($filtros);
    $dados['clientes']    = $this->db->get('clientes')->result();
    $dados['pagina_ativa'] = 'requisicao';

    $this->load->view('v_header', $dados);
    $this->load->view('requisicoes/v_lista', $dados);
}

    public function detalhes($id) {
        // Busca header da requisição (Cliente e Status)
        $requisicao = $this->Estoque_model->get_requisicao_detalhes($id);

        if (!$requisicao) {
            $this->session->set_flashdata('erro', 'Requisição não encontrada.');
            redirect('requisicoes');
        }

        $dados['requisicao'] = $requisicao;
        $dados['pagina_ativa'] = 'requisicao';

        // Busca os itens vinculados, trazendo o nome do produto do catálogo
        $this->db->select('ri.*, cp.nome_produto, cp.codigo_sku');
        $this->db->from('requisicao_itens ri');
        $this->db->join('catalogo_produtos cp', 'cp.id = ri.id_catalogo');
        $this->db->where('ri.id_requisicao', $id);
        $dados['itens'] = $this->db->get()->result();

        $this->load->view('v_header', $dados);
        $this->load->view('requisicoes/v_detalhes', $dados);
    }

    public function estornar($id_requisicao) {
        // Busca a requisição para validar o status antes de estornar
        $req = $this->db->get_where('requisicoes', ['id' => $id_requisicao])->row();
        
        // Só permite estornar se estiver em picking ou finalizada 
        if (!$req || ($req->status != 'PICKING' && $req->status != 'FINALIZADO')) {
            die("<script>alert('ERRO: Esta requisição não pode ser estornada no status atual: " . ($req->status ?? 'N/A') . "'); history.back();</script>");
        }

        $this->db->trans_start();

        // 1. O Model devolve o saldo físico para as posições originais na estoque_v2
        $this->Estoque_model->estornar_itens_requisicao($id_requisicao);

        // 2. Voltamos o status da requisição para ABERTO para permitir nova edição
        $this->db->where('id', $id_requisicao)->update('requisicoes', ['status' => 'ABERTO']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('erro', 'Erro crítico ao processar estorno.');
        } else {
            $this->session->set_flashdata('sucesso', 'Estorno realizado com sucesso! Saldo devolvido ao estoque.');
        }

        redirect('requisicoes/detalhes/' . $id_requisicao);
    }

   public function nova() {
    $dados['pagina_ativa'] = 'requisicoes/v_lista';
    
    $this->load->model('Cliente_model');
    $this->load->model('Estoque_model');

    // Busca os dados usando as funções que existem nos models
    $dados['clientes'] = $this->Cliente_model->listar_clientes(); 
    $dados['estoque'] = $this->Estoque_model->get_estoque_disponivel(); 

    $this->load->view('v_header', $dados);
    $this->load->view('requisicoes/v_nova', $dados);
}


public function salvar() {
    // 1. Coleta os dados básicos
    $id_cliente = $this->input->post('id_cliente');
    $itens = $this->input->post('itens'); // Array vindo do JavaScript

    if (!$id_cliente || empty($itens)) {
        $this->session->set_flashdata('erro', 'ERRO: Selecione um cliente e ao menos um item!');
        redirect('requisicoes/nova');
    }

    $this->db->trans_start();

    // 2. Cria a "Capa" da Requisição
    $dados_requisicao = [
        'id_cliente'       => $id_cliente,
        'data_requisicao'  => date('Y-m-d H:i:s'),
        'status_requisicao' => 'ABERTO',
        'codigo_despacho'  => strtoupper(substr(uniqid(), -6)) // Gera um código de 6 dígitos
    ];
    $this->db->insert('requisicoes', $dados_requisicao);
    $id_requisicao = $this->db->insert_id();

    // 3. Grava os Itens da Requisição
    foreach ($itens['id_produto'] as $index => $id_prod) {
        $dados_item = [
            'id_requisicao' => $id_requisicao,
            'id_catalogo'   => $id_prod, // ID do catálogo vinculado
            'quantidade_pedida' => $itens['quantidade'][$index]
        ];
        $this->db->insert('requisicao_itens', $dados_item);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('erro', 'Erro ao gravar requisição no banco.');
        redirect('requisicoes/nova');
    } else {
        $this->session->set_flashdata('sucesso', 'Requisição #' . $id_requisicao . ' criada com sucesso!');
        // Redireciona para os DETALHES para conferência
        redirect('requisicoes/detalhes/' . $id_requisicao);
    }
}

public function confirmar_picking($id_requisicao) {
    $this->db->select('ri.*, cp.nome_produto');
    $this->db->from('requisicao_itens ri');
    $this->db->join('catalogo_produtos cp', 'cp.id = ri.id_catalogo');
    $this->db->where('ri.id_requisicao', $id_requisicao);
    $itens_pedidos = $this->db->get()->result();

    $this->db->trans_start();

    foreach ($itens_pedidos as $item) {
        $quantidade_falta = (float)$item->quantidade_pedida;

        // 1. Busca todas as posições que têm esse produto, ordenando por lote (mais antigo primeiro)
        $posicoes = $this->db->where('id_catalogo', $item->id_catalogo)
                             ->where('quantidade >', 0)
                             ->order_by('lote', 'ASC')
                             ->get('estoque_v2')
                             ->result();

        foreach ($posicoes as $pos) {
            if ($quantidade_falta <= 0) break;

            $quantidade_retirar = min($quantidade_falta, $pos->quantidade);
            $nova_qtd_posicao = (float)$pos->quantidade - (float)$quantidade_retirar;

            // 2. Deduz da posição atual ou remove se zerar
            if ($nova_qtd_posicao <= 0) {
                // Se zerou, deleta o registro para liberar a posição no mapa de estoque
                $this->db->where('id', $pos->id);
                $this->db->delete('estoque_v2');
            } else {
                // Se ainda sobrou saldo, apenas atualiza a quantidade
                $this->db->where('id', $pos->id);
                $this->db->update('estoque_v2', ['quantidade' => $nova_qtd_posicao]);
            }

            // 3. Registra o rastro do lote no item da requisição
            $this->db->where('id', $item->id);
            $this->db->update('requisicao_itens', [
                'id_estoque_v2' => $pos->id, 
                'lote_alocado'  => $pos->lote
            ]);

            $quantidade_falta -= $quantidade_retirar;
        }

        // 4. Se depois de percorrer tudo ainda faltar quantidade, cancela
        if ($quantidade_falta > 0) {
            $this->db->trans_rollback();
            die("ERRO: Saldo insuficiente total para " . $item->nome_produto . ". Faltam: " . $quantidade_falta);
        }
    }

    // 5. Finaliza a requisição
    $this->db->where('id', $id_requisicao);
    $this->db->update('requisicoes', ['status_requisicao' => 'FINALIZADA']);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        die("Erro crítico de banco de dados ao processar transação.");
    }

    $this->session->set_flashdata('sucesso', 'Picking confirmado! Quantidades deduzidas de múltiplas posições.');
    redirect('requisicoes/detalhes/' . $id_requisicao);
}
//nao aguento mais, estou com sono

}