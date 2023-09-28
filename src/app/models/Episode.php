<?php

class Episode {
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function findAll($page = 1, $limit = 10) {
    $query = "SELECT * FROM episodes ORDER BY updated_at LIMIT $limit OFFSET :offset";
    $this->db->query($query);

    $offset = ($page - 1) * $limit;
    $this->db->bind("offset", $offset);
    $result = $this->db->fetchAll();
    return $result;
  }

  public function findById($episode_id) {
    $query = "SELECT * FROM episodes where episode_id = $episode_id";
    $this->db->query($query);
    $result = $this->db->fetchAll();
    return $result;
  }

  public function findAllEpisodeCard($page = 1, $limit = 10) {
    $query = "SELECT episodes.title, podcasts.creator_name, episodes.duration, episodes.image_url FROM episodes, podcasts WHERE episodes.podcast_id = podcasts.podcast_id LIMIT $limit OFFSET :offset";
    $this->db->query($query);

    $offset = ($page - 1) * $limit;
    $this->db->bind("offset", $offset);
    $result = $this->db->fetchAll();

    return $result;
  }

  public function findByIdEpisodeDetail($episode_id) {
    $query = "SELECT episodes.image_url, episodes.title, episodes.duration, episodes.created_at, episodes.description, podcasts.image_url AS creator_img, podcasts.creator_name FROM episodes, podcasts WHERE episodes.podcast_id = podcasts.podcast_id and episode_id = $episode_id";
    $this->db->query($query);
    $result = $this->db->fetchAll();
    return $result;
  }

}