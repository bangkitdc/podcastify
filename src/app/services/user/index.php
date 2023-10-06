<?php
require_once MODELS_DIR . 'User.php';

class UserService {
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

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

    public function updatePersonalInfo($userId, $email, $username, $firstName, $lastName, $avatarURL)
    {
        // Check if the email, username already exists
        if ($this->user->emailExistsForOthers($userId, $email) && $this->user->usernameExistsForOthers($userId, $username)) {
            throw new Exception('This email and username are already connected to an account.', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        // Check if the email already exists
        if ($this->user->emailExistsForOthers($userId, $username)) {
            throw new Exception('This email is already connected to an account.', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        // Check if the username already exists
        if ($this->user->usernameExistsForOthers($userId, $username)) {
            throw new Exception('This username is already connected to an account', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        $this->user->updateProfile(
            $userId,
            $email,
            $username,
            $firstName,
            $lastName,
            $avatarURL
        );
    }

    public function changePassword($userId, $currentHashedPassword, $newHashedPassword)
    {
        if ($this->user->isCurrentPasswordWrong($userId, $currentHashedPassword)) {
            throw new Exception('Current password is wrong.', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        $this->user->updatePassword($userId, $newHashedPassword);
    }

    public function getUserAvatar($userId)
    {
        return $this->user->getAvatar($userId);
    }
}