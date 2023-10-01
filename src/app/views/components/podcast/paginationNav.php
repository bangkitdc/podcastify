<?php

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
