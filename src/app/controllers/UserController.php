<?php

require_once SERVICES_DIR . 'auth/index.php';
require_once SERVICES_DIR . 'user/index.php';
require_once COMPONENTS_PRIVATES_DIR . 'user/tables.php';

class UserController extends BaseController {
    public function index()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    $this->list();
                    break;
                case "POST":
                    $this->logout();
                    break;
                // case "PATCH":
                //     $this->status();
                //     break;
                default:
                    // response_not_allowed_method();
                    break;
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
            Middleware::checkIsLoggedIn();
            Middleware::checkIsAdmin();

            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    $userService = new UserService();

                    $data['currentPage'] = 1;
                    $totalUsers= $userService->getTotalUsers();
                    $data['totalPages'] = ceil($totalUsers / 10);
                    $data["users"] = $userService->getUsers($data['currentPage'], 10);

                    if (isset($_GET['page'])) {
                        $data['currentPage'] = $_GET['page'];
                        $data["users"] = $userService->getUsers($data['currentPage'], 10);

                        return renderUserTable($data['users'], $data['currentPage']);
                    }

                    $data["users"] = $userService->getUsers($data['currentPage'], 10);

                    $this->view('layouts/default', $data);
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
            }
            http_response_code($e->getCode());
            exit;
        }
    }

    public function edit($id)
    {
        try {
            Middleware::checkIsLoggedIn();
            Middleware::checkIsAdmin();

            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    $userService = new UserService();

                    $data = $userService->getUser($id);

                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
            }
            http_response_code($e->getCode());
            exit;
        }
    }

    public function status()
    {
        try {
            Middleware::checkIsLoggedIn();
            Middleware::checkIsAdmin();

            switch ($_SERVER['REQUEST_METHOD']) {
                case "PATCH":
                    $data = json_decode(file_get_contents('php://input'), true);

                    $userId = filter_var($data['user_id'], FILTER_VALIDATE_INT);

                    $allowedStatus = [0, 1];
                    if (!in_array($data['status'], $allowedStatus)) {
                        throw new Exception('Invalid user status value', ResponseHelper::HTTP_STATUS_BAD_REQUEST);
                    }
                    $userStatus = $data['status'];

                    $userService = new UserService();
                    $userService->updateStatus($userId, $userStatus);

                    $response = array("success" => true, "status_message" => "User status updated successfully.");
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);

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
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
            }
            http_response_code($e->getCode());
            exit;
        }
    }

    public function logout()
    {
        try {
            Middleware::checkIsLoggedIn();

            switch ($_SERVER['REQUEST_METHOD']) {
                case "POST":

                    $authService = new AuthService();
                    $authService->logout();
                    RedirectHelper::redirectHome();
                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
            }
            http_response_code($e->getCode());
            exit;
        }
    }
}