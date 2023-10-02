<?php
// Get the full URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Parse the URL to extract the path part
$urlParts = parse_url($currentUrl);
$path = isset($urlParts['path']) ? $urlParts['path'] : '';

// Handle the root path
if ($path === '/') {
    include VIEWS_DIR . "pages/home/index.php";
} else {
    switch ($path) {
        case '/home':
            include VIEWS_DIR . "pages/home/index.php";
            break;
        case '/podcast':
            include  VIEWS_DIR . "pages/" . $path . "/index.php";
            break;
        case (preg_match('/^\/podcast\/show\/.+$/', $path) ? true : false):
            include  VIEWS_DIR . "pages/podcast/podcast_detail.php";
            break;
        case (preg_match('/^\/podcast\/edit\/.+$/', $path) ? true : false):
        case '/podcast/add':
            include VIEWS_DIR . "pages/podcast/podcast_management.php";
            break;
        case (preg_match('/^\/podcast\/search\?key=[a-zA-Z0-9%]+$/', $path) ? true : false):
            include  VIEWS_DIR . "pages/podcast/index.php";
            break;

        default:
            include VIEWS_DIR . "pages/errors/404.php";
            break;
    }
    // // Check if the file exists for the given path
    // $filePath = VIEWS_DIR . "pages/" . $path . ".php";

    // if (file_exists($filePath)) {
    //     include $filePath;
    // } else {
    //     // The file doesn't exist, include the 404 page
    //     include VIEWS_DIR . "pages/errors/404.php";
    // }
}
