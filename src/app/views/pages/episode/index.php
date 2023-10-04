<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>episode/episode_card.css">
</head>
<div id="template">
  <div class="episode-container">
    <div id="episode-list-container" class="episode-list-container">
      <?php
      require_once VIEWS_DIR . "components/episode/episode_card.php";
      require_once VIEWS_DIR . "components/episode/episode_pagination.php";

      foreach ($data['episodes'] as $episode) {
        episode_card($episode);
      }

      echo"</div>";

      episodePagination($data['currentPage'], $data['totalPages']);
      ?>
  </div>
</div>
<script src="<?= JS_DIR ?>/episode/pagination.js"></script>