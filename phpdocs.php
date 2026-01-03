<?php
/**
 * Este arquivo serve apenas para ajudar o VS Code (Intellisense)
 * Ele não é executado pelo sistema.
 */

class CI_Controller {
    /** @var CI_DB_query_builder */
    public $db;
    /** @var CI_Input */
    public $input;
    /** @var CI_Loader */
    public $load;
    /** @var CI_Session */
    public $session;
}

class CI_DB_query_builder {
    /** @return int */
    public function insert_id() {}
}