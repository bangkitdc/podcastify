<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Discover a world of captivating stories and insightful conversations on Podcastify. Explore a diverse range of podcasts, from engaging interviews to gripping narratives. Dive into a seamless listening experience and stay connected to your favorite topics. Start your podcast journey with Podcastify today.">
  <link rel="stylesheet" href="<?= CSS_DIR ?>global.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>error.css">
  <link rel="apple-touce-icon" sizes="180x180" href="<?= ICONS_WEB_DIR ?>apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= ICONS_WEB_DIR ?>favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= ICONS_WEB_DIR ?>favicon-16x16.png">
  <link rel="icon" type="image/x-icon" href="<?= ICONS_WEB_DIR ?>favicon.ico">
  <link rel="manifest" href="<?= ICONS_WEB_DIR ?>manifest.json">
  <title>Podcastify | Page not found</title>
</head>

<body>
  <div id="content">
    <?php
    $included = include VIEWS_DIR . "pages/errors/404.php";
    ?>
  </div>
</body>

</html>