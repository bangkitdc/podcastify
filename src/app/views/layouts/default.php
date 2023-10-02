<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= CSS_DIR ?>/global.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>/default.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>/episode/episode_card.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>/episode/episode_detail.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>/episode/add_episode.css">
</head>

<body>
  <div class="container">
    <?php include_once COMPONENTS_SHARES_DIR . "/navbars/sidebar.php" ?>
    <div id="content" class="content">
      <div class="background-container"></div>
      <?php include_once COMPONENTS_SHARES_DIR . "/navbars/topbar.php" ?>
      <div id="main-content"  class="main-content">
        <?php
        $included = include VIEWS_DIR . "view_config.php";
        ?>
      </div>
    </div>

    <?php include_once COMPONENTS_SHARES_DIR . "/navbars/media_player.php" ?>
  </div>
</body>

<script src="<?= JS_DIR ?>default.js"></script>
<script src="<?= JS_DIR ?>topbar.js"></script>

</html>
