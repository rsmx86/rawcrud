<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

public function index() {
    $this->db->order_by('data_hora', 'DESC');
    $dados['logs'] = $this->db->get('logs_sistema')->result();
    
    $this->load->view('v_header');
    $this->load->view('logs/v_lista', $dados);
}

}