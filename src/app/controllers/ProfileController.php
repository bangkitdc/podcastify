<?php

require_once SERVICES_DIR . 'user/index.php';

class ProfileController extends BaseController {
    public function index()
    {
        try {
            Middleware::checkIsLoggedIn();

            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    $userService = new UserService();

                    $id = $_SESSION['user_id'];
                    $user = $userService->getUser($id);

                    $data = [
                        'user' => $user,
                    ];

                    $this->view('layouts/default', $data);
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
                return;
            }
            http_response_code($e->getCode());
            exit;
        }
    }
}