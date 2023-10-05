<?php
require_once BASE_URL . "/src/app/helpers/ResponseHelper.php";
require_once BASE_URL . "/src/app/helpers/SanitizeHelper.php";
require_once BASE_URL . '/src/app/services/episode/EpisodeService.php';
require_once BASE_URL . '/src/app/services/podcast/index.php';
require_once SERVICES_DIR . "/upload/index.php";
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

    switch ($_SERVER["REQUEST_METHOD"]) {
      case 'GET':
        $data['episodes'] = [];
        $data['episode'] = [''];

        $total_episodes = $this->episode_service->getAllEpisode();

        $data['episodes'] = $this->episode_service->getAllEpisodeCard(1,4);

        $data['currentPage'] = 1;
        $data['totalPages'] = count($total_episodes) / count($data['episodes']);

        if (isset($_GET['edit'])) { // go to edit page (?edit)
          $data['episode'] = $this->episode_service->getEpisodeById($id);
          $this->view("pages/episode/edit_episode", $data);
          break;
        }

        if (isset($_GET['page'])) {
          $data['currentPage'] = $_GET['page'];
          $episodes = $this->episode_service->getAllEpisodeCard($data['currentPage'], 4);
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
        $data = json_decode(file_get_contents('php://input'), true);
        $episode_id = $data['episode_id'];
        $title = $data['episode-title-input'];
        $description = $data['episode-description-input'];
        $image_url = $data['edit-preview-poster-filename'];
        $audio_url = $data['edit-audio-filename'];

        $this->episode_service->updateEpisode($episode_id, $title, $description, $image_url, $audio_url);

        break;
      case 'DELETE':
        $this->episode_service->deleteEpisode($id);
        break;
    }
  }

  public function add()
  {
    $podcast_data = $this->podcast_service->getAllPodcast();

    switch ($_SERVER['REQUEST_METHOD']) {
      case 'POST':
        $podcast_id = $_POST['podcast_id'];
        var_dump($podcast_id);
        $title = $_POST['episode-title-input'];
        $description = $_POST['episode-description-input'];
        $image_file = $_POST['preview-poster-filename'] ?? '';
        $audio_file = $_POST['audio-filename'] ?? '';

        $this->episode_service->addEpisode($podcast_id, 1, $title, $description, 60, $image_file, $audio_file);
        break;

      default:
        break;
    }

    $podcastMapping = [];

    foreach ($podcast_data as $podcast) {
      $podcastMapping[$podcast->title] = $podcast->podcast_id;
    }

    $data['podcasts'] = $podcastMapping;

    $this->view('layouts/default', $data);
  }

  public function upload() {
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
        $this->view('layouts/error');
        exit;
    }
  }
};
