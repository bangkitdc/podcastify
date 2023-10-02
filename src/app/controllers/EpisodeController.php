<?php
require_once BASE_URL . "/src/app/helpers/ResponseHelper.php";
require_once BASE_URL . '/src/app/services/episode/EpisodeService.php';
require_once BASE_URL . '/src/app/services/podcast/PodcastService.php';
require_once BASE_URL . '/src/app/services/category/CategoryService.php';

class EpisodeController extends BaseController
{
  private $episode_service;
  private $podcast_service;
  private $category_service;

  public function __construct()
  {
    $this->episode_service = new EpisodeService();
    $this->podcast_service = new PodcastService();
    $this->category_service = new CategoryService();
  }

  public function index()
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case 'GET':

        $episodes = $this->episode_service->getAllEpisodeCard();
        $categories = $this->category_service->getAllCategories();

        $data['episodes'] = $episodes;
        $data['categories'] = $categories;


        $this->view('layouts/default', $data);
        break;
    }
  }

  public function episode_detail($id)
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case 'GET':
        $data['episode'] = $this->episode_service->getEpisodeDetail($id);
        $data['categories'] = $this->category_service->getAllCategories();

        $this->view('layouts/default', $data);
        break;
    }
  }

  public function add()
  {
    $podcast_data = $this->podcast_service->getAllPodcast();

    switch ($_SERVER['REQUEST_METHOD']) {
      case 'POST':
        $podcast_id = $_POST['podcast_id'];
        $title = $_POST['episode-title-input'];
        $description = $_POST['episode-description-input'];
        // $category = $_POST['category'];
        $image_file = $_POST['poster-file-upload'];
        $audio_file = $_POST['audio-file-upload'];

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

  public function edit($id)
  {
    try {
      switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
          $data['episode'] = $this->episode_service->getEpisodeById($id);
          $data['category'] = $this->category_service->getCategoryOfEpisode($id);

          $this->view('layouts/default', $data);
          break;

        case "POST":
          $method = $_POST['_method'];

          switch ($method) {
            case 'PATCH':
              $data_input = file_get_contents('php://input');
              $decode_data_input = urldecode($data_input);
              // header('Content-Type: application/json');

              parse_str($decode_data_input, $formDataArray);

              $jsondata = json_encode($formDataArray);

              $data = json_decode($jsondata, true);

              $episode_id = $data['episode_id'];
              $title = $data['episode-title-input'];
              $description = $data['episode-description-input'];
              $image_url = $data['image-file-upload'];
              $audio_url = $data['audio-file-upload'];

              $this->episode_service->updateEpisode($episode_id, $title, $description, $image_url, $audio_url);
              header('Location: /');
              break;
            case 'DELETE':
              $this->episode_service->deleteEpisode($id);
              header('Location: /');
              break;
          }

          return ResponseHelper::HTTP_STATUS_OK;
          // $this->view('layouts/default');
          break;

        case "DELETE":
          $this->episode_service->deleteEpisode($id);
          break;
        default:
      }
    } catch (Exception $e) {
      $this->view('layouts/error');
      exit;
    }
  }
};
