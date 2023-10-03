<?php
function episode_card($episode = null, $click_event = '')
{
  $id = $episode ? $episode->episode_id : '';
  $title = $episode ? $episode->title : '';
  $creator = $episode ? $episode->creator_name : '';
  $duration = $episode ? $episode->duration / 60 : '';
  $card_type = $episode->image_url ? IMAGES_DIR . $episode->image_url : '';

  echo "
    <div class=\"episode-card\" onclick=\"$click_event\">
      <div class=\"episode-card-image\">
    ";
  if ($card_type) {
    echo "<img class=\"card-image\" src=\"$card_type\"/>";
  } else {
    echo "<div class=\"no-card-image\"></div>";
  }
  echo "
      </div>
      <div class=\"episode-card-description\">
        <p class=\"episode-card-title\">$title</p>
        <p class=\"episode-card-creator\">$creator</p>
        <p class=\"episode-card-duration\">{$duration} minutes</p>
      </div>
    </div>
  ";
}
