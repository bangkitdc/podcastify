<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/src/public/css/global.css">
  <link rel="stylesheet" href="/src/public/css/default.css">
  <title>Podcastify - Web Player: Podcast for everyone</title>
</head>

<body>
  <div class="container">
    <div class="sidebar">

    </div>
    <div id="content" class="content">
      <?php
        $included = include VIEW_DIR . "view_config.php";
      ?>
    </div>
    <div class="media-player">

    </div>
  </div>
</body>

</html>