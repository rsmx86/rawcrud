<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $data['erro'] = $this->input->get('erro');
        $this->load->view('v_login', $data);
    }

    public function autenticar() {
        $this->load->model('usuario_model');
        
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        $usuario = $this->usuario_model->logar($email, $senha);

        if ($usuario) {
            // REGISTRA O ACESSO NO BANCO (Sincronizado com seu DB)
            $this->db->where('id', $usuario->id);
            $this->db->update('usuarios', ['ultimo_acesso' => date('Y-m-d H:i:s')]);

            // ESTABELECE A SESSÃO COM ID_USUARIO
            $dados_sessao = [
                'id_usuario' => $usuario->id,
                'nome'       => $usuario->nome,
                'nivel'      => (!empty($usuario->nivel)) ? $usuario->nivel : 'Mechanic',
                'logado'     => TRUE
            ];

            $this->session->set_userdata($dados_sessao);
            redirect(site_url('painel')); 
        } else {
            redirect(site_url('login?erro=1'));
        }
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }
}