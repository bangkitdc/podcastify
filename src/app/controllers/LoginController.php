<?php

require_once SERVICES_DIR . 'auth/index.php';

class LoginController extends BaseController {
    public function index(){
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    if (!isset($_SESSION['userId'])) {
                        $this->view("layouts/guest");
                        return;
                    }
                    RedirectHelper::redirectHome();
                    return;
                case "POST":
                    if (!isset($_SESSION['userId'])) {
                        $this->login();
                        return;
                    }
                    RedirectHelper::redirectHome();
                    return;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }

    private function login() {
        switch($_SERVER["REQUEST_METHOD"]){
            case "POST":
                $username = $_POST['username'];
                $password = $_POST['password'];
            
                if(!(isset($username) && isset($password))){
                    $this->view("layouts/guest");
                    return;
                } 

                $auth_service = new AuthService();
                $username = $_POST['username']; $password = $_POST['password'];
                $status = $auth_service->login($username, $password);

                if($status == "SUCCESS"){
                    RedirectHelper::redirectHome();
                } else {
                    $this->view("layouts/guest", ["status_message" => $status]);
                }
                return;
            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
  }
}