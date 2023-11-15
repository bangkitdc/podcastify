<?php 
function episode_comment($comment = null)
{
  echo '
  <div class="episode-comment-card">
  <div class="episode-row-1">
    <div class="episode-comment-card-image-container">
      <img
        class="episode-comment-card-image"
        src="' . IMAGES_DIR . "avatar-template.png" . '"
        alt=""
      />
    </div>
    <div class=" episode-comment-card-profile">
      <p class="episode-username">' . $comment['username'] . '</p>
      <span>•</span>
      <p class="episode-date">' . formatDateDetail($comment['created_at']) . '</p>
    </div>
  </div>
  <div class="episode-row-2">
    <div class="episode-comment-fill-div"></div>
    <div class="episode-comment-content">
      <p class="episode-text"> ' . $comment['comment_text'] . '</p>
    </div>
  </div>
</div>
  ';
}

function comment_list($comments = null) 
{
echo '<div class="comment-list-container">';
  foreach($comments as $comment) {
    episode_comment($comment);
  }
}
echo '</div';
?>