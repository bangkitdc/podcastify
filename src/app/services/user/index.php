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

    // public function register($email, $username, $password) {
    //     $user = new User();
    // }
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
}