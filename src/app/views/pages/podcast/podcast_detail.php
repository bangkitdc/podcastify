<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>/podcast/podcast_detail.css">
</head>
<div id="template">
  <div>
    <?php
        require_once VIEW_DIR . "components/podcast/contentBox.php";
        require_once VIEW_DIR . "components/podcast/episodesList.php";
        require_once VIEW_DIR . "components/podcast/paginationNav.php";

        $MAX_EPS_PER_PAGE = 2;

        $podcast = $data['podcast'];
        $episodes = $data['episodes'];
        $total_pages = $podcast->total_eps == 0 ? 1 : ceil($podcast->total_eps / $MAX_EPS_PER_PAGE);

        // Podcasts view
        echo "<section class=\"podcast-detail-container\">";
            echo
            "
                <div class=\"podcast-detail\">
                    <img src=\"$podcast->image_url\" alt=\"podcastImage\" class=\"podcast-detail-img\">
                    <h1>$podcast->creator_name</h1>
                    <h2>$podcast->total_eps episodes</h2>
                    <h2>$podcast->description</h2>
                </div>
            ";

            echo
            "   <h3 class=\"episode-list-title\">Episodes</h3>
                <div class=\"podcast-detail-eps-container\" id=\"podcast-eps-list-container\">
            ";
                if (count($episodes) > 0) {
                    episodeList($episodes);
                }
                else {
                    echo "<h2>No episodes in this podcast</h2>";
                }
            echo "</div>";

            paginationEpsNav($podcast, $total_pages);

        echo "</section>";
    ?>
  </div>
</div>
