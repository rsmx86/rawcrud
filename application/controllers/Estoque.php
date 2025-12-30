<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Verifica se o usuário está logado
        if (!$this->session->userdata('id_usuario')) redirect('login');
    }

    // Esta é a função que carrega o seu v_inventario
    public function index() {
        $this->db->select('
            cp.codigo_sku, 
            cp.nome_produto, 
            e.rua, 
            e.posicao, 
            e.lote, 
            SUM(e.quantidade) as saldo_disponivel, 
            e.status_posicao
        ');
        $this->db->from('estoque_v2 e');
        $this->db->join('catalogo_produtos cp', 'cp.id = e.id_catalogo');
        
        // Agrupamos para garantir que o saldo seja somado corretamente por local e lote
        $this->db->group_by(['cp.codigo_sku', 'cp.nome_produto', 'e.rua', 'e.posicao', 'e.lote', 'e.status_posicao']);
        
        $dados['estoque'] = $this->db->get()->result();
        $dados['pagina_ativa'] = 'estoque';

        $this->load->view('v_header', $dados);
        $this->load->view('estoque/v_inventario', $dados); 
    }

} // <--- ESTA CHAVE FECHA A CLASSE (Provavelmente era o que faltava)