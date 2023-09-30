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
        $podcast_data = $this->podcast_model->findSome($podcast_id);
        return $podcast_data;
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
