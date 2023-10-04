<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>podcast/podcast_detail.css">
</head>
<div id="template">
  <div>
    <?php
        require_once BASE_URL . '/src/config/storage.php';
        require_once VIEWS_DIR . "components/privates/podcast/contentBox.php";
        require_once VIEWS_DIR . "components/privates/podcast/episodesList.php";
        require_once VIEWS_DIR . "components/privates/podcast/paginationNav.php";

        $MAX_EPS_PER_PAGE = 2;

        $podcast = $data['podcast'];
        $episodes = $data['episodes'];
        $category = $data['category'];
        $total_pages = $podcast->total_eps == 0 ? 1 : ceil($podcast->total_eps / $MAX_EPS_PER_PAGE);
        $image_url = Storage::getFileUrl(Storage::PODCAST_IMAGE_PATH, $podcast->image_url);
        // Podcasts view
        echo "<section class=\"podcast-detail-container\">";
            echo
            "
                <div class=\"podcast-detail\">
                    <img src=\"$image_url\" alt=\"podcastImage\" class=\"podcast-detail-img\">
                    <h1>$podcast->creator_name</h1>
                    <h2>$category</h2>
                    <h3>$podcast->total_eps episodes</h3>
                    <h3>$podcast->description</h3>
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
        echoEpsListJS();
    ?>
  </div>
</div>
<script src="<?= JS_DIR ?>/podcast/pagination.js"></script>
