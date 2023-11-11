<?php
require_once SERVICES_DIR . "/subscription/index.php";

class SubscriptionController extends BaseController
{

    private $subscription_service;

    public function __construct() {
        $this->subscription_service = new SubscriptionService();
    }

    public function index() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    Middleware::checkIsLoggedIn();

                    $userID = Sanitizer::sanitizeIntParam("user_id");

                    $newNotification = $this->subscription_service->getAllNewNotification($userID);

                    $response = array("success" => true, "data" => $newNotification);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    header('Content-Type: application/json');

                    echo json_encode($response);
                    break;

                case "POST":
                    // Parse the incoming request
                    parse_str(file_get_contents("php://input"),$post_vars);

                    $userID = $post_vars['subscriber_id'];
                    $creatorID = $post_vars['creator_id'];
                    $creatorName = $post_vars['creator_name'];
                    $status = $post_vars['status'];

                    $this->subscription_service->addNewNotification($userID, $creatorID, $creatorName, $status);

                    break;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;

            }
        } catch (Exception $e) {
            $response = array("success" => false, "data" => []);
            header('Content-Type: application/json');
            
            echo json_encode($response);
            exit;
        }
    }
}
