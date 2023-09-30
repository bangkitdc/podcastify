<?php 
// URL
define('BASE_URL', $_ENV['PWD']);

// DB Connection
define('MYSQL_HOST', $_ENV['MYSQL_HOST']);
define('MYSQL_PORT', $_ENV['MYSQL_PORT']);
define('MYSQL_USER', $_ENV['MYSQL_USER']);
define('MYSQL_PASSWORD', $_ENV['MYSQL_PASSWORD']);
define('MYSQL_DATABASE', $_ENV['MYSQL_DATABASE']);

define("MODELS_DIR", BASE_URL . "/src/app/models/");
define("CONTROLLERS_DIR", BASE_URL . "/src/app/controllers/");
define("VIEWS_DIR", BASE_URL . "/src/app/views/");
define("SERVICES_DIR", BASE_URL . "/src/app/services/");

define("ICONS_DIR", "/src/public/assets/icons/");
define("IMAGES_DIR", "/src/public/assets/images/");
define("FONTS_DIR", "/src/public/assets/fonts/");
define("CSS_DIR", "/src/public/css/");
define("JS_DIR", "/src/public/js/");
