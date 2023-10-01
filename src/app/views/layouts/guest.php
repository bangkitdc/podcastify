<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= CSS_DIR ?>global.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>guest.css">
  <title></title>
</head>

<body>
  <div class="container">
    <div class="header">
      <button class="btn-logo" onclick="window.location.href = '/'">
        <div class="icon">
          <img src="<?= ICONS_DIR ?>logo-bw.svg" alt="Logo" width="36px">
        </div>
        <h2>Podcastify</h2>
      </button>
    </div>
    <div class="content">
      <div class="form">
        <?php
          $included = include VIEWS_DIR . "pages/auth/login.php";
        ?>
      </div>
    </div>
  </div>
</body>

</html>