<?php

echo '<link rel="stylesheet" href="' . CSS_DIR .'navbars/topbar.css">';

echo '
  <div class="topbar">
    <div class="btn-flex">
      <button class="btn-topbar">
        <img src="' . ICONS_DIR . 'left-arrow.svg" />
      </button>
      <button class="btn-topbar">
        <img src="' . ICONS_DIR . 'right-arrow.svg" />
      </button>
    </div>
    <div class="btn-flex">
      <button id="dropdown-btn" class="dropdown-btn">
        <img class="profile-img" src="' . IMAGES_DIR . 'avatar-template.png" alt="avatar">
        <p class="text-username">' . (isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest') . '</p>
        <img src="' . ICONS_DIR . 'down-arrow.svg" class="arrow-icon" />
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