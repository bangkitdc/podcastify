<?php
require_once BASE_URL . "/src/app/helpers/ResponseHelper.php";
require_once BASE_URL . '/src/app/services/episode/EpisodeService.php';
require_once BASE_URL . '/src/app/services/podcast/index.php';

class EpisodeController extends BaseController
{
  private $episode_service;
  private $podcast_service;

  public function __construct()
  {
    $this->episode_service = new EpisodeService();
    $this->podcast_service = new PodcastService();
  }

  public function index($id = null)
  {

    switch ($_SERVER["REQUEST_METHOD"]) {
      case 'GET':
        if (isset($_GET['edit'])) { // go to edit page (?edit)
          $data['episode'] = $this->episode_service->getEpisodeById($id);

          $this->view('layouts/default', $data);
          break;
        }

        $isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";

        $episodes = $this->episode_service->getAllEpisodeCard();
        if ($id != null && $id !== 'episode') {
          $episode = $this->episode_service->getEpisodeDetail($id);
          $data['episode'] = $episode;
        }

        $data['episodes'] = $episodes;

        if ($isAjax) {
          $this->view('pages/episode/detail_episode', $data);
        } else {
          $this->view("layouts/default", $data);
        }
        break;
        
      case 'PATCH':
        $data = json_decode(file_get_contents('php://input'), true);
        var_dump($data);
        $episode_id = $data['episode_id'];
        $title = $data['episode-title-input'];
        $description = $data['episode-description-input'];
        $image_url = $data['image-file-upload'];
        $audio_url = $data['audio-file-upload'];

        $this->episode_service->updateEpisode($episode_id, $title, $description, $image_url, $audio_url);

        break;
      case 'DELETE':
        $this->episode_service->deleteEpisode($id);
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
        $image_file = $_POST['poster-file-upload'] ?? '';
        $audio_file = $_POST['audio-file-upload'] ?? '';

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
  
};
