<head>
  <title>Podcastify | Podcasts</title>
  <link rel="stylesheet" href="<?= CSS_DIR ?>podcast/podcast.css">
</head>
<div id="template">
  <div>
    <?php
        require_once VIEWS_DIR . "components/podcast/contentBox.php";
        require_once VIEWS_DIR . "components/podcast/paginationNav.php";

        $MAX_PODCAST_PER_PAGE = 4;
        $podcasts = $data['podcasts'];
        $total_pages = ceil($data['total_rows'] / $MAX_PODCAST_PER_PAGE);
        
        // Podcasts container view
        echo "<div id=\"podcast-container\" class=\"podcast-container\">";
        if (count($podcasts) > 0) {
            echo "<div class=\"podcast-box-area\">";
                foreach ($podcasts as $podcast) {
                    baseContentBox($podcast, false, "showPodcast($podcast->podcast_id)");
                }
            echo "</div>";

            // This skeleton default visibility is hidden
            echo "<div class=\"podcast-box-skeleton\">";
                for ($x = 0; $x < 8; $x++) {
                    baseContentBox(null, true);
                }
            echo "</div>";

            echo "<div class=\"podcast-nav-box\">";
                paginationPodcastNav($podcasts, $total_pages);
            echo "</div>";
        } else {
            echo "<div class=\"podcast-info-wrapper\"><h1 class=\"no-podcast-info\">No Podcast Available</h1></div>";
        }
        echo "</div>";
    ?>
  </div>
</div>
<script src="<?= JS_DIR ?>/podcast/podcast.js"></script>
