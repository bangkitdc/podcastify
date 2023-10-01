<div id="template">
  <div class="episode-list-container">
    <?php 
    require_once VIEW_DIR . "components/episode/episode_card.php";
    
    foreach ($data['episodes'] as $episode) {
      episode_card($episode);
    }
    ?>
  </div>
</div>