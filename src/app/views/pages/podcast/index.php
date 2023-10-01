<head>
  <title>Podcastify | Podcasts</title>
  <link rel="stylesheet" href="<?= CSS_DIR ?>podcast/podcast.css">
</head>
<div id="template">
  <div>
    <?php
        require_once VIEWS_DIR . "components/podcast/contentBox.php";

        $podcasts = $data['podcasts'];

        // Podcasts container view
        $hide_podcast_box_class = count($podcasts) > 0 ? 'visible' : 'hidden';
        $hide_info_class = count($podcasts) > 0 ? 'hidden' : 'visible';
        echo "<div id=\"template\" class=\"podcast-container\">";
            echo "<div class=\"podcast-box-area $hide_podcast_box_class\">";
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

            echo "<h1 class=\"no-podcast-info\" style=\"visibility: $hide_info_class;\">No Podcast Available</h1>";
        echo "</div>";
    ?>
  </div>
</div>
<script src="<?= JS_DIR ?>/podcast/podcast.js"></script>
