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
        case '/podcast':
            include  VIEWS_DIR . "pages/" . $path . "/index.php";
            break;
        case '/home':
            include VIEWS_DIR . "pages/home/index.php";
            break;
        case '/podcast/manage':
            include VIEWS_DIR . "pages/podcast/podcast_management.php";
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
