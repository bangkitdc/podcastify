<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_notification.css">
</head>

<?php

function echoNotification()
{
  echo '
    <div id="notification" class="notification">
      <div id="notification-text" class="notification-text"></div>
    </div>
  ';
}
