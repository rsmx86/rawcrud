<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Estoque_model $Estoque_model
 * @property Cliente_model $Cliente_model
 * @property Usuario_model $Usuario_model
 * @property Usuario_model $Cliente_model
 */
class MY_Controller extends CI_Controller {
        public function __construct() {
        parent::__construct();
    }
}