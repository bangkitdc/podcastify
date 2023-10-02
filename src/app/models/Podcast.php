<?php

require_once BASE_URL . '/src/config/storage.php';

class Podcast {
    private $db;
    private $podcast_storage;

    public function __construct() {
        $this->db = new Database();
        $this->podcast_storage = new Storage(Storage::PODCAST_IMAGE_PATH);
    }

    public function findAll($page = 1, $limit = 10) {
        $query = "SELECT * FROM podcasts ORDER BY updated_at LIMIT :limit OFFSET :offset";
        $this->db->query($query);

        $offset = ($page - 1) * $limit;
        $this->db->bind(":limit", $limit);
        $this->db->bind(":offset", $offset);

        $result = $this->db->fetchAll();
        if (!$result) {
            throw new Exception("No podcast in database.");
        }
        return $result;
    }

    public function findSome($podcast_id) {
        $query = "SELECT * FROM podcasts WHERE podcast_id = :podcast_id";
        $this->db->query($query);

        $this->db->bind(":podcast_id", $podcast_id);

        $result = $this->db->fetch();
        if (!$result) {
            throw new Exception("Podcast with ID $podcast_id not found.");
        }
        return $result;
    }

    public function getTotalRows() {
        $query = "SELECT COUNT(*) as count FROM podcasts";
        $this->db->query($query);
        $result = $this->db->fetch();
        return $result->count;
    }

    public function getPodcast($limit, $page) {
        $query = "SELECT * FROM podcasts LIMIT :limit OFFSET :offset";
        $this->db->query($query);

        $offset = ($page - 1) * $limit;
        $this->db->bind(":limit", $limit);
        $this->db->bind(":offset", $offset);

        $result = $this->db->fetchAll();

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

        if ($this->db->rowCount() == 0) {
            throw new Exception("Failed to create podcast.");
        }
    }

    public function deletePodcast($podcast_id) {
        $image_url = $this->findSome($podcast_id)->image_url;
        $this->podcast_storage->deleteFile($image_url);

        $query = "DELETE FROM podcasts WHERE podcast_id = :podcast_id";

        $this->db->query($query);

        $this->db->bind(":podcast_id", $podcast_id);

        $this->db->execute();

        if ($this->db->rowCount() == 0) {
            throw new Exception("Podcast with ID $podcast_id not found.");
        }
    }

    public function updatePodcast($podcast_id, $title, $description, $creator_name, $image_url) {
        if ($image_url != "") {
            $query = "UPDATE podcasts SET title = :title, description = :description, creator_name = :creator_name, image_url = :image_url, updated_at = NOW() WHERE podcast_id = :podcast_id";
            $this->db->query($query);
            $this->db->bind(":image_url", $image_url);
        } else {
            $query = "UPDATE podcasts SET title = :title, description = :description, creator_name = :creator_name, updated_at = NOW() WHERE podcast_id = :podcast_id";
            $this->db->query($query);
        }

        $this->db->bind(":title", $title);
        $this->db->bind(":description", $description);
        $this->db->bind(":creator_name", $creator_name);

        $this->db->bind(":podcast_id", $podcast_id);

        $this->db->execute();

        if ($this->db->rowCount() == 0) {
            throw new Exception("Podcast with ID $podcast_id not found.");
        }
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
