<?php
function episode_detail($episode = null)
{
  $id = $episode ? $episode->episode_id : '';
  $poster = $episode ? IMAGES_DIR . $episode->image_url : '';
  $title = $episode ? $episode->title : '';
  $duration = $episode ? $episode->duration / 60 : '';
  $upload_date = $episode ? formatDate($episode->created_at) : '';
  $description = $episode ? $episode->description : '';

  $creator_img = $episode ? IMAGES_DIR . $episode->creator_img : '';
  $creator_name = $episode ? $episode->creator_name : '';

  if ($poster) {
    echo "
      <div class=\"episode-detail-head\">
        <div class=\"\">
          <img class=\"episode-detail-head-image\" src=\"$poster\">
        </div>
        <p class=\"episode-detail-head-title\">$title</p>
        <p class=\"episode-detail-head-duration\">$duration minutes</p>
        <button class=\"episode-detail-head-button\">
          <img src=\"/src/public/assets/icons/play_circle.png\">
        </button>
        <button type=\"button\" onclick=\"window.location.href = '/episode/$id?edit=true'\">Edit</button>
      </div>

      <div class=\"episode-detail-line\">
    
      </div>

      <div class=\"episode-detail-foot\">
        <p class=\"episode-detail-foot-date\">$upload_date</p>
        <p class=\"episode-detail-foot-description\">$description</p>

        <div class=\"episode-detail-foot-creator\">
          <img class=\"episode-detail-foot-creator-image\" src=\"$creator_img\">
          <p class=\"episode-detail-foot-creator-name\">$creator_name</p>
        </div>

      </div>
    ";
  } else {
    echo "
      <div class=\"episode-detail-head\">
        <div class=\"episode-detail-head-image-empty\">

        </div>
        <p class=\"episode-detail-head-title\">$title</p>
        <p class=\"episode-detail-head-duration\">$duration minutes</p>
        <button class=\"episode-detail-head-button\">
          <img src=\"/src/public/assets/icons/play_circle.png\">
        </button>
        <button type=\"button\" onclick=\"window.location.href = '/episode/$id/?edit=true'\">Edit</button>
      </div>

      <div class=\"episode-detail-line\">
    
      </div>

      <div class=\"episode-detail-foot\">
        <p class=\"episode-detail-foot-date\">$upload_date</p>
        <p class=\"episode-detail-foot-description\">$description</p>

        <div class=\"episode-detail-foot-creator\">
          <img class=\"episode-detail-foot-creator-image\" src=\"$creator_img\">
          <p class=\"episode-detail-foot-creator-name\">$creator_name</p>
        </div>

      </div>
    ";
  }
};

function formatDate($dateString)
{
  $dateTime = new DateTime($dateString);

  $day = $dateTime->format('d');
  $month = $dateTime->format('F');
  $year = $dateTime->format('Y');
  $dayName = $dateTime->format('l');  

  return $dayName . ', ' . $day . ' '. $month . ' ' . $year;
}