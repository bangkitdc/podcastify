<?php
function episode_card($episode = null)
{
  $id = $episode ? $episode->episode_id : '';
  $title = $episode ? $episode->title : '';
  $creator = $episode ? $episode->creator_name : '';
  $duration = $episode ? $episode->duration / 60 : '';
  $card_type = $episode->image_url ?? false;

  if ($card_type) {
    echo "
    <div class=\"episode-card\">
      <div class=\"episode-card-image\">
        <img class=\"card-image\" src=\"$card_type\"/>
      </div>
      <div class=\"episode-card-description\">
        <a class=\"episode-card-title\" href=\"/episode/episode_detail?episode_id=$id\">
         $title
        </a>
        <p class=\"episode-card-creator\">$creator</p>
        <p class=\"episode-card-duration\">{$duration} minutes</p>
      </div>
    </div>
  ";
  } else {
    echo "
    <div class=\"episode-card\">
      <div class=\"episode-card-image\">
        <div class=\"no-card-image\"></div>
      </div>
      <div class=\"episode-card-description\">
        <a class=\"episode-card-title\" href=\"/episode/episode_detail?episode_id=$id\">
          $title
        </a>
        <p class=\"episode-card-creator\">$creator</p>
        <p class=\"episode-card-duration\">{$duration} minutes</p>
      </div>
    </div>
  ";
  }
}
