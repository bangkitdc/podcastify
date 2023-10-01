<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'navbars/media_player.css">';

echo '
  <div class="media-player">
    <div class="media-cover">
      
    </div>
    <div class="player">
      <div class="player-controls">
        <button class="play-btn">
          <img src="' . ICONS_DIR . 'play.svg" />
        </button>
      </div>
      <div class="player-timeline">
        <span class="current-time">0:00</span>
        <input id="range" type="range" class="timeline-slider" min="0" max="100" step="1" value="0" />
        <span class="total-time">0:00</span>
      </div>
    </div>
    <div class="volume-controls">
      
    </div>
  </div>
';