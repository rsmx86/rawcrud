<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Gestão de Inventário Físico
 * Refatorado para delegar a lógica de banco ao Estoque_model.
 */
class Estoque extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Regra de Segurança: Redireciona se não houver sessão ativa
        if (!$this->session->userdata('id_usuario')) {
            redirect('login');
        }
        
        // Carga centralizada do Model para uso em todos os métodos
        $this->load->model('Estoque_model');
    }

    /**
     * Lista o inventário consolidado
     * Destino: v_inventario
     */
    public function index() {
        // Busca os dados processados pelo Model (JOIN, SUM, GROUP BY)
        // Isso remove a lógica de SQL que estava poluindo o controller
        $dados['estoque'] = $this->Estoque_model->get_inventario_consolidado();
        
        // Define o estado da navegação para o menu lateral/header
        $dados['pagina_ativa'] = 'estoque';

        // Carrega as views mantendo 100% da compatibilidade com os nomes de variáveis
        $this->load->view('v_header', $dados);
        $this->load->view('estoque/v_inventario', $dados); 
    }

}