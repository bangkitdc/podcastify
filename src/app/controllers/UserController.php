<?php

require_once SERVICES_DIR . 'auth/index.php';
require_once SERVICES_DIR . 'user/index.php';

class UserController extends BaseController {
    public function index()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    Middleware::checkIsLoggedIn();
                    Middleware::checkIsAdmin();

                    $this->list();
                    return;
                case "POST":
                    // $this->logout();
                return;
                default:
                    // response_not_allowed_method();
                    return;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
            }
            http_response_code($e->getCode());
            exit;
        }

    }

    public function list()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    $userService = new UserService();
                    $page = 1;
                    $data["users"] = $userService->getUsers($page, 10);
                    $data["totalUsers"] = $userService->getTotalUsers();

                    $this->view('layouts/default', $data);
                    return;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            // $this->view('layouts/error');
            exit;
        }
    }

    public function logout()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                if (!(isset($_SESSION['username']) && isset($_SESSION['userId']))) {
                    RedirectHelper::redirectHome();
                    return;
                }

                $authService = new AuthService();
                $authService->logout();
                RedirectHelper::redirectHome();
                return;
            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }
}