<?php

require_once BASE_URL . '/src/app/models/Podcast.php';

class PodcastService {
    private $podcast_model;

    public function __construct(){
        $this->podcast_model = new Podcast();
    }

    public function getAllPodcast() {
        $podcasts_data = $this->podcast_model->findAll();
        $podcasts = array();
        foreach ($podcasts_data as $data) {
          array_push($podcasts, $data);
        }
        return $podcasts;
    }

    public function getPodcastById($podcast_id) {
        $podcasts = array();
        if ($podcast_id == '') {
            $podcasts_data = $this->podcast_model->findAll();
        } else {
            $podcasts_data = $this->podcast_model->findSome($podcast_id);
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
        return $podcasts;
    }

    public function getPodcastBySearch($search_key) {
        $podcasts_data = $this->podcast_model->getPodcastBySearch($search_key);
        $podcasts = array();
        foreach ($podcasts_data as $data) {
          array_push($podcasts, $data);
        }
        return $podcasts;
    }
}
