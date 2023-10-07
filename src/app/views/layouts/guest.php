<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Discover a world of captivating stories and insightful conversations on Podcastify. Explore a diverse range of podcasts, from engaging interviews to gripping narratives. Dive into a seamless listening experience and stay connected to your favorite topics. Start your podcast journey with Podcastify today.">
  <link rel="stylesheet" href="<?= CSS_DIR ?>global.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>guest.css">
</head>

<body>
  <div class="container">
    <div class="header">
      <button class="btn-logo" onclick="window.location.href = '/'">
        <div class="icon">
          <img class="icon-img" src="<?= ICONS_DIR ?>logo-bw.svg" alt="Logo">
        </div>
        <h2>Podcastify</h2>
      </button>
    </div>
    <div class="content">
      <div class="form">
        <?php
        $included = include VIEWS_DIR . "view_config.php";
        ?>
      </div>
    </div>

    <?php
    require_once COMPONENTS_SHARES_DIR . 'notifications/primary.php';

    echoNotification();
    ?>
  </div>
</body>

<script src="<?= JS_DIR ?>components/notification.js"></script>

</html>