<?php
// Podcast box component
function baseContentBox($podcast = null, $is_skeleton = false) {
    $title = $podcast ? $podcast->title : '';
    $creator_name = $podcast ? $podcast->creator_name : '';
    $content_box_class = $is_skeleton ? 'podcast-content-skeleton' : 'base-content-box';

    echo "
      <div class=\"podcast-content-container\">
        <div class=\"{$content_box_class}\">
          <img src=\"\" alt=\"podcastImage\">
        </div>
        <p class=\"podcast-title\">{$title}</p>
        <br />
        <p class=\"podcast-creator\">{$creator_name}</p>
      </div>
    ";
}

// Podcasts container view
$hide_podcast_box_class = count($podcasts) > 0 ? 'visible' : 'hidden';
$hide_info_class = count($podcasts) > 0 ? 'hidden' : 'visible';
echo "<div id=\"template\" class=\"podcast-container\">";
    echo "<div class=\"podcast-box-area $hide_podcast_box_class\">";
        foreach ($podcasts as $podcast) {
            baseContentBox($podcast);
        }
    echo "</div>";

    // This skeleton default visibility is hidden
    echo "<div class=\"podcast-box-skeleton\">";
        for ($x = 0; $x < 8; $x++) {
            baseContentBox(null, true);
        }
    echo "</div>";

    echo "<h1 class=\"no-podcast-info\" style=\"visibility: $hide_info_class;\">No Podcast Available</h1>";
echo "</div>";
