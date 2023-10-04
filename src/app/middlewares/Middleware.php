<?php

require_once BASE_URL . "/src/app/helpers/RedirectHelper.php";

class Middleware {
    public static function checkReferer() 
    {
        $excluded_paths = ['/'];

        if (!isset($_SERVER['HTTP_REFERER']) && !in_array($_SERVER['REQUEST_URI'], $excluded_paths)) {
            // If there's no referrer, redirect to home.
            RedirectHelper::redirectHome();
        }
    }

    public static function isAdmin()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            return true;
        }

        return false;
    }

    public static function isLoggedIn() 
    {
        if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }

    public static function checkIsAdmin()
    {
        if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
            throw new Exception('Unauthorized', ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
        }
    }

    public static function checkIsLoggedIn()
    {
        if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
            throw new Exception('Unauthorized', ResponseHelper::HTTP_STATUS_UNAUTHORIZED);
        }
    }
}
