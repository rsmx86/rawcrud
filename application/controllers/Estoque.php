<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Controller de Gestão de Inventário Físico
 * Refatorado para delegar a lógica de banco ao Estoque_model.
 */
class Estoque extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata("id_usuario")) {
            redirect("login");
        }

        $this->load->model("Estoque_model");
    }

    /**
     * Lista o inventário consolidado
     * Destino: v_inventario
     */
    public function index()
    {
        $dados["estoque"] = $this->Estoque_model->get_inventario_consolidado();

        $dados["pagina_ativa"] = "estoque";

        $this->load->view("v_header", $dados);
        $this->load->view("estoque/v_inventario", $dados);
    }
}
