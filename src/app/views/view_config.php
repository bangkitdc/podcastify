<?php
// Get the full URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Parse the URL to extract the path part
$urlParts = parse_url($currentUrl);
$path = isset($urlParts['path']) ? $urlParts['path'] : '';

switch ($path) {
  // case 'error':
  //   include  VIEW_DIR . "components/" . $page . ".php";
  //   break;

  default:
    include VIEW_DIR . "pages/errors/404.php";
    break;
}
