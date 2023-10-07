<?php

require_once SERVICES_DIR . 'episode/EpisodeService.php';
require_once SERVICES_DIR . 'podcast/index.php';
require_once SERVICES_DIR . "upload/index.php";
require_once BASE_URL . '/src/config/storage.php';

class EpisodeController extends BaseController
{
  private $episode_service;
  private $podcast_service;
  private $img_upload_service;
  private $audio_upload_service;

  public function __construct()
  {
    $this->episode_service = new EpisodeService();
    $this->podcast_service = new PodcastService();
    $this->img_upload_service = new UploadService(STORAGE::EPISODE_IMAGE_PATH);
    $this->audio_upload_service = new UploadService(STORAGE::EPISODE_AUDIO_PATH);
  }

  public function index($id = null)
  {
    try {
      switch ($_SERVER["REQUEST_METHOD"]) {
        case 'GET':
          $data['episodes'] = [];
          $data['episode'] = [''];

          $total_episodes = $this->episode_service->getTotalEpisode();

          $data['episodes'] = $this->episode_service->getAllEpisodeCard(1, 10);

          $data['currentPage'] = 1;
          $data['totalPages'] = ceil($total_episodes / 10);

          if (isset($_GET['edit'])) { // go to edit page (?edit)
            Middleware::checkIsAdmin();
            $data['episode'] = $this->episode_service->getEpisodeById($id);
            $this->view("pages/episode/edit_episode", $data);
            break;
          }

          if (isset($_GET['page'])) {
            $data['currentPage'] = $_GET['page'];
            $episodes = $this->episode_service->getAllEpisodeCard($data['currentPage'], 10);
            $data['episodes'] = $episodes;

            $this->view("pages/episode/index", $data);
            break;
          }

          // $isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";

          if ($id != null && $id !== 'episode') {
            $data['episode'] = $this->episode_service->getEpisodeDetail($id);
          }

          $this->view("layouts/default", $data);
          break;

        case 'PATCH':
          Middleware::checkIsAdmin();
          $data = json_decode(file_get_contents('php://input'), true);
          $episode_id = $data['episode_id'];
          $title = $data['episode-title-input'];
          $description = $data['episode-description-input'];
          $image_url = $data['edit-preview-poster-filename'];
          $audio_url = $data['edit-audio-filename'];

          $this->episode_service->updateEpisode($episode_id, $title, $description, $image_url, $audio_url);

          $response = array("success" => true, "redirect_url" => "/episode/$id", "status_message" => "Changes Saved.");
          http_response_code(ResponseHelper::HTTP_STATUS_OK);

          header('Content-Type: application/json');

          echo json_encode($response);
          break;
        case 'DELETE':
          Middleware::checkIsAdmin();
          $this->episode_service->deleteEpisode($id);

          $response = array("success" => true, "redirect_url" => "/episode", "status_message" => "Episode Successfully Deleted.");
          http_response_code(ResponseHelper::HTTP_STATUS_OK);

          header('Content-Type: application/json');

          echo json_encode($response);
          break;

        default:
          ResponseHelper::responseNotAllowedMethod();
          return;
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

  public function add()
  {
    try {
      Middleware::checkIsAdmin();
      $podcast_data = $this->podcast_service->getAllPodcast();

      switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
          $podcastMapping = [];

          foreach ($podcast_data as $podcast) {
            $podcastMapping[$podcast->podcast_id] = $podcast->title;
          }

          $data['podcasts'] = $podcastMapping;

          $this->view('layouts/default', $data);
          break;
        case 'POST':
          $podcast_title = $_POST['podcast_title'];
          // var_dump($podcast_id);
          $title = $_POST['episode-title-input'];
          $description = $_POST['episode-description-input'];
          $image_file = $_POST['preview-poster-filename'] ? $_POST['preview-poster-filename'] : null;
          $audio_file = $_POST['audio-filename'] ?? '';

          $this->episode_service->addEpisode($podcast_title, 1, $title, $description, 60, $image_file, $audio_file);

          $response = array("success" => true, "redirect_url" => "/episode", "status_message" => "Episode Successfully Added.");
          http_response_code(ResponseHelper::HTTP_STATUS_OK);

          header('Content-Type: application/json');

          echo json_encode($response);
          break;

        default:
          ResponseHelper::responseNotAllowedMethod();
          return;
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

  public function upload()
  {
    Middleware::checkIsAdmin();

    $type = Sanitizer::sanitizeStringParam("type");
    try {
      switch ($_SERVER["REQUEST_METHOD"]) {
        case "POST":
          switch ($type) {
            case "image":
              $this->img_upload_service->upload($type);
              break;
            case "audio":
              $this->audio_upload_service->upload($type);
              break;
          }
          return;

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
      return;
    }
  }

  public function validate($totalPlayed) {
    if (Middleware::isLoggedIn() || $totalPlayed <= 3) {
        $response = array("success" => true);
        echo json_encode($response);
        return;
    }

    $response = array("success" => false);
    echo json_encode($response);
    return;
  }
};
