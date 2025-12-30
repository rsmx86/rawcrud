<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gerenciamento de Operadores do Sistema
 * Acesso restrito a cargos de alta hierarquia (Garage Chief/ADM).
 */
class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Bloqueio de acesso para usuários não logados
        if (!$this->session->userdata('logado')) redirect('login');

        // Verificação de privilégios de acesso (System Admin)
        $nivel = $this->session->userdata('nivel');
        if (!in_array($nivel, ['Garage Chief', 'Chief Mechanic', 'ADM'])) {
            redirect('painel');
        }
        
        $this->load->model('usuario_model');
    }

    /**
     * Lista Geral de Operadores
     */
    public function index() {
        $dados['usuarios']     = $this->usuario_model->listar_todos();
        $dados['pagina_ativa'] = 'usuarios';
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_usuarios', $dados);
    }

    /**
     * Gravar Novo Operador
     */
    public function salvar() {
        // Somente o Garage Chief pode inserir novos usuários
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');

        $nick  = trim($this->input->post('nick'));
        $email = trim($this->input->post('email'));

        // Validação de Duplicidade (Unique Check)
        $this->db->group_start()->where('nick', $nick)->or_where('email', $email)->group_end();
        if ($this->db->get('usuarios')->row()) {
            echo "<script>alert('ERROR: Nick or Email already exists in database.'); history.back();</script>";
            return;
        }

        $dados = [
            'nome'      => trim($this->input->post('nome')),
            'sobrenome' => trim($this->input->post('sobrenome')),
            'nick'      => $nick,
            'email'     => $email,
            'nivel'     => $this->input->post('nivel'),
            'senha'     => password_hash('123456', PASSWORD_BCRYPT) // Senha padrão inicial
        ];

        $this->usuario_model->inserir($dados);
        redirect('usuarios');
    }

    /**
     * Atualizar Dados de Operador Existente
     */
    public function atualizar() {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');

        $id = $this->input->post('id');
        $nick = trim($this->input->post('nick'));
        $email = trim($this->input->post('email'));

        // Validação Unique ignorando o ID atual
        $this->db->group_start()->where('nick', $nick)->or_where('email', $email)->group_end();
        $this->db->where('id !=', $id);
        if ($this->db->get('usuarios')->row()) {
            echo "<script>alert('UPDATE ERROR: Data already in use by another operator.'); history.back();</script>";
            return;
        }

        $dados = [
            'nome'      => trim($this->input->post('nome')),
            'sobrenome' => trim($this->input->post('sobrenome')),
            'nick'      => $nick,
            'email'     => $email,
            'nivel'     => $this->input->post('nivel')
        ];

        // Atualização de Senha (apenas se preenchido)
        $nova_senha = $this->input->post('senha');
        if (!empty($nova_senha)) {
            $dados['senha'] = password_hash($nova_senha, PASSWORD_BCRYPT);
        }

        $this->usuario_model->atualizar($id, $dados);
        redirect('usuarios');
    }

    /**
     * Remover Operador do Sistema
     */
    public function excluir($id) {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');

        // BLOQUEIO DE SEGURANÇA: Impede auto-exclusão
        if ($id == $this->session->userdata('id_usuario')) {
            echo "<script>alert('SECURITY ALERT: You cannot delete your own profile while logged in!'); window.location='".site_url('usuarios')."';</script>";
            return;
        }

        $this->usuario_model->deletar($id);
        redirect('usuarios');
    }

    /**
     * Interface: Formulário de Adição
     */
    public function novo() {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');
        
        $dados['pagina_ativa'] = 'usuarios';
        $this->load->view('v_header', $dados);
        $this->load->view('v_usuarios_novo');
    }

    /**
     * Interface: Formulário de Edição
     */
    public function editar($id) {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');
        
        $dados['usuario']      = $this->usuario_model->buscar_por_id($id);
        $dados['pagina_ativa'] = 'usuarios';
        
        $this->load->view('v_header', $dados);
        $this->load->view('v_usuarios_editar', $dados);
    }
}