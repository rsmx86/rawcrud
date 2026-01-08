<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Catalogo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("id_usuario")) {
            redirect("login");
        }
        $this->load->model("Estoque_model");
    }

    public function index()
    {
        $dados["produtos"] = $this->Estoque_model->get_catalogo();
        $dados["pagina_ativa"] = "catalogo/v_lista";
        $this->load->view("v_header", $dados);
        $this->load->view("catalogo/v_lista", $dados);
    }

    public function novo()
    {
        $dados["pagina_ativa"] = "catalogo/v_novo";
        $this->load->view("v_header", $dados);
        $this->load->view("catalogo/v_novo", $dados);
    }

    public function salvar()
    {
        $sku = strtoupper($this->input->post("codigo_sku"));
        $nome = strtoupper($this->input->post("nome_produto"));
        $valor = $this->input->post("valor_unitario");

        if (empty($sku) || empty($nome)) {
            die("Erro: Você precisa preencher o SKU e o Nome do produto!");
        }

        if ($valor < 0) {
            die("Erro: O valor do produto não pode ser menor que zero.");
        }

        $data = [
            "codigo_sku" => $sku,
            "nome_produto" => $nome,
            "fabricante" => strtoupper($this->input->post("fabricante")),
            "unidade_medida" => $this->input->post("unidade_medida"),
            "valor_unitario" => $valor,
        ];

        if ($this->Estoque_model->salvar_produto($data)) {
            $this->Estoque_model->registrar_log(
                "Criou produto",
                "catalogo_produtos",
                "SKU: $sku | Item: $nome"
            );

            redirect("catalogo");
        } else {
            echo "<h3>Ops! Esse SKU já existe.</h3>";
            echo "O código <b>$sku</b> já está cadastrado em outro item.";
            echo "<br><br><a href='javascript:history.back()'>Voltar e corrigir o código</a>";
        }
    }

    public function editar($id)
    {
        $this->db->where("id", $id);
        $dados["pagina_ativa"] = "catalogo/lista";
        $dados["produto"] = $this->db->get("catalogo_produtos")->row();

        if (!$dados["produto"]) {
            echo "<script>alert('Record not found!'); window.location.href='" .
                site_url("catalogo") .
                "';</script>";
            return;
        }

        $this->load->view("v_header", $dados);
        $this->load->view("catalogo/v_editar", $dados);
    }

    public function excluir($id)
    {
        if ($id) {
            $this->db->where("id", $id);

            $this->db->delete("catalogo_produtos");
        }

        redirect("catalogo");
    }

    public function atualizar()
    {
        $id = $this->input->post("id");

        $data = [
            "codigo_sku" => strtoupper($this->input->post("codigo_sku")),
            "nome_produto" => strtoupper($this->input->post("nome_produto")),
            "fabricante" => strtoupper($this->input->post("fabricante")),
            "unidade_medida" => $this->input->post("unidade_medida"),
            "valor_unitario" => $this->input->post("valor_unitario"),
        ];

        if ($this->Estoque_model->atualizar_produto($id, $data)) {
            redirect("catalogo");
        } else {
            $sku_erro = $data["codigo_sku"];
            $this->session->set_flashdata(
                "erro_sku",
                "O código $sku_erro já está em uso!"
            );
            redirect("catalogo");
        }
    }
}
