<?php
// URL
define('BASE_URL', $_ENV['PWD']);

// DB Connection
define('MYSQL_HOST', $_ENV['MYSQL_HOST']);
define('MYSQL_PORT', $_ENV['MYSQL_PORT']);
define('MYSQL_USER', $_ENV['MYSQL_USER']);
define('MYSQL_PASSWORD', $_ENV['MYSQL_PASSWORD']);
define('MYSQL_DATABASE', $_ENV['MYSQL_DATABASE']);

// Directory
define("MODELS_DIR", BASE_URL . "/src/app/models/");
define("CONTROLLERS_DIR", BASE_URL . "/src/app/controllers/");
define("VIEWS_DIR", BASE_URL . "/src/app/views/");
define("COMPONENTS_SHARES_DIR", BASE_URL . "/src/app/views/components/shares/");
define("COMPONENTS_PRIVATES_DIR", BASE_URL . "/src/app/views/components/privates/");
define("SERVICES_DIR", BASE_URL . "/src/app/services/");
define("STORAGES_DIR", BASE_URL . "/src/storage/");

define("ICONS_DIR", "/src/public/assets/icons/");
define("IMAGES_DIR", "/src/public/assets/images/");
define("FONTS_DIR", "/src/public/assets/fonts/");
define("CSS_DIR", "/src/public/css/");
define("JS_DIR", "/src/public/js/");

// File
define('MAX_SIZE', 16 * 1024 * 1024); // 16 mb
define('ALLOWED_AUDIOS', [
  'audio/mpeg' => '.mp3',
  'audio/aac' => '.aac',
  'audio/ogg' => '.ogg',
  'audio/wav' => '.wav',
  'audio/flac' => '.flac',
  'audio/opus' => '.opus',
]);

define('ALLOWED_IMAGES', [
  'image/jpeg' => '.jpeg',
  'image/jpg' => '.jpg',
  'image/webp' => '.jpg',
  'image/png' => '.png'
]);
