<?php
function episode_detail($episode = null) {
  $poster = $episode ? $episode->image_url : '';
  $title = $episode ? $episode->title : '';
  $duration = $episode ? $episode->duration/60 : '';
  $upload_date = $episode ? $episode->created_at : '';
  $description = $episode ? $episode->description : '';
  // $categories = $episode ? $episode->category_name : '';
  $creator_img = $episode ? $episode->creator_img : '';
  $creator_name = $episode ? $episode->creator_name : '';

  echo "
    <div class=\"episode-detail-head\">
      <div class=\"\">
        <img class=\"episode-detail-head-image\" src=\"$poster\">
      </div>
      <p class=\"episode-detail-head-title\">$title</p>
      <p class=\"episode-detail-head-duration\">$duration minutes</p>
      <button class=\"episode-detail-head-button\">
        <img src=\"src/public/assets/icons/play_circle.png\">
      </button>
    </div>

    <div class=\"episode-detail-line\">
  
    </div>

    <div class=\"episode-detail-foot\">
      <p class=\"episode-detail-foot-date\">$upload_date</p>
      <p class=\"episode-detail-foot-description\">$description</p>
      <div class=\"episode-detail-foot-categories\">

      </div>

      <div class=\"episode-detail-foot-creator\">
        <img class=\"episode-detail-foot-creator-image\" src=\"$creator_img\">
        <p class=\"episode-detail-foot-creator-name\">$creator_name</p>
      </div>

    </div>
";
};
