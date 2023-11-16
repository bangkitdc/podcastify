<?php
function creator_detail($creator = null)
{
  require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";

  $creator_id = $creator['user_id'];
  $poster = IMAGES_DIR . "avatar-template.png";
  $email = $creator['email'];
  $title = $creator['first_name'] . " " . $creator['last_name'];
  $status = $creator['status'];

  echo "
  <head>
  <title>Podcastify Membership | $title</title>
  </head>
   <input type=\"hidden\" id=\"creator-id\" value=\"$creator_id\" />
   <input type=\"hidden\" id=\"creator-name\" value=\"$title\" />
   ";

  echo "
      <div class=\"creator-detail-head\">
    ";
  if ($poster) {
    echo
    "<div>
      <img alt=\"poster-image\" id=\"creator-detail-head-image\" class=\"creator-detail-head-image\" src=\"$poster\">
      </div>";
  } else {
    echo
    "
      <div class=\"creator-detail-head-image-empty\"></div>
      ";
  }
  echo "
        <p id=\"creator-detail-head-title\" class=\"creator-detail-head-title\">$title</p>
        <p class=\"creator-email\">$email</p>
        <p class=\"creator-detail-head-status\">Status : $status</p>
      ";

  if ($status == "Not Subscribed") {
    baseButton("Subscribe", "subscribe", "submit");
  }

  echo "
      </div>

      <div class=\"creator-detail-line\">

      </div>
    ";

  echo '
      <script src="' . JS_DIR . 'membership/creator.js"></script>
  ';
};
