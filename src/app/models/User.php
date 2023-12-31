<?php

require_once BASE_URL . '/src/config/database.php';

class User {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findAll($page = 1, $limit = 10) 
    {
        $query = "SELECT * FROM users WHERE role_id = 2 ORDER BY user_id LIMIT $limit OFFSET :offset";
        $this->db->query($query);

        $offset = ($page - 1) * $limit;
        $this->db->bind("offset", $offset);

        $result = $this->db->fetchAll();
        return $result;
    }

    public function findById($userId) 
    {
        $query = "SELECT * From users WHERE user_id = :userId";

        $this->db->query($query);
        $this->db->bind("userId", $userId);
        $result = $this->db->fetch();

        return $result;
    }

    public function findByUsername($username) 
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $result = $this->db->fetch();

        return $result;
    }

    public function findByEmail($email) 
    {
        $query = "SELECT * FROM User WHERE email = :email";

        $this->db->query($query);
        $this->db->bind('email', $email);
        $result = $this->db->fetch();

        return $result;
    }

    public function create($email, $username, $hashedPassword, $firstName, $lastName)
    {
        $query = "INSERT INTO users (email, username, password, first_name, last_name, role_id) VALUES (:email, :username, :password, :first_name, :last_name, :role_id)";

        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->bind('username', $username);
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('first_name', $firstName);
        $this->db->bind('last_name', $lastName);
        $this->db->bind('role_id', 2); // User role

        $this->db->execute();
    }

    // Check if the email already exists
    public function emailExists($email)
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
        $this->db->query($query);
        $this->db->bind('email', $email);

        return $this->db->fetch()->count > 0;
    }

    // Check if the username already exists
    public function usernameExists($username)
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);

        return $this->db->fetch()->count > 0;
    }

    public function updateProfile($userId, $email, $username, $firstName, $lastName, $avatarURL)
    {
        $query = "UPDATE users SET email = :email, 
                                username = :username, 
                                first_name = :first_name, 
                                last_name = :last_name";

        if (!empty($avatarURL)) {
            $query .= ", avatar_url = :avatar_url";
        }

        $query .= " WHERE user_id = :user_id";

        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->bind('username', $username);
        $this->db->bind('first_name', $firstName);
        $this->db->bind('last_name', $lastName);
        
        $this->db->bind('user_id', $userId);

        if (!empty($avatarURL)) {
            $this->db->bind('avatar_url', $avatarURL);
        }

        $this->db->execute();
    }

    public function emailExistsForOthers($userId, $email)
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE email = :email AND user_id != :user_id";
        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->bind('user_id', $userId);

        return $this->db->fetch()->count > 0;
    }

    public function usernameExistsForOthers($userId, $username)
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE username = :username AND user_id != :user_id";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('user_id', $userId);

        return $this->db->fetch()->count > 0;
    }

    public function isCurrentPassword($userId, $currentPassword)
    {
        $query = "SELECT password AS password FROM users WHERE user_id = :user_id";
        $this->db->query($query);
        $this->db->bind('user_id', $userId);

        $hashedPassword = $this->db->fetch()->password;

        return $this->checkPassword($currentPassword, $hashedPassword);
    }

    public function updatePassword($userId, $hashedPassword)
    {
        $query = "UPDATE users SET password = :password
                            WHERE user_id = :user_id";

        $this->db->query($query);
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('user_id', $userId);

        $this->db->execute();
    }

    public function updateLastLogin($userId)
    {
        $query = "UPDATE users SET last_login = NOW() 
                            WHERE user_id = :user_id";

        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        $this->db->execute();
    }

    public function updateStatus($userId, $status)
    {
        $query = "
            UPDATE users 
            SET status = :status
            WHERE user_id = :user_id
        ";

        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('user_id', $userId);

        $this->db->execute();
    }

    public function getTotalRows()
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE role_id = 2";
        $this->db->query($query);

        return $this->db->fetch()->count;
    }

    public function getAvatar($userId)
    {
        $query = "SELECT avatar_url as avatar FROM users 
            WHERE user_id = :user_id";
        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        $result = $this->db->fetch()->avatar;

        return $result;
    }

    private function checkPassword($password, $hashedPassword)
    {
        $isPasswordCorrect = password_verify($password, $hashedPassword);
        return $isPasswordCorrect;
    }
}