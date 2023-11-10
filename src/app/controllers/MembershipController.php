<?php

require_once SERVICES_DIR . 'auth/index.php';
require_once SERVICES_DIR . 'user/index.php';
// require_once SERVICES_DIR . 'membership/index.php';

class MembershipController extends BaseController
{
  public function index($creatorId = null)
  {
    try {
      Middleware::checkIsLoggedIn();

      switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
          if ($creatorId !== null) {
            // $creatorId = filter_var($creatorId, FILTER_SANITIZE_NUMBER_INT);

            // $creatorService = new MembershipService();

            // $data = $membershipService->getMembership($membershipId);

            // $response = array("success" => true, "status_message" => "Fetched successfully", "data" => $data);
            // http_response_code(ResponseHelper::HTTP_STATUS_OK);

            // // Set the Content-Type header to indicate JSON
            // header('Content-Type: application/json');

            // // Return the JSON response
            // echo json_encode($response);
            return;
          }

          $this->list();
          break;
      }
    } catch (Exception $e) {
      if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
        $this->view('layouts/error');
        return;
      }

      http_response_code($e->getCode());
      $response = array("success" => false, "error_message" => $e->getMessage());
      echo json_encode($response);
      exit;
    }
  }

  private function list()
  {
    try {
      Middleware::checkIsLoggedIn();

      switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
          // $membershipService = new MembershipService();

          $data['currentPage'] = 1;

          // $totalMemberships = $membershipService->getTotalMemberships();
          // $data['totalPages'] = ceil($totalMemberships / 10);
          // $data["memberships"] = $membershipService->getMemberships($data['currentPage'], 10);

          // if (isset($_GET['page'])) {
          //   $data['currentPage'] = $_GET['page'];
          //   $data["memberships"] = $membershipService->getMemberships($data['currentPage'], 10);

          //   return renderMembershipTable($data['memberships'], $data['currentPage']);
          // }

          // $data["memberships"] = $membershipService->getMemberships($data['currentPage'], 10);

          // $apiUrl = REST_SERVICE_URL . '/creator';

          // $opts = array(
          //   'http' => array(
          //     'method' => "GET",
          //     'header' => "Accept-language: en\r\n" .
          //     "User-agent: BROWSER-DESCRIPTION-HERE\r\n"
          //   )
          // );

          $userService = new UserService();
          $userId = $_SESSION['user_id'];

          $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

          $encryptedUserId = openssl_encrypt($userId, 'aes-256-cbc', ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);

          // Concatenate IV and encrypted user ID
          $combinedData = $iv . $encryptedUserId;

          // Encode to send safely in headers
          $base64CombinedData = base64_encode($combinedData);

          $headers = [
            'x-api-key: ' . APP_API_KEY,
            'Authorization: Bearer ' . $base64CombinedData,
            'Content-Type: application/json'
          ];

          // $context = stream_context_create($opts);
          $apiUrl = REST_SERVICE_URL . '/creator';

          $ch = curl_init($apiUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          $response = curl_exec($ch);

          curl_close($ch);

          if ($response === false) {
            $error = curl_error($ch);
            $errorNumber = curl_errno($ch);

            echo "cURL Error: {$error} (Code: {$errorNumber})";
          } else {
            echo $response;
          }
          // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);



          // $response = file_get_contents($apiUrl);
          // $response = json_decode($response);

          // echo $response;

          // if ($httpCode === 200) {
          //   // Successful API response, handle the data
          //   $responseData = json_decode($response, true);

          //   echo $responseData;

          //   // Process the $responseData as needed
          //   // ...

          //   $this->view('layouts/default', $data);
          // } else {
          //   // Handle API error
          //   http_response_code($httpCode);
          //   $errorResponse = json_decode($response, true);
          //   $this->view('layouts/error', ['errorMessage' => $errorResponse['error_message']]);
          // }

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
      $response = array("success" => false, "error_message" => $e->getMessage());
      echo json_encode($response);
      exit;
    }
  }
}
