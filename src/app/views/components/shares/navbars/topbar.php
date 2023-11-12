<?php

echo '<link rel="stylesheet" href="' . CSS_DIR .'navbars/topbar.css">';

echo '
  <div class="topbar">
    <div class="btn-flex">
      <button id="burger-btn" class="burger-btn">
        <img src="' . ICONS_DIR . 'burger.svg" alt="Show More">
      </button>
    </div>
    <div id="show-more" class="show-more">
      <div class="left-menu" aria-labelledby="show-more-btn">
        <div id="close-btn" class="close-btn" onclick="">
          <img src="' . ICONS_DIR . 'close.svg" alt="Close Button">
        </div>
        <ul class="list">
          <li>
            <button onclick="window.location.href = \'/home\'">
              <img src="' . ICONS_DIR . 'home-active.svg" alt="Home" />
              Home
            </button>
          </li>
          <li>
            <button onclick="window.location.href = \'/podcast\'">
              <img src="' . ICONS_DIR . 'search-inactive.svg" alt="Search" />
              Search
            </button>
          </li>
          <li>
            <button onclick="window.location.href = \'/podcast\'">
              <img src="' . ICONS_DIR . 'podcast.svg" alt="Podcast" />
              Podcast
            </button>
          </li>
          <li>
            <button onclick="window.location.href = \'/episode\'">
              <img src="' . ICONS_DIR . 'episode.svg" alt="Episode" />
              Episode
            </button>
          </li>
          <li>
            <button onclick="window.location.href = \'/membership\'">
              <img src="' . ICONS_DIR . 'membership.svg" alt="Membership" />
              Membership
            </button>
          </li>
  ';

if (Middleware::isAdmin()) {
  echo
  '
          <li>
            <button onclick="window.location.href = \'/podcast/add\'">
              <img src="' . ICONS_DIR . 'add-circle.svg" alt="Add Podcast" />
              Add Podcast
            </button>
          </li>
          <li>
            <button onclick="window.location.href = \'/episode/add\'">
              <img src="' . ICONS_DIR . 'add-circle.svg" alt="Add Episode" />
              Add Episode
            </button>
          </li>
          <li>
            <button onclick="window.location.href = \'/user\'">
              <img src="' . ICONS_DIR . 'user.svg" alt="Users List" />
              Users List
            </button>
          </li>
  ';
}

echo '
        </ul>
      </div>
    </div>
    <div class="btn-flex">
      <button id="dropdown-btn" class="dropdown-btn">
        <img class="profile-img" src="' . IMAGES_DIR . 'avatar-template.png" alt="avatar">
        <p class="text-username">' . (isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest') . '</p>
        <img alt="topbar-dropdown" src="' . ICONS_DIR . 'down-arrow.svg" class="arrow-icon" />
      </button>
    </div>
    <div id="dropdown-topbar" class="dropdown-container">
      <ul class="dropdown-menu" aria-labelledby="dropdownDefaultButton">
';

if (Middleware::isLoggedIn()) {
  echo '
        <li>
          <button class="dropdown-link" onclick="window.location.href = \'/profile\'">Profile</button>
        </li>
        <li class="bottom-link">
          <form method="POST" action="/user/logout">
            <button class="dropdown-link">Log out</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
  ';
} else {
  echo '
        <li>
          <a href="/register" class="dropdown-link">Sign up</a>
        </li>
        <li class="bottom-link">
          <a href="/login" class="dropdown-link">Log in</a>
        </li>
      </ul>
    </div>
  </div>
  ';
}