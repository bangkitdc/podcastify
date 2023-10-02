<?php
// Get the full URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Parse the URL to extract the path part
$urlParts = parse_url($currentUrl);
$path = isset($urlParts['path']) ? $urlParts['path'] : '';
$pathArray = explode('/', trim($path, '/'));

// Handle the root path
if (!$pathArray[0]) {
    include VIEWS_DIR . "pages/home/index.php";
} else {
    switch ($pathArray[0]) {
        case 'login':
            include VIEWS_DIR . "pages/auth/login.php";
            break;
        case 'register':
            include VIEWS_DIR . "pages/auth/register.php";
            break;
        case 'home':
            include VIEWS_DIR . "pages/home/index.php";
            break;
        case 'podcast':
            if (!$pathArray[1]) {
                include  VIEWS_DIR . "pages/" . $path . "/index.php";
                break;
            } else {
                switch ($pathArray[1]) {
                    case 'manage':
                        include VIEWS_DIR . "pages/podcast/podcast_management.php";
                        break;
                }
            }
        default:
            include VIEWS_DIR . "pages/errors/404.php";
            break;
    }
}
