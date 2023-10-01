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

                $authService = new AuthService();
                $status = $authService->login($username, $password);

                if ($status == "SUCCESS") {
                    $response = array("success" => true, "redirect_url" => "/");
                } else {
                    $response = array("success" => false, "error_message" => "Login failed");
                }

                // Set the Content-Type header to indicate JSON
                header('Content-Type: application/json');

                // Return the JSON response
                echo json_encode($response);
                return;
            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }
}