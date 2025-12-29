<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Usamos trim para garantir que espaços no banco não barrem o acesso
        $nivel = trim($this->session->userdata('nivel'));
        
        if (strtoupper($nivel) != 'GARAGE CHIEF') {
            die("ACCESS_DENIED: High Clearance Required");
        }
    }

    public function index() {
        // Carregando direto da pasta views para não ter erro de diretório
        $this->load->view('v_header');
        $this->load->view('v_config_painel');
    }

    public function enderecos() {
        $data['posicoes'] = $this->db->get('estoque_v2')->result();
        $this->load->view('v_header');
        $this->load->view('v_config_enderecos', $data);
    }

    public function mudar_status($id_estoque, $novo_status) {
        if ($id_estoque) {
            $this->db->where('id', $id_estoque);
            $this->db->update('estoque_v2', ['status_posicao' => $novo_status]);
        }
        redirect('configuracoes/enderecos');
    }
}