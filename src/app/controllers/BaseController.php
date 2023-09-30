<?php

define("VIEW_DIR", $_ENV['PWD'] . '/src/app/views/');

class BaseController {
    public function view($view, $data = []) {
        extract($data);
        require_once VIEW_DIR . $view . '.php';
    }
}
