<head>
  <title>Podcastify | Podcasts</title>
  <link rel="stylesheet" href="<?= CSS_DIR ?>podcast/podcast.css">
</head>
<div id="template">
    <?php
        require_once VIEWS_DIR . "components/privates/podcast/contentBox.php";
        require_once VIEWS_DIR . "components/privates/podcast/paginationNav.php";
        require_once VIEWS_DIR . "/components/shares/inputs/select.php";

        $MAX_PODCAST_PER_PAGE = 4;
        $podcasts = $data['podcasts'];
        $total_pages = ceil($data['total_rows'] / $MAX_PODCAST_PER_PAGE);

        $is_ajax = isset($data["is_ajax"]) ? $data["is_ajax"] : false;

        if (!$is_ajax) {
            $category_opt = $data['categories'];
            $creator_opt = $data['creators'];
            $sort_opt = ["None", "Oldest", "Recent"];

            $podcast_category = "All";
            $podcast_creator = "All";
            $sort_by = $sort_opt[0];

            echo
            '
            <div class="search-bar-container">
                <div class="search-bar">
                    <img src="'. ICONS_DIR . 'search-inactive.svg" alt="search_icon" />
                    <input type="text" class="search-bar-input" id="search-bar" placeholder="Search for podcast..." autocomplete="off" />
                    <button class="clear-search-bar" onclick="clearSearchBar()">
                        <img src="'. ICONS_DIR . 'clear_white.svg" alt="clear_icon" />
                    </button>
                </div>
            ';
                echo '
                    <div class="search-filter-btn">
                        <img src="'. ICONS_DIR . 'tune_white.svg" alt="filter_icon" />
                    </div>
                     ';
            echo '</div>';
            echo '<div class="search-function-box">';
                echo '<div>';
                    baseCheckbox($category_opt, $podcast_category, 'podcast-search-category-selection', "Filter Category");
                echo '</div>';
                echo '<div>';
                    baseCheckbox($creator_opt, $podcast_creator, 'podcast-search-creator-selection', "Filter Creator");
                echo '</div>';
                echo '<div><p>Sort By</p>';
                    baseSelect($sort_opt, $sort_by, 'podcast-search-sort-selection');
                echo '</div>';
            echo '</div>';
            echoSelectJS();
        }

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
                paginationPodcastNav($podcasts, $total_pages, $is_ajax);
            echo "</div>";
        } else {
            echo "<div class=\"podcast-info-wrapper\"><h1 class=\"no-podcast-info\">No Podcast Available</h1></div>";
        }
        echo "</div>";
    ?>
</div>
<script src="<?= JS_DIR ?>lib/debounce.js"></script>
<script src="<?= JS_DIR ?>podcast/search_podcast.js"></script>
<script src="<?= JS_DIR ?>podcast/podcast.js"></script>
