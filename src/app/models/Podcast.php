<?php
class Podcast {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function findAll($page = 1, $limit = 10) {
        $query = "SELECT * FROM podcasts ORDER BY updated_at LIMIT :limit OFFSET :offset";
        $this->db->query($query);

        $offset = ($page - 1) * $limit;
        $this->db->bind(":limit", $limit);
        $this->db->bind(":offset", $offset);

        $result = $this->db->fetchAll();
        return $result;
    }

    public function findSome($podcast_id) {
        $query = "SELECT * FROM podcasts WHERE podcast_id = :podcast_id";
        $this->db->query($query);

        $this->db->bind(":podcast_id", $podcast_id);

        $result = $this->db->fetch();
        return $result;
    }

    public function createPodcast($title, $description, $creator_name, $image_url) {
        $query = "INSERT INTO podcasts (title, description, creator_name, image_url, created_at, updated_at) VALUES (:title, :description, :creator_name, :image_url, NOW(), NOW())";
        $this->db->query($query);

        $this->db->bind(":title", $title);
        $this->db->bind(":description", $description);
        $this->db->bind(":creator_name", $creator_name);
        $this->db->bind(":image_url", $image_url);

        $this->db->execute();
    }

    public function deletePodcast($podcast_id) {
        $query = "DELETE FROM podcasts WHERE podcast_id = :podcast_id";
        $this->db->query($query);

        $this->db->bind(":podcast_id", $podcast_id);

        $this->db->execute();
    }

    public function updatePodcast($podcast_id, $title, $description, $creator_name, $image_url) {
        $query = "UPDATE podcasts SET title = :title, description = :description, creator_name = :creator_name, image_url = :image_url, updated_at = NOW() WHERE podcast_id = :podcast_id";
        $this->db->query($query);

        $this->db->bind(":title", $title);
        $this->db->bind(":description", $description);
        $this->db->bind(":creator_name", $creator_name);
        $this->db->bind(":image_url", $image_url);
        $this->db->bind(":podcast_id", $podcast_id);

        $this->db->execute();
    }

    public function getPodcastBySearch($search_key) {
        $query = "SELECT * FROM podcasts WHERE title LIKE :search_key";
        $this->db->query($query);

        $search_key = "%" . $search_key . "%";
        $this->db->bind(':search_key', $search_key);

        $result = $this->db->fetchAll();
        return $result;
    }

    public function getEpisodesByPodcastId($podcast_id, $limit, $page) {
        $query = "SELECT * FROM episodes where podcast_id = :podcast_id LIMIT :limit OFFSET :offset";
        $this->db->query($query);

        $offset = ($page - 1) * $limit;
        $this->db->bind(":podcast_id", $podcast_id);
        $this->db->bind(":limit", $limit);
        $this->db->bind(":offset", $offset);

        $result = $this->db->fetchAll();
        return $result;
    }
}
