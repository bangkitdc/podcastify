<?php

class RedirectHelper 
{
    public static function redirectHome()
    {
        header("Location: /", true, ResponseHelper::HTTP_STATUS_MOVED_PERMANENTLY);
        exit;
    }

    public static function redirectTo($page, $replace = true, $statusCode = ResponseHelper::HTTP_STATUS_MOVED_PERMANENTLY)
    {
        header("Location: " . $page, $replace, $statusCode);
        exit;
    }
}