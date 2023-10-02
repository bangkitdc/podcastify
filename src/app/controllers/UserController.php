<?php

require_once SERVICES_DIR . 'auth/index.php';

class UserController extends BaseController {
    public function index()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            // case "GET":
            //     $middleware = new Middleware();
            //     $can_access_admin = $middleware->can_access_admin_page();
            //     if (!$can_access_admin) {
            //         redirect_home();
            //         return;
            //     }
            //     $this->list();
            //     return;
            // case "POST":
            //     $this->logout();
                // return;
            default:
                // response_not_allowed_method();
                return;
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

                $auth_service = new AuthService();
                $auth_service->logout();
                RedirectHelper::redirectHome();
                return;
            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }
}