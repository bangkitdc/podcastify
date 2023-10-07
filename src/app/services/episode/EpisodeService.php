<?php

require_once BASE_URL . '/src/app/models/Episode.php';

class EpisodeService {
  private $episode_model;

  public function __construct() {
    $this->episode_model = new Episode();
  }

  public function getAllEpisode() {
    $episode_data = $this->episode_model->findAll();

    $episodes = array();

    foreach($episode_data as $episode) {
      array_push($episodes, $episode);
    }

    return $episodes;
  }

  public function getTotalEpisode() {
    return $this->episode_model->getTotalRows();
  }

  public function getEpisodeById($id) {
    $episode_data = $this->episode_model->findById($id);

    $episodes = array();

    if(is_object($episode_data)){
      array_push($episodes, $episode_data);
    } else if (is_array($episode_data)) {
      foreach($episode_data as $episode) {
        array_push($episodes, $episode);
      }
    } else {
      $episodes = [];
    };

    return $episodes;
  }

  public function getAllEpisodeCard($page = 1, $limit = 10) {
    $episode_card_data = $this->episode_model->findAllEpisodeCard($page, $limit);

    $episode_cards = array();

    foreach($episode_card_data as $episode) {
      array_push($episode_cards, $episode);
    }

    return $episode_cards;
  }

  public function getEpisodeDetail($id) {
    $episode_detail_data = $this->episode_model->findByIdEpisodeDetail($id);

    $episode_detail = array();

    if(is_object($episode_detail_data)){
      array_push($episode_detail, $episode_detail_data);
    } else if (is_array($episode_detail_data)) {
      foreach($episode_detail_data as $episode) {
        array_push($episode_detail, $episode);
      }
    } else {
      $episode_detail = [];
    };

    return $episode_detail;
  }

  public function addEpisode($podcast_id, $category_id, $title, $description, $duration, $image_url, $audio_url) {
    $this->episode_model->createEpisode($podcast_id, $category_id, $title, $description, $duration, $image_url, $audio_url);
  }

  public function updateEpisode($episode_id, $title, $description, $image_url, $audio_url) {
    $this->episode_model->updateEpisode($episode_id, $title, $description, $image_url, $audio_url);
  }

  public function deleteEpisode($id) {
    $this->episode_model->deleteEpisode($id);
  }
}