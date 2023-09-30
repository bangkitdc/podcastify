<?php
require_once BASE_URL . '/src/app/services/podcast/PodcastService.php';

class PodcastController extends BaseController
{
    private $podcast_service;

    public function __construct() {
        $this->podcast_service = new PodcastService();
    }

    public function index()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

                $podcasts = $this->podcast_service->getAllPodcast();

                if ($isAjax) {
                    $this->view("pages/podcast/index", ['podcasts' => $podcasts]);
                } else {
                    // If it's not an AJAX request, include the full HTML structure
                    $this->view('layouts/default', ['podcasts' => $podcasts]);
                }

            case "POST":
                return;

            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }

    // /podcast/{id}
    public function podcast($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $data['podcast'] = $this->podcast_service->getPodcastById($id);
        $data['episodes'] = $this->podcast_service->getEpisodesByPodcastId($id, 2, 1);

        $this->view("pages/podcast/podcast_detail", $data);
    }

    // /search?key=
    public function search() {
        $search_key = isset($_GET['key']) ? filter_var($_GET['key'], FILTER_SANITIZE_STRING) : '';

        $podcasts = $this->podcast_service->getPodcastBySearch($search_key);

        include VIEW_DIR . "pages/podcast/index.php";
    }
}
