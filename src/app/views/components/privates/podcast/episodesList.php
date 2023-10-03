<?php

require_once BASE_URL . '/src/config/storage.php';

function episodeList($episodes = null, $is_skeleton = false, $click_evt = "") {
    foreach ($episodes as $episode) {
        $image_url = Storage::getFileUrl(Storage::PODCAST_IMAGE_PATH, $episode->image_url);
        echo
        "
            <div class=\"eps-row-content\">
                <img src=\"$image_url\" alt=\"episodeImage\" class=\"eps-img\">
                <div class=\"eps-data\">
                    <p class=\"eps-title\">$episode->title</p>
                    <p class=\"eps-desc\">$episode->description</p>
                </div>
            </div>
        ";
    }
}
