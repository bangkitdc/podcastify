<?php

require_once SERVICES_DIR . 'auth/index.php';
require_once SERVICES_DIR . 'user/index.php';

class LoginController extends BaseController {
    public function index(){
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    if (!isset($_SESSION['user_id'])) {
                        $this->view("layouts/guest");
                        return;
                    }
                    RedirectHelper::redirectHome();
                    break;
                case "POST":
                    if (!isset($_SESSION['user_id'])) {
                        $this->login();
                        return;
                    }
                    RedirectHelper::redirectHome();
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }

    private function login() {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "POST":
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $authService = new AuthService();
                    $status = $authService->login($username, $password);

                    if ($status == "SUCCESS") {
                        $response = array("success" => true, "redirect_url" => "/", "status_message" => "Login Successful.");
                        http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    } else {
                        $response = array("success" => false, "error_message" => "Login failed.");
                        http_response_code(ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
                    }

                    // Set the Content-Type header to indicate JSON
                    header('Content-Type: application/json');

                    // Return the JSON response
                    echo json_encode($response);
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => "Login failed");
            echo json_encode($response);
        }
    }
}