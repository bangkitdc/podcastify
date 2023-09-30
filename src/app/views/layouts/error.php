<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/src/public/css/global.css">
    <link rel="stylesheet" href="/src/public/css/error.css">
    <title>Page not found</title>
  </head>
  <body>
    <div id="content">
      <?php
        $included = include VIEW_DIR . "pages/errors/404.php";
      ?>
    </div>
  </body>
</html>