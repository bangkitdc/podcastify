<?php
function episode_detail($episode = null, $premium = false)
{
  require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";

  $id = $episode ? ($premium ? $episode['episode_id'] : $episode->episode_id) : '';
  $creator_id = $episode ? ($premium ? $episode['creator_id'] : $episode->podcast_id) : '';

  $poster = $episode ? ($premium ? ($episode['imageFile'] ?? IMAGES_DIR . "episode-template.png") : ($episode->image_url ? Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->image_url) : IMAGES_DIR . "episode-template.png")) : IMAGES_DIR . "episode-template.png";
  $title = $episode ? ($premium ? $episode['title'] : $episode->title) : '';
  $duration = $episode ? ($premium ? round($episode['duration'] / 60) : round($episode->duration / 60)) : '';
  $upload_date = $episode ? ($premium ? formatDateDetail($episode['created_at']) : formatDateDetail($episode->created_at)) : '';
  $description = $episode ? ($premium ? $episode['description'] : $episode->description) : '';

  $audio_file = $episode ? ($premium ? ($episode['audioFile'] ?? AUDIO_DIR . "spotify-ad.mp3") : ($episode->audio_url ? Storage::getFileUrl(Storage::EPISODE_AUDIO_PATH, $episode->audio_url) : AUDIO_DIR . "spotify-ad.mp3")) : AUDIO_DIR . "spotify-ad.mp3";

  $podcast_title = $episode
    ? ($premium ? ($episode['user']['first_name'] . " " . $episode['user']['last_name'] ?? '')
      : $episode->podcast_title)
    : '';

  $creator_img = $episode ? ($premium
    ? IMAGES_DIR . "avatar-template.png"
    : ($episode->podcast_img
      ? Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->creator_img)
      : IMAGES_DIR . "podcast-template.png"))
    : IMAGES_DIR . "avatar-template.png";

  $likes = $premium ? $episode['episodeLikesCount'] : '';

  echo "
  <head>
  <title>Podcastify | $title</title> 
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
  if (Middleware::isAdmin() && !$premium) {
    echo "       
        <button class=\"episode-detail-head-edit-button\" onclick=\"showEditEpisode($id)\">
        <img id=\"edit-button-image\" alt=\"edit-button\" src=\"" . ICONS_DIR . "/edit.svg\" />
        </button>";
  }

  if ($premium) {

    echo "       
        <div class=\"episode-detail-head-like-button\">
        ";
    if ($episode['episodeLiked']) {
      echo "
        <img id=\"like-button-image\" alt=\"like-button\" src=\"" . ICONS_DIR . "heart-fill.svg\" />
        ";
    } else {
      echo "
        <img id=\"like-button-image\" alt=\"like-button\" src=\"" . ICONS_DIR . "heart.svg\" />
        ";
    }

    echo "
    </div>
        <div class=\"like-info\">
        <p id=\"like-count\"> " . $likes . "</p>
        <p id=\"like-text\">" . ($likes === 1 ? 'like' : 'likes') . "</p>
        </div>
        ";
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
          ";
  if ($premium) {
    echo "
          <p id=\"episode-detail-foot-creator-name\" class=\"episode-detail-foot-creator-name\" onclick=\"window.location.href='/membership/creator/$creator_id'\">$podcast_title</p>
        ";
  } else {
    echo "
          <p id=\"episode-detail-foot-creator-name\" class=\"episode-detail-foot-creator-name\" onclick=\"window.location.href='/podcast/show/$creator_id'\">$podcast_title</p>
        ";
  }

  echo "    
        </div>

      </div>
    ";
  if ($premium) {
    echo '
      <div>
        <h2 class="episode-comment-title">Comment</h2>
        <div class="episode-comment">
          <div id="comment-user-image-container" class="comment-user-image-container" >
          <img class="user-image" src=' . IMAGES_DIR . "avatar-template.png" . ' alt="avatar">
          </div>
          <input id="episode_id" value="' . $id . '" hidden/>
          <div id="comment-input-container" class="comment-input-container" >
            <input type="text" onclick="onClickComment()" placeholder="Enter your comment" class="comment-input" id="comment-input" aria-label="comment-input"/>
            <div id="comment-buttons" class="comment-buttons">
            ';
    baseButton("Cancel", "comment-cancel");
    baseButton("Comment", "comment-submit", "submit");
    // <button class="comment-cancel" onclick="onCancleComment()">Cancel</button>
    //         <button id="" class="btn secondary comment-submit">Comment</button>
    echo '
              
            </div>
          </div>
        </div>
      </div>
      ';
  }

  echo '
        <script src="' . JS_DIR . 'episode/episode.js"></script>
  ';
};

function formatDateDetail($dateString)
{
  $dateTime = new DateTime($dateString);

  $day = $dateTime->format('d');
  $month = $dateTime->format('F');
  $year = $dateTime->format('Y');
  $dayName = $dateTime->format('l');

  return $dayName . ', ' . $day . ' ' . $month . ' ' . $year;
}
