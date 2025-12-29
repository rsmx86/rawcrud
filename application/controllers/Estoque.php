<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Segurança: Redireciona para o login se não houver sessão ativa
        if (!$this->session->userdata('id_usuario')) {
            redirect('login');
        }
        $this->load->model('Estoque_model');
    }

    // ==========================================================
    // 1. ESTOQUE FÍSICO (Inventory)
    // ==========================================================

    public function index() {
        $dados['pagina_ativa'] = 'estoque';
        // Lista todos os itens que já possuem endereço (Rua/Posição)
        $dados['itens'] = $this->Estoque_model->listar_estoque_geral(); 
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_estoque_lista', $dados);
    }

    // Abre a tela para distribuir os itens da Nota nas prateleiras
    public function alocar_nota($numero_nota) {
        $dados['pagina_ativa'] = 'estoque';
        $dados['nota'] = $numero_nota;
        
        // Busca os itens da nota que ainda não foram guardados (Pendente)
        $dados['itens_nota'] = $this->Estoque_model->buscar_itens_pendentes_nota($numero_nota);
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_estoque_alocacao', $dados);
    }

    // Processa o formulário de alocação e salva no estoque real
    public function confirmar_alocacao() {
    $ids_itens_nota = $this->input->post('id_item_nota');
    $ids_catalogo   = $this->input->post('id_catalogo');
    $quantidades    = $this->input->post('qtd');
    $ruas           = $this->input->post('rua');
    $posicoes       = $this->input->post('posicao');
    $numero_nota    = $this->input->post('numero_nota_ref');

    $erros = [];

    if (!empty($ids_itens_nota)) {
        for ($i = 0; $i < count($ids_itens_nota); $i++) {
            
            // 1. Verificar se a posição está livre
            if ($this->Estoque_model->posicao_esta_livre($ruas[$i], $posicoes[$i])) {
                
                // Busca o lote real para gravar
                $this->db->where('id', $ids_itens_nota[$i]);
                $item_nota = $this->db->get('invoice_items')->row();

                $data_estoque = [
                    'id_catalogo' => $ids_catalogo[$i],
                    'quantidade'  => $quantidades[$i],
                    'rua'         => $ruas[$i],
                    'posicao'     => $posicoes[$i],
                    'origem_nota' => $numero_nota,
                    'lote'        => $item_nota->lote
                ];
                
                $this->Estoque_model->finalizar_alocacao($data_estoque, $ids_itens_nota[$i]);
            } else {
                // Se a posição estiver ocupada, guarda o erro para mostrar depois
                $erros[] = "Position [STREET: {$ruas[$i]} / POS: {$posicoes[$i]}] is already occupied!";
            }
        }
    }

    if (!empty($erros)) {
        $msg = implode("\\n", $erros);
        echo "<script>alert('{$msg}'); window.location.href='".site_url('estoque/alocar_nota/'.$numero_nota)."';</script>";
    } else {
        redirect('estoque');
    }
}

    // ==========================================================
    // 2. CATÁLOGO DE PRODUTOS (Registry)
    // ==========================================================

    public function catalogo() {
        $dados['pagina_ativa'] = 'catalogo';
        $dados['produtos'] = $this->Estoque_model->listar_catalogo();
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_catalogo_lista', $dados);
    }

    public function novo_produto_catalogo() {
        $dados['pagina_ativa'] = 'catalogo';
        $this->load->view('v_header', $dados);
        $this->load->view('v_catalogo_novo');
    }

    public function salvar_catalogo() {
        $data = [
            'codigo_sku'   => $this->input->post('codigo_sku'),
            'nome_produto' => $this->input->post('nome_produto'),
            'descricao'    => $this->input->post('descricao')
        ];
        $this->Estoque_model->inserir_catalogo($data);
        redirect('estoque/catalogo');
    }

    public function editar_catalogo($id) {
        $dados['pagina_ativa'] = 'catalogo';
        $dados['produto'] = $this->Estoque_model->buscar_produto_catalogo($id);
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_catalogo_editar', $dados);
    }

    public function atualizar_catalogo() {
        $id = $this->input->post('id');
        $data = [
            'codigo_sku'   => $this->input->post('codigo_sku'),
            'nome_produto' => $this->input->post('nome_produto'),
            'descricao'    => $this->input->post('descricao')
        ];
        $this->Estoque_model->atualizar_catalogo($id, $data);
        redirect('estoque/catalogo');
    }

    public function eliminar_catalogo($id) {
        // Futura verificação: Impedir exclusão se houver saldo no estoque físico
        $this->Estoque_model->eliminar_catalogo($id);
        redirect('estoque/catalogo');
    }

// 1. Função para DAR BAIXA (SAÍDA / DISPATCH)
public function release_item($id) {
    // Buscamos os dados antes de deletar para saber qual posição foi liberada
    $this->db->where('id', $id);
    $item = $this->db->get('estoque_v2')->row();

    if ($item) {
        // Remove do estoque e libera a Rua/Posição para novas entradas
        $this->db->where('id', $id);
        $this->db->delete('estoque_v2'); 
        
        $this->session->set_flashdata('sucesso', 'SUCCESS: Item DISPATCHED. Slot ['.$item->rua.' / '.$item->posicao.'] is now vacant.');
    } else {
        $this->session->set_flashdata('erro', 'ERROR: Item not found.');
    }
    
    redirect('estoque');
}

// 2. Função para BLOQUEAR (NÃO CONFORMIDADE)
public function bloquear_posicao($id_estoque) {
    $data = ['status_posicao' => 'NON_COMPLIANCE']; // Define o status de bloqueio
    $this->db->where('id', $id_estoque);
    $this->db->update('estoque_v2', $data);
    
    $this->session->set_flashdata('erro', 'POSITION_LOCKED: Non-compliance reported.');
    redirect('estoque');
}



}