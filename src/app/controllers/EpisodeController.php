<?php
require_once BASE_URL . '/src/app/services/episode/EpisodeService.php';

class EpisodeController extends BaseController {
  private $episode_service;

  public function __construct() {
    $this->episode_service = new EpisodeService();
  }

  public function index() {
    switch($_SERVER["REQUEST_METHOD"]) {
      case 'GET':

        $episodes = $this->episode_service->getAllEpisodeCard();

        $data['episodes'] = $episodes;

        $this->view('layouts/default', $data);
        break;
    }
  }

  public function episode_detail() {
    switch($_SERVER["REQUEST_METHOD"]){
      case 'GET':
        if (isset($_GET['episode_id'])) {
          $episodeId = $_GET['episode_id'];
        } else {
          $episodeId = null;
        }
      
        if ($episodeId !== null) {
          $data['episode'] = $this->episode_service->getEpisodeDetail($episodeId);

          $this->view('layouts/default', $data);
        }
        break;
    }
  }

  public function add () {
    switch($_SERVER['REQUEST_METHOD']) {
      case 'POST':
        $podcast_id = $_POST['podcast_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        // $category = $_POST['category'];
        $image_file = $_POST['image_file'];
        $audio_file = $_POST['audio_file'];

        $this->episode_service->addEpisode($podcast_id, 1, $title, $description, 60, $image_file, $audio_file);
        break;

      default:
        break;
    }

    $data['podcast_title'] = ['Close the Door', 'PODKESMA', 'Trio Kurnia'];

    $this->view('layouts/default', $data);
  }

  public function edit() {
    try{

      if (isset($_GET['episode_id'])) {
        $episodeId = $_GET['episode_id'];
      } else {
        $episodeId = null;
      }

      switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
          $data['episode'] = $this->episode_service->getEpisodeById($episodeId);

          $this->view('layouts/default', $data);
          break;

        case "PATCH":
          // Todo : Parse data from url
          break;

        case "DELETE":
          $this->episode_service->deleteEpisode($episodeId);
          break;
        default:

      }
    } catch (Exception $e) {
      $this->view('layouts/error');
      exit;
    }
  }
};