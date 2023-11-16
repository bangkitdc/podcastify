<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>episode/episode_detail.css">
    <link rel="stylesheet" href="<?= CSS_DIR ?>episode/episode_comment.css">
</head>
<div id="template">
  <div class="episode-detail-container">
  <?php 
    require_once VIEWS_DIR . "components/privates/episode/episode_detail.php";
    require_once VIEWS_DIR . "components/privates/episode/episode_comment.php";
    // && is_array($data['comment']) && is_array($data['like'])
    if (is_array($data['episode'])) {
      episode_detail($data['episode'], true);
      comment_list($data['episode']['episodeComments']);
    } 
  ?>
  </div>
</div>