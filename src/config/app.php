<?php

define("BASE_DIR", $_ENV['PWD'] . '/src/app/controllers/');

class App {
    protected $controller;
    protected $method = 'index';
    protected $params = [];

    /**
     * 
     *
     * 
     */
    public function __construct() { 
        // Explode URL
        // [0] : controller
        // [1] : method/ params
        // Example : podcast/1, podcast/add

        $url = $this->parseURL();
        if (isset($url[0])) {
            if (file_exists(BASE_DIR . $url[0] . 'Controller.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        } else {
            $this->controller = 'Home';
        }

        $this->controller = ucfirst($this->controller);
        $controllerClassName = $this->controller . 'Controller';
        
        require_once BASE_DIR . $this->controller . 'Controller.php';

        if (class_exists($controllerClassName)) {
            // require_once BASE_DIR . $this->controller . 'Controller.php';
            $this->controller = new $controllerClassName;
        } else {
            require_once BASE_DIR . 'ErrorController.php';
            $controllerClassName = 'ErrorController';
            $this->controller = new $controllerClassName;
        }

        // $this->controller = new $controllerClassName;

        // Check if url[1] is a method or params
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if (!empty($url)) {
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * URL Parser into an array of components.
     *
     * @return array An array containing URL components, or [] if 'url' is not set.
     */
    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
        
        return [];
    }
}
