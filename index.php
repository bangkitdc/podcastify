<?php
require_once $_ENV['PWD'] . '/src/init.php';
if (!session_id() || session_status() == 0) {
  session_start();
};
$app = new App();
