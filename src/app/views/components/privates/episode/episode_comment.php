<?php 
function episode_comment($comment = null)
{
  echo '
  <div class="episode-comment-card">
  <div class="episode-comment-card-image-container">
    <img
      class="episode-comment-card-image"
      src="' . IMAGES_DIR . "avatar-template.png" . '"
      alt=""
    />
  </div>
  <div class=" episode-comment-card-profile">
    <p>' . $comment['username'] . '</p>
    <span>•</span>
    <p>' . formatDateDetail($comment['created_at']) .'</p>
  </div>
  <div class="episode-comment-fill-div"></div>
  <div class="episode-comment-content">
    <p> ' . $comment['comment_text'] . '</p>
  </div>
</div>
  ';
}

function comment_list($comments = null) 
{
  foreach($comments as $comment) {
    episode_comment($comment);
  }
}
?>