<?php

require_once SERVICES_DIR . 'auth/index.php';
require_once SERVICES_DIR . 'user/index.php';
require_once COMPONENTS_PRIVATES_DIR . 'membership/cards.php';
require_once COMPONENTS_PRIVATES_DIR . 'membership/tables.php';

class MembershipController extends BaseController
{
  public function index()
  {
    try {
      Middleware::checkIsLoggedIn();

      switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
          $this->cards();
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

  private function cards()
  {
    try {
      Middleware::checkIsLoggedIn();

      switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
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

          $data['currentPage'] = 1;

          if (isset($_GET['page'])) {
            $data['currentPage'] = $_GET['page'];
          }

          $apiUrl = REST_SERVICE_URL . '/creator?page=' . $data['currentPage'] . '&limit=8';

          $ch = curl_init($apiUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          $response = curl_exec($ch);
          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

          curl_close($ch);

          if ($httpCode === ResponseHelper::HTTP_STATUS_OK) {
            // Successful API response, handle the data
            $responseData = json_decode($response, true);

            if ($responseData !== null) {
              $data['currentPage'] = $responseData['data']['current_page'];
              $data['totalPages'] = $responseData['data']['last_page'];
              $data['creators'] = $responseData['data']['data'];

              if (isset($_GET['page'])) {
                return renderCreatorCardList($data['creators']);
              }
            } else {
              echo "Error decoding JSON response";
            }
          } else {
            throw new Exception('Bad Request', ResponseHelper::HTTP_STATUS_BAD_REQUEST);
          }

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

  public function creator($creatorId)
  {
    if ($creatorId !== null) {
      $creatorId = filter_var($creatorId, FILTER_SANITIZE_NUMBER_INT);
      try {
        Middleware::checkIsLoggedIn();

        switch ($_SERVER['REQUEST_METHOD']) {
          case "GET":
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

            $encryptedUserId = openssl_encrypt($creatorId, 'aes-256-cbc', ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);

            // Concatenate IV and encrypted user ID
            $combinedData = $iv . $encryptedUserId;

            // Encode to send safely in headers
            $base64CombinedData = base64_encode($combinedData);

            $headers = [
              'x-api-key: ' . APP_API_KEY,
              'Authorization: Bearer ' . $base64CombinedData,
              'Content-Type: application/json'
            ];

            $data['currentPage'] = 1;

            if (isset($_GET['page'])) {
              $data['currentPage'] = $_GET['page'];
            }

            // Get list of prem episodes
            $apiUrl = REST_SERVICE_URL . '/episode/creator/' . $creatorId . '?page=' . $data['currentPage'] . '&limit=10';

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($httpCode === ResponseHelper::HTTP_STATUS_OK) {
              // Successful API response, handle the data
              $responseData = json_decode($response, true);

              if ($responseData !== null) {
                $data['currentPage'] = $responseData['data']['current_page'];
                $data['totalPages'] = $responseData['data']['last_page'];
                $data['episodes'] = $responseData['data']['data'];

                if (isset($_GET['page'])) {
                  return renderEpisodesTable($data['episodes'], $data['currentPage']);
                }
              } else {
                echo "Error decoding JSON response";
              }
            } else {
              throw new Exception('Bad Request', ResponseHelper::HTTP_STATUS_BAD_REQUEST);
            }

            // Get creator
            $apiUrl2 = REST_SERVICE_URL . '/creator/' . $creatorId;
            $ch2 = curl_init($apiUrl2);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

            $response2 = curl_exec($ch2);
            $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

            curl_close($ch2);

            if ($httpCode2 === ResponseHelper::HTTP_STATUS_OK) {
              // Successful API response, handle the data
              $responseData = json_decode($response2, true);

              if ($responseData !== null) {
                $data['creator'] = $responseData['data'];

              } else {
                echo "Error decoding JSON response";
              }
            } else {
              throw new Exception('Bad Request', ResponseHelper::HTTP_STATUS_BAD_REQUEST);
            }

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
    } else {
      $this->view('layouts/error');
      return;
    }
  }

  public function prem_episode($episode_id) {
    // disini ya cad
  }
}
