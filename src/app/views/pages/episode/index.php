<div id="template">
  <div class="episode-container">
    <!-- <img alt="Logo"> -->
      <?php 
        if (isset($_GET['episode_id'])) {
          $episodeId = $_GET['episode_id'];
        } else {
            $episodeId = null;
        }
        
        if ($episodeId !== null) {

          require_once VIEW_DIR . "components/episode/episode_detail.php";

          echo "<div class=\"episode-detail-container\">";
            if(is_array($data['episode'])) {
              episode_detail($data['episode'][0]);
            }
          echo "</div>";

        } else {

          require_once VIEW_DIR . "components/episode/episode_card.php";
          
          echo "<div class=\"episode-list-container\">";
            foreach($data['episodes'] as $episode) {
              episode_card($episode);
            }
          echo "</div>";

        }
        
    ?>
  </div>
  <br>
  <p>Go back to the <a href="/">home page</a></p>
</div>