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
    $query = "SELECT episodes.episode_id, episodes.title, podcasts.creator_name, episodes.duration, episodes.image_url, episodes.created_at FROM episodes, podcasts WHERE episodes.podcast_id = podcasts.podcast_id LIMIT $limit OFFSET :offset";
    $this->db->query($query);

    $offset = ($page - 1) * $limit;
    $this->db->bind("offset", $offset);
    $result = $this->db->fetchAll();

    return $result;
  }

  public function findByIdEpisodeDetail($episode_id) {
    $query = "SELECT episodes.episode_id, episodes.category_id, episodes.image_url, episodes.title, episodes.duration, episodes.created_at, episodes.description, podcasts.image_url AS creator_img, podcasts.creator_name, episodes.audio_url FROM episodes, podcasts WHERE episodes.podcast_id = podcasts.podcast_id and episode_id = $episode_id";
    $this->db->query($query);
    $result = $this->db->fetchAll();
    return $result;
  }

  public function createEpisode($podcast_id, $category_id, $title, $description, $duration, $image_url, $audio_url) {
    $query = "INSERT INTO `episodes` (`podcast_id`, `category_id`,`title`,`description`, `duration`,`image_url`, `audio_url`) VALUES (:podcast_id, :category_id, :title, :description, :duration, :image_url, :audio_url)";

    $this->db->query(($query));

    $this->db->bind(":podcast_id", $podcast_id);
    $this->db->bind(":category_id", $category_id);
    $this->db->bind(":title", $title);
    $this->db->bind(":description", $description);
    $this->db->bind(":duration", $duration);
    $this->db->bind(":image_url", $image_url);
    $this->db->bind(":audio_url", $audio_url);

    $this->db->execute();

    if ($this->db->rowCount() > 0) {
        $query = "UPDATE podcasts SET total_eps = total_eps + 1 WHERE podcast_id = :podcast_id";

        $this->db->query($query);
        $this->db->bind(":podcast_id", $podcast_id);
        $this->db->execute();
    }
  }

  public function deleteEpisode($episode_id) {
    $query = "DELETE FROM episodes WHERE episodes.episode_id = :episode_id";

    $this->db->query($query);

    $this->db->bind(":episode _id", $episode_id);

    $this->db->execute();
  }

  public function updateEpisode($episode_id, $title, $description, $image_url, $audio_url) {
    $query = "UPDATE episodes SET title = :title, description = :description, updated_at = NOW()";

    if (!empty($image_url)) {
        $query .= ", image_url = :image_url";
    }

    if (!empty($audio_url)) {
        $query .= ", audio_url = :audio_url";
    }

    $query .= " WHERE episode_id = :episode_id";

    $this->db->query($query);

    $this->db->bind(":episode_id", $episode_id);
    $this->db->bind(":title", $title);
    $this->db->bind(":description", $description);

    if (!empty($image_url)) {
        $this->db->bind(":image_url", $image_url);
    }

    if (!empty($audio_url)) {
        $this->db->bind(":audio_url", $audio_url);
    }

    $this->db->execute();
  }

}
