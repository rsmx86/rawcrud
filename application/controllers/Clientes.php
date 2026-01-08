<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Módulo de Gerenciamento de Clientes e Veículos
 * Centraliza o cadastro de clientes e perfis de uso dos veículos.
 */
class Clientes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Proteção de Sessão
        if (!$this->session->userdata("id_usuario")) {
            redirect("login");
        }
        $this->load->model("Cliente_model");
    }

    /**
     * Listagem Geral de Clientes
     */
    public function index()
    {
        $dados["pagina_ativa"] = "clientes";
        $dados["clientes"] = $this->Cliente_model->listar_todos();

        $this->load->view("v_header", $dados);
        $this->load->view("v_clientes_lista", $dados);
    }

    /**
     * Interface: Formulário de Novo Cadastro
     */
    public function novo()
    {
        $dados["pagina_ativa"] = "clientes";
        $this->load->view("v_header", $dados);
        $this->load->view("v_clientes_novo");
    }

    /**
     * Processa a Gravação do Cliente e Veículo
     */
    public function salvar()
    {
        $data = $this->input->post();

        // Normalização de Checkboxes (Booleano) os ticks
        $data["uso_drift"] = isset($data["uso_drift"]) ? 1 : 0;
        $data["uso_track_day"] = isset($data["uso_track_day"]) ? 1 : 0;
        $data["uso_rua"] = isset($data["uso_rua"]) ? 1 : 0;
        $data["uso_competicao"] = isset($data["uso_competicao"]) ? 1 : 0;

        if ($this->Cliente_model->salvar($data)) {
            echo "<script>alert('Customer & Vehicle Registered Successfully!'); window.location.href='" .
                site_url("clientes") .
                "';</script>";
        } else {
            echo "<script>alert('Error saving data.'); history.back();</script>";
        }
    }

    /**
     * Interface: Ficha Detalhada do Cliente (Visualização)
     */
    public function visualizar($id)
    {
        $dados["pagina_ativa"] = "clientes";
        $this->db->where("id", $id);
        $dados["cliente"] = $this->db->get("clientes")->row();

        if (!$dados["cliente"]) {
            show_404();
        }

        $this->load->view("v_header", $dados);
        $this->load->view("v_clientes_ficha", $dados);
    }

    /**
     * Interface: Formulário de Edição
     */
    public function editar($id)
    {
        $dados["pagina_ativa"] = "clientes";
        $this->db->where("id", $id);
        $dados["cliente"] = $this->db->get("clientes")->row();

        if (!$dados["cliente"]) {
            echo "<script>alert('Record not found!'); window.location.href='" .
                site_url("clientes") .
                "';</script>";
            return;
        }

        $this->load->view("v_header", $dados);
        $this->load->view("v_clientes_novo", $dados); //
    }

    /**
     * Processa a Atualização de Cadastro
     */
    public function atualizar($id)
    {
        $data = $this->input->post();

        // Normalização de Checkboxes
        $data["uso_drift"] = isset($data["uso_drift"]) ? 1 : 0;
        $data["uso_track_day"] = isset($data["uso_track_day"]) ? 1 : 0;
        $data["uso_rua"] = isset($data["uso_rua"]) ? 1 : 0;
        $data["uso_competicao"] = isset($data["uso_competicao"]) ? 1 : 0;

        $this->db->where("id", $id);
        if ($this->db->update("clientes", $data)) {
            echo "<script>alert('SYSTEM: Registry updated successfully.'); window.location.href='" .
                site_url("clientes/visualizar/" . $id) .
                "';</script>";
        } else {
            echo "<script>alert('Error updating database.'); history.back();</script>";
        }
    }

    /**
     * Exclui Cliente do Sistema
     */
    public function deletar($id)
    {
        $this->db->where("id", $id);
        if ($this->db->delete("clientes")) {
            echo "<script>alert('CRITICAL: Record deleted from system.'); window.location.href='" .
                site_url("clientes") .
                "';</script>";
        } else {
            echo "<script>alert('Error deleting record.'); history.back();</script>";
        }
    }

    public function salvar_cliente()
    {
        if ($this->db->insert("clientes", $dados)) {
            $this->Estoque_model->registrar_log(
                "Cadastrou novo cliente",
                "clientes",
                "Cliente: " . $this->input->post("razao_social")
            );
        }
    }
}
