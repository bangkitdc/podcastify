<?php
require_once MODELS_DIR . 'User.php';
require_once SERVICES_DIR . 'user/index.php';

class AuthService {
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function login($username, $password) {
        $user = $this->user->findByUsername($username);

        if (!$user || !$this->checkPassword($password, $user->password)) {
            throw new Exception("Invalid credentials", ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
        }

        if ($user->status != 1) {
            throw new Exception("Your account has been suspended by Admin", ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
        }

        $role = "user";
        /* if it's Admin */ 
        if($user->role_id == 1) {
            $role = "admin"; 
        }

        // Update last login
        $userService = new UserService();
        $userService->updateLastLogin($user->user_id);

        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['role'] = $role;

        return;
    }

    public function register($email, $username, $hashedPassword, $firstName, $lastName)
    {
        // Check if the email, username already exists
        if ($this->user->emailExists($email) && $this->user->usernameExists($username)) {
            throw new Exception('This email and username are already connected to an account', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        // Check if the email already exists
        if ($this->user->emailExists($email)) {
            throw new Exception('This email is already connected to an account', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        // Check if the username already exists
        if ($this->user->usernameExists($username)) {
            throw new Exception('This username is already connected to an account', ResponseHelper::HTTP_STATUS_FORBIDDEN);
        }

        $this->user->create(
            $email,
            $username,
            $hashedPassword,
            $firstName,
            $lastName
        );
    }

    public function logout() {
        session_unset();
        session_destroy();

        return;
    }

    private function checkPassword($password, $hashedPassword) {
        $isPasswordCorrect = password_verify($password, $hashedPassword);
        return $isPasswordCorrect;
    }
}