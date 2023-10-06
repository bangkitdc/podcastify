<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'navbars/media_player.css">';

echo '
  <div class="media-player">
    <div id="media-cover" class="media-cover">
      
    </div>
    <div class="player">
      <div class="player-controls">
      <audio id="audio-player" hidden></audio>
        <button class="play-btn" id="play-btn">
          <img class="audio-active" id="play-button-image" src="' . ICONS_DIR . 'play.svg" />
        </button>
      </div>
      <div class="player-timeline">
        <span id="slider-current-time" class="current-time">-:--</span>
        <input id="range" type="range" class="timeline-slider" min="0" max="100" step="1" value="0"/>
        <span id="slider-total-time" class="total-time">-:--</span>
      </div>
    </div>
    <div class="volume-controls">
      <button id="mute-button">
      <img id="mute-button-img" src="' . ICONS_DIR . 'volume.svg" />
      </button>
      <input id="volume-slider" type="range" min="0" max="1" step="0.01" value="1">
    </div>
  </div>
  <script src="' . JS_DIR . 'episode/media_player.js"></script>
';