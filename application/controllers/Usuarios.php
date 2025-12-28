<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logado')) redirect('login');

        $nivel = $this->session->userdata('nivel');
        if (!in_array($nivel, ['Garage Chief', 'Chief Mechanic', 'ADM'])) {
            redirect('painel');
        }
        $this->load->model('usuario_model');
    }

    public function index() {
        $dados['usuarios'] = $this->usuario_model->listar_todos();
        $dados['pagina_ativa'] = 'usuarios';
        $this->load->view('v_header', $dados);
        $this->load->view('v_usuarios', $dados);
    }

    public function salvar() {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');

        $nick  = trim($this->input->post('nick'));
        $email = trim($this->input->post('email'));

        // Unique Check (Nick e Email)
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
            'senha'     => password_hash('123456', PASSWORD_BCRYPT)
        ];

        $this->usuario_model->inserir($dados);
        redirect('usuarios');
    }

    public function atualizar() {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');

        $id = $this->input->post('id');
        $nick = trim($this->input->post('nick'));
        $email = trim($this->input->post('email'));

        // Unique Check ignorando o próprio registro atual
        $this->db->group_start()->where('nick', $nick)->or_where('email', $email)->group_end();
        $this->db->where('id !=', $id);
        if ($this->db->get('usuarios')->row()) {
            echo "<script>alert('UPDATE ERROR: Data already in use by another operator.'); history.back();</script>";
            return;
        }

        $dados = ['nome'=>trim($this->input->post('nome')), 'sobrenome'=>trim($this->input->post('sobrenome')), 'nick'=>$nick, 'email'=>$email, 'nivel'=>$this->input->post('nivel')];
        $nova_senha = $this->input->post('senha');
        if (!empty($nova_senha)) $dados['senha'] = password_hash($nova_senha, PASSWORD_BCRYPT);

        $this->usuario_model->atualizar($id, $dados);
        redirect('usuarios');
    }

    public function excluir($id) {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');

        // BLOQUEIO DE AUTO-EXCLUSÃO
        if ($id == $this->session->userdata('id_usuario')) {
            echo "<script>alert('SECURITY ALERT: You cannot delete your own profile while logged in!'); window.location='".site_url('usuarios')."';</script>";
            return;
        }

        $this->usuario_model->deletar($id);
        redirect('usuarios');
    }

    public function novo() {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');
        $this->load->view('v_header', ['pagina_ativa'=>'usuarios']);
        $this->load->view('v_usuarios_novo');
    }

    public function editar($id) {
        if ($this->session->userdata('nivel') !== 'Garage Chief') redirect('usuarios');
        $dados['usuario'] = $this->usuario_model->buscar_por_id($id);
        $dados['pagina_ativa'] = 'usuarios';
        $this->load->view('v_header', $dados);
        $this->load->view('v_usuarios_editar', $dados);
    }
}