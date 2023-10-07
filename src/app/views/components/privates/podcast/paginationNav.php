<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'podcast/pagination.css">';

function paginationEpsNav($podcast, $total_pages) {
    echo
    "
    <div class=\"eps-list-nav\">
        <button id=\"eps-list-start\" onclick=\"loadEpsList($podcast->podcast_id, false, false, true)\" name=\"eps-list-nav\">
            <img src=\"". ICONS_DIR . "/skip_previous.svg\" alt=\"skip_previous\" />
        </button>
        <button id=\"eps-list-prev\" onclick=\"loadEpsList($podcast->podcast_id, false)\" name=\"eps-list-nav\">
            <img src=\"". ICONS_DIR . "/left-arrow.svg\" alt=\"left-arrow\" />
        </button>
        <span id=\"eps-list-page-num\">1</span> of <span id=\"eps-list-total-pages\">$total_pages</span>
        <button id=\"eps-list-next\" onclick=\"loadEpsList($podcast->podcast_id)\" name=\"eps-list-nav\">
            <img src=\"". ICONS_DIR . "/right-arrow.svg\" alt=\"right-arrow\" />
        </button>
        <button id=\"eps-list-end\" onclick=\"loadEpsList($podcast->podcast_id, false, true)\" name=\"eps-list-nav\">
            <img src=\"". ICONS_DIR . "/skip_next.svg\" alt=\"skip_next\" />
        </button>
    </div>
    ";
}

function paginationPodcastNav($podcasts, $total_pages, $is_search = false) {
    $is_search = $is_search ? 'true' : 'false';
    echo
    "
    <div class=\"pod-list-nav\">
        <button id=\"pod-list-start\" onclick=\"loadPodcastList($is_search, false, false, true)\" name=\"pod-list-start\">
            <img src=\"". ICONS_DIR . "/skip_previous.svg\" alt=\"skip_previous\" />
        </button>
        <button id=\"pod-list-prev\" onclick=\"loadPodcastList($is_search, false)\" name=\"pod-list-prev\">
            <img src=\"". ICONS_DIR . "/left-arrow.svg\" alt=\"left-arrow\" />
        </button>
        <span id=\"pod-list-page-num\">1</span> of <span id=\"pod-list-total-pages\">$total_pages</span>
        <button id=\"pod-list-next\" onclick=\"loadPodcastList($is_search)\" name=\"pod-list-next\">
            <img src=\"". ICONS_DIR . "/right-arrow.svg\" alt=\"right-arrow\" />
        </button>
        <button id=\"pod-list-end\" onclick=\"loadPodcastList($is_search, false, true)\" name=\"pod-list-end\">
            <img src=\"". ICONS_DIR . "/skip_next.svg\" alt=\"skip_next\" />
        </button>
    </div>
    ";
}
