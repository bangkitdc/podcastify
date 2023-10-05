<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'podcast/pagination.css">';

function paginationEpsNav($podcast, $total_pages) {
    echo
    "
    <div class=\"eps-list-nav\">
        <button id=\"eps-list-prev\" onclick=\"loadEpsList($podcast->podcast_id, false, false, true)\">
            <img src=\"". ICONS_DIR . "/skip_previous.svg\" />
        </button>
        <button id=\"eps-list-prev\" onclick=\"loadEpsList($podcast->podcast_id, false)\">
            <img src=\"". ICONS_DIR . "/left-arrow.svg\" />
        </button>
        <span id=\"eps-list-page-num\">1</span> of <span id=\"eps-list-total-pages\">$total_pages</span>
        <button id=\"eps-list-next\" onclick=\"loadEpsList($podcast->podcast_id)\">
            <img src=\"". ICONS_DIR . "/right-arrow.svg\" />
        </button>
        <button id=\"eps-list-prev\" onclick=\"loadEpsList($podcast->podcast_id, false, true)\">
            <img src=\"". ICONS_DIR . "/skip_next.svg\" />
        </button>
    </div>
    ";
}

function paginationPodcastNav($podcasts, $total_pages, $is_search = false) {
    $is_search = $is_search ? 'true' : 'false';
    echo
    "
    <div class=\"pod-list-nav\">
        <button id=\"pod-list-prev\" onclick=\"loadPodcastList($is_search, false, false, true)\">
            <img src=\"". ICONS_DIR . "/skip_previous.svg\" />
        </button>
        <button id=\"pod-list-prev\" onclick=\"loadPodcastList($is_search, false)\">
            <img src=\"". ICONS_DIR . "/left-arrow.svg\" />
        </button>
        <span id=\"pod-list-page-num\">1</span> of <span id=\"pod-list-total-pages\">$total_pages</span>
        <button id=\"pod-list-next\" onclick=\"loadPodcastList($is_search)\">
            <img src=\"". ICONS_DIR . "/right-arrow.svg\" />
        </button>
        <button id=\"pod-list-prev\" onclick=\"loadPodcastList($is_search, false, true)\">
            <img src=\"". ICONS_DIR . "/skip_next.svg\" />
        </button>
    </div>
    ";
}
