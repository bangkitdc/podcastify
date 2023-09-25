<?php
require_once BASE_URL . '/src/app/models/Podcast.php';

class PodcastController extends Controller
{
    public function index()
    {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

        $podcast_models = new Podcast();
        if ($isAjax) {
            // If it's an AJAX request, only include podcast.php
            $q = isset($_GET['podcast_id']) ? filter_var($_GET['podcast_id'], FILTER_SANITIZE_STRING) : '';

            $podcasts = array();

            if ($q == '') {
              $podcasts_data = $podcast_models->findAll();
            } else {
              $podcasts_data = $podcast_models->findSome($q);
            }

            if (is_object($podcasts_data)) {
                array_push($podcasts, $podcasts_data);
            } else if (is_array($podcasts_data)) {
                foreach ($podcasts_data as $data) {
                    array_push($podcasts, $data);
                }
            } else {
                $podcasts = [];
            }

            include VIEW_DIR . "components/podcast/podcast.php";
        } else {
            // If it's not an AJAX request, include the full HTML structure
            $podcasts_data = $podcast_models->findAll();
            $podcasts = array();
            foreach ($podcasts_data as $data) {
              array_push($podcasts, $data);
            }

            $this->view('layouts/default', ['podcasts' => $podcasts]);
        }
    }
}
