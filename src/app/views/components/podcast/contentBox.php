<?php
// Podcast box component
function baseContentBox($podcast = null, $is_skeleton = false, $click_evt = "") {
    $title = $podcast ? $podcast->title : '';
    $creator_name = $podcast ? $podcast->creator_name : '';
    $content_box_class = $is_skeleton ? 'podcast-content-skeleton' : 'base-content-box';
    $img_url = $podcast ? $podcast->image_url : '';

    echo
    "
        <div class=\"podcast-content-container\" onclick=\"$click_evt\">

    ";
    if (!$is_skeleton) {
        echo"<img src=\"$img_url\" alt=\"podcastImage\" class=\"podcast-img\">";
    } else {
        echo"<div class=\"{$content_box_class}\"></div>";
    }
    echo
    "
            <p class=\"podcast-title\">{$title}</p>
            <br />
            <p class=\"podcast-creator\">{$creator_name}</p>
        </div>
    ";
}
