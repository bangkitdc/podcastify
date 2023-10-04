<?php
require_once MODELS_DIR . 'User.php';
require_once SERVICES_DIR . 'user/index.php';

class AuthService {
    public function login($username, $password) {
        $user = new User();

        if (preg_match('/\s/', $username)) {
            throw new Exception("Username contains whitespace", ResponseHelper::HTTP_STATUS_BAD_REQUEST);
        }

        $user = $user->findByUsername($username);

        if (!$this->checkPassword($password, $user->password) || !$user) {
            throw new Exception("Invalid credentials", ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
        }

        if ($user->status !== 1) {
            throw new Exception("Your account has been suspended by Admin", ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
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

        return;
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