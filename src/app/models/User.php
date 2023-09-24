<?php

require_once BASE_URL . '/src/config/database.php';

class User {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findAll($page = 1, $limit = 10) {
        $query = "SELECT * FROM User WHERE  ORDER BY username LIMIT $limit OFFSET :offset";
        $this->db->query($query);

        $offset = ($page - 1) * $limit;
        $this->db->bind("offset", $offset);

        $result = $this->db->fetchAll();
        return $result;
    }
}