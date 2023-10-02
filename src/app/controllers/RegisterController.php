<?php

require_once MODELS_DIR . 'User.php';
require_once SERVICES_DIR . 'auth/index.php';

class RegisterController extends BaseController {
    public function index()
    {
        switch($_SERVER["REQUEST_METHOD"]){
            case "GET":
                $this->view("layouts/guest");
                return;
            case "POST":
                $this->register();
                return;
            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }

    // public function validate(){
    //     switch($_SERVER["REQUEST_METHOD"]){
    //         case "POST":
    //             // $email_regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    //             $username_validate = 'true';
    //             $email_validate = 'true';
    //             $password_validate = 'true';
    //             $confirm_password_validate = 'true';

    //             $user = new User();
    //             if (!empty($_POST['username']) && !empty($user->find_user_by_username($_POST['username']))) {
    //                 $username_validate = 'Username already exists';
    //             }
    //             if (!empty($_POST['username']) && preg_match('/\s/', $_POST['username'])) {
    //                 return 'Username contains whitespace';
    //             }
    //             if (!empty($_POST['email']) && !preg_match($email_regex, $_POST['email'])) {
    //                 $email_validate = 'Invalid Email';
    //             }
    //             else if (!empty($_POST['email']) && !empty($user->find_user_by_email($_POST['email']))) {
    //                 $email_validate = 'Email already exists';
    //             }
    //             if (!empty($_POST['password']) && !empty($_POST['confirm-password']) && $_POST['password'] != $_POST['confirm-password']) {
    //                 $password_validate = 'Password does not match';
    //                 $confirm_password_validate = 'Password does not match';
    //             }
    //             response_json(array(
    //                 "username" => $username_validate,
    //                 "email" => $email_validate,
    //                 "password" => $password_validate,
    //                 "confirm-password" => $confirm_password_validate
    //             ));
    //             return;
    //         default:
    //             ResponseHelper::responseNotAllowedMethod();
    //             return;
    //     }
    // }

    public function register(){
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "POST":                    
                    $user = new User();

                    $hashedPassword = $this->hashPassword($_POST['password']);
                    $user->create($_POST['email'], $_POST['username'], $hashedPassword, $_POST['first-name'], $_POST['last-name']);

                    $response = array("success" => true, "redirect_url" => "/login", "status_message" => "Register Successful");

                    // Set the Content-Type header to indicate JSON
                    header('Content-Type: application/json');

                    http_response_code(ResponseHelper::HTTP_STATUS_CREATED);

                    // Return the JSON response
                    echo json_encode($response);
                    return;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            http_response_code(500);
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
        }
    }

    private function hashPassword($password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        return $hashedPassword;
    }
}