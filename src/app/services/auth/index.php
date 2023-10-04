<?php
require_once MODELS_DIR . 'User.php';
require_once SERVICES_DIR . 'user/index.php';

class AuthService {
    public function login($username, $password) {
        $user = new User();

        if (preg_match('/\s/', $username)) {
            return "USERNAME CONTAINS WHITESPACE";
        }

        $user = $user->findByUsername($username);
    
        /* if user doesn't exists */
        if (!$user){
            return "USER NOT FOUND";
        }

        if (!$this->checkPassword($password, $user->password)) {
            return "WRONG PASSWORD";
        }

        $role = "user";
        /* if its admin */ 
        if($user->role_id == 1) {
            $role = "admin"; 
        }

        // Update last login
        $userService = new UserService();
        $userService->updateLastLogin($user->user_id);

        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['role'] = $role;

        return "SUCCESS";
    }

    public function logout() {
        session_unset();
        session_destroy();

        return "SUCCESS";
    }

    private function checkPassword($password, $hashedPassword) {
        $isPasswordCorrect = password_verify($password, $hashedPassword);
        return $isPasswordCorrect;
    }
}