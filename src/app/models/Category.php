<?php

class Category {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function findAll($page = 1, $limit = 10) {
    $query = "SELECT * FROM categories";

    $this->db->query($query);

    $result = $this->db->fetchAll();

    return $result;
  }

  public function findById($id) {
    $query = "SELECT * FROM categories where category_id = $id";
    $this->db->query($query);
    $result = $this->db->fetchAll();
    return $result;
  }

  public function getCategoryOfEpisode($episodeId){
    $query = "SELECT categories.name FROM episodes, categories WHERE episodes.episode_id = $episodeId and episodes.category_id = categories.category_id";
    $this->db->query($query);
    $result = $this->db->fetchAll();
    return $result;
  }
}