<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'navbars/sidebar.css">';

echo '
  <div class="sidebar">
    <div class="top-icons">
      <a href="/" class="icon-text">
        <div id="home-nav" class="link-flex">
          <img src="' . ICONS_DIR . 'home-active.svg" alt="Home" />
          <div class="icon-text">
            Home
          </div>
        </div>
      </a>
      <a href="/podcast">
        <div id="search-nav" class="link-flex">
          <img src="' . ICONS_DIR . 'search-inactive.svg" alt="Search" />
          <div class="icon-text">
            Search
          </div>
        </div>
      </a>
    </div>

    <div class="mid-icons">
      <a href="/podcast" class="icon-text">
        <div id="podcast-nav" class="link-flex">
          <img src="' . ICONS_DIR . 'podcast.svg" alt="Podcast" />
          <div>Podcast</div>
        </div>
      </a>
      <a href="/episode" class="icon-text">
        <div id="episode-nav" class="link-flex">
          <img src="' . ICONS_DIR . 'episode.svg" alt="Episode" />
          <div>Episode</div>
        </div>
      </a>
';

if (Middleware::isAdmin() && Middleware::isLoggedIn()) {
  echo '
      <a href="/podcast/add" class="icon-text">
        <div id="podcast-add-nav" class="link-flex">
          <img src="' . ICONS_DIR . 'add-circle.svg" alt="Add Podcast" />
          <div>Add Podcast</div>
        </div>
      </a>
      <a href="/episode/add" class="icon-text">
        <div id="episode-add-nav" class="link-flex">
          <img src="' . ICONS_DIR . 'add-circle.svg" alt="Add Episode" />
          <div>Add Episode</div>
        </div>
      </a>
      <a href="/user" class="icon-text">
      <div id="user-nav" class="link-flex">
        <img src="' . ICONS_DIR . 'user.svg" alt="Users List" />
        <div>Users List</div>
      </div>
      </a>
  ';
}

echo '
    </div>
  </div>
';

echo '
  <script>
    var ICONS_DIR = "' . ICONS_DIR . '";
  </script>
  <script src="' . JS_DIR . 'sidebar.js"></script>
';
