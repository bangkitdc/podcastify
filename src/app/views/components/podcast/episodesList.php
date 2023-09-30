<?php

function episodeList($episodes = null, $is_skeleton = false, $click_evt = "") {
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
