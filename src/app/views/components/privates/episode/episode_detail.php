<?php
function episode_detail($episode = null)
{
  $id = $episode ? $episode->episode_id : '';
  $creator_id = $episode ? $episode->podcast_id : '';
  $poster = is_file(Storage::EPISODE_IMAGE_PATH . $episode->image_url) ? Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->image_url) : IMAGES_DIR . "episode-template.png";
  $title = $episode ? $episode->title : '';
  $duration = $episode ? $episode->duration / 60 : '';
  $upload_date = $episode ? formatDate($episode->created_at) : '';
  $description = $episode ? $episode->description : '';

  $creator_img = $episode ? Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->creator_img) : '';
  $podcast_title = $episode ? $episode->podcast_title : '';
  $audio_file = $episode->audio_url ? Storage::getFileUrl(Storage::EPISODE_AUDIO_PATH, $episode->audio_url) : "/src/public/assets/audio/spotify-ad.mp3";

  echo"
  <head>
  <title>$title</title> 
  </head>";
  echo "
      <div class=\"episode-detail-head\">
    ";
  if ($poster) {
    echo
    "<div>
      <img alt=\"poster-image\" id=\"episode-detail-head-image\" class=\"episode-detail-head-image\" src=\"$poster\">
      </div>";
  } else {
    echo
    "
      <div class=\"episode-detail-head-image-empty\"></div>
      ";
  }
  echo "
        <p id=\"episode-detail-head-title\" class=\"episode-detail-head-title\">$title</p>
        <p class=\"episode-detail-head-duration\">$duration minutes</p>
        <button id=\"play-button\" class=\"episode-detail-head-play-button\"\" onclick=\"playAudio()\">
        <img alt=\"play-button\" class=\"\" id=\"button-image\" src=\"" . ICONS_DIR . "play.svg\" />
        </button>
      ";
  if (Middleware::isAdmin()) {
    echo "       
        <button class=\"episode-detail-head-edit-button\" onclick=\"showEditEpisode($id)\">
        <img alt=\"edit-button\" src=\"" . ICONS_DIR . "/edit.svg\" />
        </button>";
  }
  echo "
      </div>

      <div class=\"episode-detail-line\">
    
      </div>

      <div class=\"episode-detail-foot\">
        <p class=\"episode-detail-foot-date\">$upload_date</p>
        <p class=\"episode-detail-foot-description\">$description</p>

        <div class=\"episode-detail-foot-creator\">
        <input id=\"audio-file\" value=\"$audio_file\" hidden>
        <input id=\"creator_id\" value=\"$creator_id\" hidden>
          <img alt=\"creator-image\" class=\"episode-detail-foot-creator-image\" src=\"$creator_img\">
          <p id=\"episode-detail-foot-creator-name\" class=\"episode-detail-foot-creator-name\" onclick=\"window.location.href='/podcast/show/$creator_id'\">$podcast_title</p>
        </div>

      </div>
    ";

  echo '
        <script src="' . JS_DIR . 'episode/episode.js"></script>
  ';
};

function formatDate($dateString)
{
  $dateTime = new DateTime($dateString);

  $day = $dateTime->format('d');
  $month = $dateTime->format('F');
  $year = $dateTime->format('Y');
  $dayName = $dateTime->format('l');

  return $dayName . ', ' . $day . ' ' . $month . ' ' . $year;
}
