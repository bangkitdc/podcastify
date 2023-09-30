<?php

class BaseController {
    public function view($view, $data = []) {
        require_once VIEWS_DIR . $view . '.php';
    }
}