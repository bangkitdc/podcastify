<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>episode/episode_detail.css">
</head>
<div id="template">
  <div class="episode-detail-container">
  <?php 
    require_once VIEWS_DIR . "components/episode/episode_detail.php";
    if (is_array($data['episode'])) {
      episode_detail($data['episode'][0]);
    } 
  ?>
  </div>
</div>