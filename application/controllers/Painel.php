<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session 
 */
class Painel extends CI_Controller {

    // O Construtor roda ANTES de qualquer outra função
    public function __construct() {
        parent::__construct();
        
        // Proteção: Se não houver sessão, expulsa com Erro 2 (Restrito)
        if (!$this->session->userdata('logado')) {
            redirect(site_url('login?erro=2'));
        }
    }

    // Página principal do Painel
    public function index() {
        echo "<body bgcolor='#dddddd'>";
        echo "<center>";
        echo "<h1>PAINEL</h1>";
        echo "<hr>";
        
        // Exibe o nome do usuário que está guardado no "crachá" (sessão)
        echo "<p>USUÁRIO CONECTADO: <b>" . $this->session->userdata('nome') . "</b></p>";
        
        // Botão Sair - Estilo Brutalista
        echo "<br><br>";
        echo "<a href='".site_url('login/sair')."' style='background:#000; color:#fff; padding:15px; text-decoration:none; border:3px solid #f00; font-weight:bold;'>LOGOUT</a>";
        
        echo "</center>";
        echo "</body>";
    }
}