<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class Controller {

    protected $db;
    protected $auth;
    protected $router;

    public function __construct() {
        global $db, $auth, $router;

        $this->db = $db;
        $this->auth = $auth;
        $this->router = $router;
    }

}