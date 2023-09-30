<div id="template">
  <div>
    <?php
        require_once VIEW_DIR . "components/podcast/contentBox.php";
        // TODO: insert img url

        $podcast = $data['podcast'];
        // $episodes = $data['$episodes'];

        // Podcasts view
        echo "<section class=\"podcast-detail-container\">";
            echo
            "
                    <div class=\"podcast-detail\">
                        <img src=\"\" alt=\"podcastImage\" class=\"podcast-detail-img\">
                        <h1>$podcast->creator_name</h1>
                        <h2>$podcast->total_eps episodes</h2>
                        <h2>$podcast->description</h2>
                    </div>
            ";

            echo
            "<h3 class=\"episode-list-title\">Episodes</h3>
                <div class=\"podcast-detail-eps-container\">
            ";
                if (count($episodes) > 0) {
                    echo "<h2>No episodes in this podcast</h2>";
                }
                else {
                    foreach ($episodes as $episode) {
                        echo
                        "
                            <div class=\"eps-row-content\">
                                <img src=\"\" alt=\"episodeImage\" class=\"eps-img\">
                                <div class=\"eps-data\">
                                    <p class=\"eps-title\">$episode->title</p>
                                    <p class=\"eps-desc\">$episode->description</p>
                                </div>
                            </div>
                        ";
                    }
                }
        echo "</div></section>"
    ?>
  </div>
</div>
