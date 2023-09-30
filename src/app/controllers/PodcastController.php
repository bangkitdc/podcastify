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
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

        // Check if its from search bar
        $is_search = isset($_GET['is_search']) ? $_GET['is_search'] : false;

        if ($isAjax) {
            if ($is_search) {
                $search_key = $_GET['key'];

                $podcasts = $this->podcast_service->getPodcastBySearch($search_key);

                include VIEW_DIR . "pages/podcast/index.php";
            }
            else {
                // If it's an AJAX request, only include podcast_detail.php
                $q = isset($_GET['podcast_id']) ? filter_var($_GET['podcast_id'], FILTER_SANITIZE_STRING) : '';

                $podcasts = $this->podcast_service->getPodcastById($q);

                include VIEW_DIR . "pages/podcast/podcast_detail.php";
            }
        } else {
            // If it's not an AJAX request, include the full HTML structure
            $podcasts = $this->podcast_service->getAllPodcast();

            $this->view('layouts/default', ['podcasts' => $podcasts]);
        }
    }
}
