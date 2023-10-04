<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'episode/episode_pagination.css">';

function episodePagination($current_page, $total_pages) {
    echo
    "
    <div class=\"episode-list-nav\">
        <button id=\"episode-list-prev\" onclick=\"loadEpisodeList(true, false, false, false, $total_pages, $current_page)\">
            <img src=\"". ICONS_DIR . "/skip_previous.svg\" />
        </button>
        <button id=\"episode-list-prev\" onclick=\"loadEpisodeList(false, true, false, false, $total_pages, $current_page)\">
            <img src=\"". ICONS_DIR . "/left-arrow.svg\" />
        </button>
        <span id=\"episode-list-page-next\">$current_page</span> of <span id=\"episode-list-total-pages\">$total_pages</span>
        <button id=\"episode-list-next\" onclick=\"loadEpisodeList(false, false, true, false, $total_pages, $current_page)\">
            <img src=\"". ICONS_DIR . "/right-arrow.svg\" />
        </button>
        <button id=\"episode-list-next\" onclick=\"loadEpisodeList(false, false, false, true, $total_pages, $current_page)\">
            <img src=\"". ICONS_DIR . "/skip_next.svg\" />
        </button>
    </div>
    ";
}
