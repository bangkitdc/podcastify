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

    public static function isLogin() 
    {
        if (isset($_SESSION['username']) && isset($_SESSION['userId'])) {
            return true;
        }

        return false;
    }
}
