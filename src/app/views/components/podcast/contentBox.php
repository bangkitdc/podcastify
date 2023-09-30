<?php
// Podcast box component
function baseContentBox($podcast = null, $is_skeleton = false) {
    $title = $podcast ? $podcast->title : '';
    $creator_name = $podcast ? $podcast->creator_name : '';
    $content_box_class = $is_skeleton ? 'podcast-content-skeleton' : 'base-content-box';

    echo "
      <div class=\"podcast-content-container\">
        <div class=\"{$content_box_class}\">
          <img src=\"\" alt=\"podcastImage\">
        </div>
        <p class=\"podcast-title\">{$title}</p>
        <br />
        <p class=\"podcast-creator\">{$creator_name}</p>
      </div>
    ";
}
