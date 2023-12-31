<?php

require_once MODELS_DIR . 'Podcast.php';

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

    public function getAllCreatorName() {
        $creator_names_data = $this->podcast_model->getAllCreatorName();
        $creator_names = array();
        foreach($creator_names_data as $creator_name) {
            array_push($creator_names, $creator_name->creator_name);
        }
        return $creator_names;
    }

    public function getPodcast($limit = 10, $page = 1) {
        return $this->podcast_model->getPodcast($limit, $page);
    }

    public function getTotalRows() {
        return $this->podcast_model->getTotalRows();
    }

    public function getPodcastById($podcast_id) {
        $podcast_data = $this->podcast_model->findSome($podcast_id);
        return $podcast_data;
    }

    public function getPodcastBySearch($q, $sort_method, $sort_key, $filter_names, $filter_categories, $page = 1, $limit = 10) {

        $podcasts_data = $this->podcast_model->getPodcastBySearch($q, $sort_method, $sort_key, $filter_names, $filter_categories, $page, $limit);
        $podcasts = array();
        foreach ($podcasts_data as $data) {
          array_push($podcasts, $data);
        }
        return $podcasts;
    }

    public function getEpisodesByPodcastId($podcast_id, $limit = 10, $page = 1) {
        $episodes = $this->podcast_model->getEpisodesByPodcastId($podcast_id, $limit, $page);
        return $episodes;
    }

    public function createPodcast($title, $description, $creator_name, $image_url, $category_id) {
        $this->podcast_model->createPodcast($title, $description, $creator_name, $image_url, $category_id);
    }

    public function updatePodcast($podcast_id, $title, $description, $creator_name, $image_url, $category_id) {
        $this->podcast_model->updatePodcast($podcast_id, $title, $description, $creator_name, $image_url, $category_id);
    }

    public function deletePodcast($podcast_id) {
        $this->podcast_model->deletePodcast($podcast_id);
    }

    public function getRandomPodcasts($limit) {
        return $this->podcast_model->getRandomPodcasts($limit);
    }
}
