<?php
// Podcast box component
require_once BASE_URL . '/src/config/storage.php';

function baseContentBox($podcast = null, $is_skeleton = false, $click_evt = "") {
    $title = !$is_skeleton ? ucwords($podcast->title) : '';
    $creator_name = !$is_skeleton ? $podcast->creator_name : '';
    if (!$is_skeleton && $podcast->image_url) {
        $img_url = Storage::getFileUrl(Storage::PODCAST_IMAGE_PATH, $podcast->image_url);
    } else {
        $img_url = IMAGES_DIR . "podcast-template.png";
    }

    echo
    "
        <div class=\"podcast-content-container\" onclick=\"$click_evt\">
    ";
    if (!$is_skeleton) {
        echo "
            <div class=\"podcast-img-placeholder\">
                <img src=\"$img_url\" alt=\"podcastImage\" class=\"podcast-img\">
            </div>
            ";
    } else {
        echo "
            <div class=\"podcast-skeleton-placeholder\">
                <div class=\"podcast-content-skeleton\"></div>
            </div>
            ";
    }
    echo
    "
            <p class=\"podcast-title\">{$title}</p>
            <div class=\"podcast-creator-container\">
                <p class=\"podcast-creator\">
                    {$creator_name}
                </p>
    ";
                if (Middleware::isAdmin() && !$is_skeleton) {
                    echo
                    "
                    <span class=\"podcast-edit-box\" onclick=\"editPodcast($podcast->podcast_id, event)\">
                        <button class=\"podcast-edit-icon\" name=\"edit-icon\" ><img src=\"". ICONS_DIR . "/edit.svg\" alt=\"edit-icon\" /></button>
                        <span class=\"podcast-edit-tooltip\">Edit Podcast</span>
                    </span>
                    ";
                }
    echo "  </div>
        </div>
    ";
}
