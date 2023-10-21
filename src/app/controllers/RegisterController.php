<?php

require_once SERVICES_DIR . 'auth/index.php';

class RegisterController extends BaseController {
    public function index()
    {
        switch($_SERVER["REQUEST_METHOD"]){
            case "GET":
                $this->view("layouts/guest");
                break;
            case "POST":
                $this->register();
                break;
            default:
                ResponseHelper::responseNotAllowedMethod();
                break;
        }
    }

    private function register(){
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "POST":                    
                    $userService = new AuthService();

                    $hashedPassword = $this->hashPassword($_POST['password']);

                    $userService->register($_POST['email'], $_POST['username'], $hashedPassword, $_POST['first_name'], $_POST['last_name']);

                    $response = array("success" => true, "redirect_url" => "/login", "status_message" => "Register Successful");

                    // Set the Content-Type header to indicate JSON
                    header('Content-Type: application/json');

                    http_response_code(ResponseHelper::HTTP_STATUS_CREATED);

                    // Return the JSON response
                    echo json_encode($response);
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
        }
    }

    private function hashPassword($password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        return $hashedPassword;
    }
}