<?php
require_once MODELS_DIR . 'User.php';

class UserService {
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }
    // public function detail($userId) {
    //     $user = new User();
    //     $user = $user->findById($userId);
    //     $resp = array();

    //     if(isset($user)){
    //         $resp['data'] = [];
    //         $resp['status_message'] = "USER NOT FOUND";
    //         return $resp;
    //     }
    // }

    public function getUser($userId)
    {
        $data = $this->user->findById($userId);

        if (!isset($data)) {
            throw new Exception("User not found", ResponseHelper::HTTP_STATUS_NOT_FOUND);
        }

        return $data;
    }

    public function getUsers($page = 1, $limit = 10)
    {
        return $this->user->findAll($page, $limit);
    }

    public function getTotalUsers()
    {
        return $this->user->getTotalRows();
    }

    public function updateLastLogin($userId)
    {
        $this->user->updateLastLogin($userId);
    }

    public function updateStatus($userId, $status)
    {
        $this->user->updateStatus($userId, $status);
    }
}