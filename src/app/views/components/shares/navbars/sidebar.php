<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'navbars/sidebar.css">';

echo '
  <div class="sidebar">
    <div class="top-icons">
      <div id="home-nav" class="link-flex">
        <img src="' . ICONS_DIR . 'home-active.svg" alt="Home" />
        <a href="/" class="icon-text">Home</a>
      </div>
      <div id="search-nav" class="link-flex">
        <img src="' . ICONS_DIR . 'search-inactive.svg" alt="Search" />
        <a href="/search" class="icon-text">Search</a>
      </div>
    </div>

    <div class="mid-icons">
      <div id="podcast-nav" class="link-flex">
        <img src="' . ICONS_DIR . 'podcast.svg" alt="Podcast" />
        <a href="/podcast" class="icon-text">Podcast</a>
      </div>
      <div id="episode-nav" class="link-flex">
        <img src="' . ICONS_DIR . 'episode.svg" alt="Episode" />
        <a href="/episode" class="icon-text">Episode</a>
      </div>
';

if (isset($_SESSION['userId']) && $_SESSION['role'] === 'admin') {
  echo '
    <div id="podcast-add-nav" class="link-flex">
      <img src="' . ICONS_DIR . 'add-circle.svg" alt="Add Podcast" />
      <a href="/podcast/add" class="icon-text">Add Podcast</a>
    </div>
    <div id="episode-add-nav" class="link-flex">
      <img src="' . ICONS_DIR . 'add-circle.svg" alt="Add Episode" />
      <a href="/episode/add" class="icon-text">Add Episode</a>
    </div>
    <div id="user-nav" class="link-flex">
      <img src="' . ICONS_DIR . 'user.svg" alt="Users List" />
      <a href="/user" class="icon-text">Users List </a>
    </div>
  ';
} else {
  echo '
    </div>
      </div>
  ';
}

echo '
  <script>
    var ICONS_DIR = "' . ICONS_DIR . '";
  </script>
  <script src="' . JS_DIR . 'sidebar.js"></script>
';