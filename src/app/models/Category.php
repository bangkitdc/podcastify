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

    if (!$result) {
        throw new Exception("No category in database");
    }

    return $result;
  }

  public function findById($id) {
    $query = "SELECT * FROM categories WHERE category_id = :category_id";
    $this->db->query($query);
    $this->db->bind(":category_id", $id);

    $result = $this->db->fetch();

    if ($this->db->rowCount() == 0) {
        throw new Exception("Category with ID $id not found");
    }
    return $result;
  }

  public function findByName($name) {
    $query = "SELECT * FROM categories WHERE name = :name";
    $this->db->query($query);
    $this->db->bind(":name", $name);

    $result = $this->db->fetch();

    if ($this->db->rowCount() == 0) {
        throw new Exception("Category with name $name not found");
    }

    return $result;
  }
}
