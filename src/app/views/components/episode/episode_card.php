<?php

require_once BASE_URL . '/src/config/storage.php';

function episode_card($episode = null)
{
  $id = $episode ? $episode->episode_id : '';
  $title = $episode ? $episode->title : '';
  $creator = $episode ? $episode->creator_name : '';
  $duration = $episode ? $episode->duration / 60 : '';
  $card_type = $episode->image_url ? Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->image_url) : '';

  echo "
    <div class=\"episode-card\" onclick=\"window.location.href='/episode/$id'\">

    ";
  if ($card_type) {
    echo "
    <div class=\"episode-img-container\">
    <img class=\"card-image\" src=\"$card_type\"/>
    </div>";
  } else {
    echo "
    <div class=\"episode-no-img-container\">
    <div class=\"no-card-image\"></div>
    </div>";
  }
  echo "
        <p class=\"episode-card-title\">$title</p>
        <p class=\"episode-card-creator\">$creator</p>
        <p class=\"episode-card-duration\">{$duration} minutes</p>
    </div>
  ";
}
