<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        
        // Validação de Acesso
        $nivel = trim($this->session->userdata('nivel'));
        if (strtoupper($nivel) != 'GARAGE CHIEF' && strtoupper($nivel) != 'ADM') {
            die("ACCESS_DENIED");
        }
    }

    public function index() {
        $dados['pagina_ativa'] = 'configuracoes';
        $this->load->view('v_header', $dados);
        $this->load->view('v_config_painel');
    }

    public function enderecos() {
        $dados['pagina_ativa'] = 'configuracoes';
        
        // Ajuste o nome abaixo para o nome EXATO que aparece no seu phpMyAdmin
        // Se no banco for "catalogo produtos" (com espaço), use: `catalogo produtos`
        // Se no banco for "catalogo_produtos" (com underline), use: catalogo_produtos
        
        $tabela_catalogo = 'catalogo_produtos'; 

        $this->db->select('e.*, c.codigo_sku, c.nome_produto');
        $this->db->from('estoque_v2 e');
        $this->db->join($tabela_catalogo . ' c', 'c.id = e.id_catalogo', 'left');
        
        $query = $this->db->get();

        if (!$query) {
            $error = $this->db->error();
            die("ERRO DE BANCO: " . $error['message']);
        }

        $dados['posicoes'] = $query->result();
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_config_enderecos', $dados);
    }

    public function mudar_status($id_estoque, $novo_status) {
        if ($id_estoque) {
            $this->db->where('id', $id_estoque);
            $this->db->update('estoque_v2', ['status_posicao' => $novo_status]);
        }
        redirect('configuracoes/enderecos');
    }
}