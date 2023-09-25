<?php
class Podcast {
  private $db;


  public function __construct() {
      $this->db = new Database();
  }

  public function findAll($page = 1, $limit = 10) {
    $query = "SELECT * FROM podcasts ORDER BY updated_at LIMIT $limit OFFSET :offset";
    $this->db->query($query);

    $offset = ($page - 1) * $limit;
    $this->db->bind("offset", $offset);

    $result = $this->db->fetchAll();
    return $result;
  }

  public function findSome($podcast_id) {
    $query = "SELECT * FROM podcasts WHERE podcast_id = $podcast_id";
    $this->db->query($query);
    $result = $this->db->fetch();
    return $result;
  }
}
