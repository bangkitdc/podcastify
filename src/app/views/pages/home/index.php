<head>
  <title>Podcastify - Web Player: Podcast for everyone</title>
  <link rel="stylesheet" href="<?= CSS_DIR ?>home.css">
</head>
<div id="template">
  <div class="main-content">
    <?php
    $user = $_SESSION['username'] ?? 'Guest';

    // Get the current hour
    $currentHour = date('G') + 7;

    // Set the greeting based on the time of day
    if ($currentHour >= 5 && $currentHour < 12) {
      $greeting = 'Good morning';
    } else if ($currentHour >= 12 && $currentHour < 18) {
      $greeting = 'Good afternoon';
    } else if ($currentHour >= 18 && $currentHour < 24) {
      $greeting = 'Good evening';
    } else {
      $greeting = 'Good night';
    }

    echo "<h1 id='greeting'>$greeting, $user!</h1>";
    ?>
    <div class="podcast-list">
      <h2>Made For You</h2>
      <div class="cards-container">
      </div>
    </div>
  </div>
</div>
<script src="<?= JS_DIR ?>home/home.js"></script>