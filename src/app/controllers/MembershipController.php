<?php

require_once SERVICES_DIR . 'auth/index.php';
require_once SERVICES_DIR . 'user/index.php';
require_once COMPONENTS_PRIVATES_DIR . 'membership/cards.php';
require_once COMPONENTS_PRIVATES_DIR . 'membership/tables.php';
require_once COMPONENTS_PRIVATES_DIR . 'episode/episode_detail.php';

class MembershipController extends BaseController
{
  public function index()
  {
    try {
      Middleware::checkIsLoggedIn();
      Middleware::checkIsNotAdmin();

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
      Middleware::checkIsNotAdmin();

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
            throw new Exception('Bad Request', $httpCode);
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
        Middleware::checkIsNotAdmin();

        switch ($_SERVER['REQUEST_METHOD']) {
          case "GET":
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

            $encryptedUserId = openssl_encrypt($_SESSION['user_id'], 'aes-256-cbc', ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);

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
                $data['episodes'] = $responseData['data']['data']; // Fetch episodes data

                // Get Files
                $i = 0;
                foreach ($data['episodes'] as $episode) {
                  $apiUrlImage = REST_SERVICE_URL . '/episode/downloadImage/' . $episode['episode_id'];

                  if ($episode['image_url']) {
                    $ch = curl_init($apiUrlImage);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $responseImage = curl_exec($ch);
                    $httpCodeImage = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

                    curl_close($ch);

                    if ($httpCodeImage === ResponseHelper::HTTP_STATUS_OK) {
                      $base64 = base64_encode($responseImage);
                      $imageDataUrl = 'data:' . $contentType . ';base64,' . $base64;

                      $data['episodes'][$i]['imageFile'] = $imageDataUrl;
                      // file_put_contents(STORAGES_DIR . 'episode/images/' . $data['episode']['image_url'], $responseImage);
                    } else {
                      $data['episodes'][$i]['imageFile'] = null;
                    }
                  } else {
                    $data['episodes'][$i]['imageFile'] = null;
                  }

                  $i++;
                }
              } else {
                echo "Error decoding JSON response";
              }
            } else {
              throw new Exception('Bad Request', $httpCode);
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

                if (isset($_GET['page'])) {
                  return renderEpisodesTable($data['episodes'], $data['creator']['status'], $data['currentPage']);
                }

              } else {
                echo "Error decoding JSON response";
              }
            } else {
              throw new Exception('Bad Request', $httpCode);
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

  public function subscribe() {

    try {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                Middleware::checkIsLoggedIn();
                Middleware::checkIsNotAdmin();

                $data = json_decode(file_get_contents('php://input'), true);
                $creator_id = $data['creator_id'];
                $creator_name = $data['creator_name'];
                $subscriber_id = $_SESSION['user_id'];
                $subscriber_name = $_SESSION['username'];

                $apiUrl = SOAP_SERVICE_URL . '/subscription';
                $envelope = <<<EOT
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.podcastify.com/">
                    <soapenv:Header/>
                    <soapenv:Body>
                    <ser:subscribe>
                        <subscriber_id>$subscriber_id</subscriber_id>
                        <creator_id>$creator_id</creator_id>
                        <subscriber_name>$subscriber_name</subscriber_name>
                        <creator_name>$creator_name</creator_name>
                    </ser:subscribe>
                    </soapenv:Body>
                </soapenv:Envelope>
                EOT;

                $ch = curl_init();

                // Setup to send request to SOAP service
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: text/xml',
                    'x-api-key: ' . APP_API_KEY,
                ));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $envelope);

                // Return the response instead of outputting it
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);

                // Get response status
                $xml = new SimpleXMLElement($response);

                // Register the namespaces
                $xml->registerXPathNamespace('ns2', 'http://service.podcastify.com/');

                // Extract the statusCode and message
                $statusCode = $xml->xpath('//ns2:subscribeResponse/return/statusCode')[0];
                if ($statusCode == 202) {
                    $response = array("success" => true, "message" => "Succesfully sent a subscription request");
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    header('Content-Type: application/json');

                    echo json_encode($response);
                } else {
                    throw new Exception();
                }
                break;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
        }
    } catch (Exception $e) {
        $response = array("success" => false, "message" => "Failed to sent a subscription request");
        http_response_code(ResponseHelper::HTTP_STATUS_BAD_REQUEST);
        header('Content-Type: application/json');

        echo json_encode($response);
    }
  }

  public function prem_episode($episode_id) {
    if ($episode_id !== null) {
      $episode_id = filter_var($episode_id, FILTER_SANITIZE_NUMBER_INT);
      try {
        Middleware::checkIsLoggedIn();
        Middleware::checkIsNotAdmin();

        switch ($_SERVER['REQUEST_METHOD']) {
          case "GET":
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

            $encryptedUserId = openssl_encrypt($_SESSION['user_id'], 'aes-256-cbc', ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);

            // Concatenate IV and encrypted user ID
            $combinedData = $iv . $encryptedUserId;

            // Encode to send safely in headers
            $base64CombinedData = base64_encode($combinedData);

            $headers = [
              'x-api-key: ' . APP_API_KEY,
              'Authorization: Bearer ' . $base64CombinedData,
              'Content-Type: application/json'
            ];

            // Get prem episode
            $apiUrl = REST_SERVICE_URL . "/episode/" . $episode_id;

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
                $data['episode'] = $responseData['data'];

                if (isset($responseData['data']['episodeComments'])) {
                  foreach ($responseData['data']['episodeComments'] as $key => $comment) {
                    if (isset($comment['comment_text']) && is_string($comment['comment_text'])) {
                      $sanitizedCommentText = htmlspecialchars(strip_tags($comment['comment_text']));
                      $responseData['data']['episodeComments'][$key]['comment_text'] = $sanitizedCommentText;
                    }
                  }
                }

                // Assign sanitized comments to $data['episode']['episodeComments']
                $data['episode']['episodeComments'] = $responseData['data']['episodeComments'];

                // Get Files
                $apiUrlImage = REST_SERVICE_URL . '/episode/downloadImage/' . $data['episode']['episode_id'];

                if ($data['episode']['image_url']) {
                  $ch = curl_init($apiUrlImage);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                  $responseImage = curl_exec($ch);
                  $httpCodeImage = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                  $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

                  curl_close($ch);

                  if ($httpCodeImage === ResponseHelper::HTTP_STATUS_OK) {
                    $base64 = base64_encode($responseImage);
                    $imageDataUrl = 'data:' . $contentType . ';base64,' . $base64;
                    $data['episode']['imageFile'] = $imageDataUrl;
                  } else {
                    $data['episode']['imageFile'] = null;
                  }
                } else {
                  $data['episode']['imageFile'] = null;
                }

                $apiUrlAudio = REST_SERVICE_URL . '/episode/downloadAudio/' . $data['episode']['episode_id'];

                if ($data['episode']['audio_url']) {
                  $ch = curl_init($apiUrlAudio);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                  $responseAudio = curl_exec($ch);
                  $httpCodeAudio = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                  $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

                  curl_close($ch);

                  if ($httpCodeAudio === ResponseHelper::HTTP_STATUS_OK) {
                    $base64 = base64_encode($responseAudio);
                    $audioDataUrl = 'data:' . $contentType . ';base64,' . $base64;
                    $data['episode']['audioFile'] = $audioDataUrl;
                  } else {
                    $data['episode']['audioFile'] = null;
                  }
                } else {
                  $data['episode']['audioFile'] = null;
                }
              } else {
                echo "Error decoding JSON response";
              }
            } else {
              throw new Exception('Bad Request', $httpCode);
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
        $this->view('layouts/error');
        exit;
      }
    } else {
      $this->view('layouts/error');
      return;
    }
  }

  public function comment() {
    try {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                Middleware::checkIsLoggedIn();
                Middleware::checkIsNotAdmin();

                $postData = json_decode(file_get_contents('php://input'), true);
                $episode_id = $postData['episode_id'];
                $username = $postData['username'];
                $comment_text = $postData['comment_text'];

                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

                $encryptedUserId = openssl_encrypt($_SESSION['user_id'], 'aes-256-cbc', ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);

                // Concatenate IV and encrypted user ID
                $combinedData = $iv . $encryptedUserId;

                // Encode to send safely in headers
                $base64CombinedData = base64_encode($combinedData);

                $headers = [
                  'x-api-key: ' . APP_API_KEY,
                  'Authorization: Bearer ' . $base64CombinedData,
                  'Content-Type: application/json'
                ];

                $postData = [
                  'episode_id' => $episode_id,
                  'username' => $username,
                  'comment_text' => $comment_text,
                ];

                $jsonData = json_encode($postData);
                // var_dump($jsonData);
                // Get list of prem episodes
                $apiUrl = REST_SERVICE_URL . "/episode/comment";

                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if ($httpCode === ResponseHelper::HTTP_STATUS_CREATED) {
                    $response = array("success" => true, "message" => "Comment Submitted");
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    header('Content-Type: application/json');

                    echo json_encode($response);
                } else {
                  throw new Exception('Bad Request', $httpCode);
                }
              break;

            default:
              ResponseHelper::responseNotAllowedMethod();
              break;
        }
    } catch (Exception $e) {
        $response = array("success" => false, "message" => "Failed to sent a comment request");
        http_response_code(ResponseHelper::HTTP_STATUS_BAD_REQUEST);
        header('Content-Type: application/json');

        echo json_encode($response);
    }
  }

  public function like() {
    try {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                Middleware::checkIsLoggedIn();
                Middleware::checkIsNotAdmin();

                $postData = json_decode(file_get_contents('php://input'), true);
                $episode_id = $postData['episode_id'];

                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

                $encryptedUserId = openssl_encrypt($_SESSION['user_id'], 'aes-256-cbc', ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);

                // Concatenate IV and encrypted user ID
                $combinedData = $iv . $encryptedUserId;

                // Encode to send safely in headers
                $base64CombinedData = base64_encode($combinedData);

                $headers = [
                  'x-api-key: ' . APP_API_KEY,
                  'Authorization: Bearer ' . $base64CombinedData,
                  'Content-Type: application/json'
                ];

                $postData = [
                  'episode_id' => $episode_id,
                ];

                $jsonData = json_encode($postData);
                // Get list of prem episodes
                $apiUrl = REST_SERVICE_URL . "/episode/like";

                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

                $response = curl_exec($ch);
                $responseInfo = json_decode($response, true);

                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if ($httpCode === ResponseHelper::HTTP_STATUS_OK) {
                    $response = array("success" => true, "message" => $responseInfo['message']);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    header('Content-Type: application/json');

                    echo json_encode($response);
                } else {
                  throw new Exception('Bad Request', $httpCode);
                }
              break;

            default:
              ResponseHelper::responseNotAllowedMethod();
              break;
        }
    } catch (Exception $e) {
        $response = array("success" => false, "message" => "Failed to sent a like request");
        http_response_code(ResponseHelper::HTTP_STATUS_BAD_REQUEST);
        header('Content-Type: application/json');

        echo json_encode($response);
    }
  }
}
