<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= CSS_DIR ?>/global.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>/default.css">
</head>

<body>
  <div class="container">
    <div class="sidebar">
      <div class="top-icons">
        <div id="home-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/home-active.svg" alt="Home" />
          <a href="/" class="icon-text">Home</a>
        </div>
        <div id="search-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/search-inactive.svg" alt="Search" />
          <a href="/search" class="icon-text">Search</a>
        </div>
      </div>

      <div class="mid-icons">
        <div id="podcast-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/podcast.svg" alt="Podcast" />
          <a href="/podcast" class="icon-text">Podcast</a>
        </div>
        <div id="episode-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/episode.svg" alt="Episode" />
          <a href="/episode" class="icon-text">Episode</a>
        </div>
        <div id="podcast-add-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/add-circle.svg" alt="Library" />
          <a href="/podcast/add" class="icon-text">Add Podcast</a>
        </div>
        <div id="episode-add-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/add-circle.svg" alt="Library" />
          <a href="/episode/add" class="icon-text">Add Episode</a>
        </div>
        <div id="user-nav" class="link-flex">
          <img src="<?= ICONS_DIR ?>/user.svg" alt="Library" />
          <a href="/user" class="icon-text">Users List </a>
        </div>
      </div>
    </div>

    <div id="content" class="content">
      <div class="navbar">
        <div class="btn-flex">
          <button class="btn-navbar">
            <img src="<?= ICONS_DIR ?>/left-arrow.svg" />
          </button>
          <button class="btn-navbar">
            <img src="<?= ICONS_DIR ?>/right-arrow.svg" />
          </button>
        </div>
        <div class="btn-flex">
          <button id="dropdown-btn" class="dropdown-btn">
            <img class="profile-img" src="<?= IMAGES_DIR ?>/avatar-template.png" alt="avatar">
            <p class="text-username">Guest</p>
            <img src="<?= ICONS_DIR ?>/down-arrow.svg" class="down-arrow-icon" />
          </button>
        </div>
        <div id="dropdown" class="dropdown-container">
          <ul class="dropdown-menu" aria-labelledby="dropdownDefaultButton">
            <li>
              <a href="#" class="dropdown-link">Profile</a>
            </li>
            <li class="logout-link">
              <a href="#" class="dropdown-link">Log out</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="main-content">
        <?php
        $included = include VIEW_DIR . "view_config.php";
        ?>
      </div>
    </div>
    <div class="media-player">
      <div class="media-cover">
        1
      </div>
      <div class="player">
        <div class="player-controls">
          <button class="play-btn">
            <img src="<?= ICONS_DIR ?>/play.svg" />
          </button>
        </div>
        <div class="player-timeline">
          <span class="current-time">0:00</span>
          <input id="range" type="range" class="timeline-slider" min="0" max="100" step="1" value="0" />
          <span class="total-time">0:00</span>
        </div>
      </div>
      <div class="volume-controls">
        3
      </div>
    </div>
  </div>
</body>

<script>
  var ICONS_DIR = '<?= ICONS_DIR ?>';
</script>
<script src="<?= JS_DIR ?>/default.js"></script>
<script src="<?= JS_DIR ?>/navbar.js"></script>

</html>