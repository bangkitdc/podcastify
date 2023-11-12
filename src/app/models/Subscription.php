<?php

require_once BASE_URL . '/src/config/database.php';

class Subscription {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findAllNewNotifications($userID)
    {
        $query = "SELECT * FROM subscription_notifications WHERE user_id = :user_id AND has_seen = 0";
        $this->db->query($query);

        $this->db->bind("user_id", $userID);

        $result = $this->db->fetchAll();

        return $result;
    }

    public function setAllToSeen($userID)
    {
        $query = "UPDATE subscription_notifications SET has_seen = 1 WHERE user_id = :user_id";

        $this->db->query($query);
        $this->db->bind("user_id", $userID);
        $this->db->execute();
    }

    public function deleteRejectedNotification($userID, $creatorID) {
        $query = "DELETE FROM subscription_notifications WHERE status = 'REJECTED' AND user_id = :user_id AND creator_id = :creator_id";

        $this->db->query($query);

        $this->db->bind(":user_id", $userID);
        $this->db->bind(":creator_id", $creatorID);

        $this->db->execute();
    }

    public function deleteAllRejectedNotification($userID) {
        $query = "DELETE FROM subscription_notifications WHERE status = 'REJECTED' AND user_id = :user_id";

        $this->db->query($query);

        $this->db->bind(":user_id", $userID);

        $this->db->execute();
    }

    public function addNewNotification($userID, $creatorID, $creatorName, $status) {
        $query = "INSERT INTO subscription_notifications (user_id, creator_id, creator_name, status) VALUES (:user_id, :creator_id, :creator_name, :status)";
        $this->db->query($query);

        $this->db->bind(":user_id", $userID);
        $this->db->bind(":creator_id", $creatorID);
        $this->db->bind(":creator_name", $creatorName);
        $this->db->bind(":status", $status);

        $this->db->execute();

        if ($this->db->rowCount() == 0) {
            throw new Exception("Failed to create a notification", 500);
        }
    }
}
