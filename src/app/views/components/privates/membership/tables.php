<?php

function renderEpisodesTable($episodes, $status, $currentPage)
{
  require_once VIEWS_DIR . "/components/shares/tables/primary.php";
  require_once COMPONENTS_SHARES_DIR . 'utility/utility.php';

  $dataHeader = ["Title", "Genre", "Duration"];
  echoTableHeader($dataHeader, [60, 20, 15]);

  $index = 1 + (($currentPage - 1) * 10);
  $status = "'" . $status . "'";

  foreach ($episodes as $episode) {
    $dataContext = [
      "number",
      "avatar",
      "title",
      "fulllname",
      "genre",
      "duration"
    ];

    $data = [
      $index,
      $episode['imageFile'] ? $episode['imageFile'] : IMAGES_DIR . "avatar-template.png",
      $episode['title'],
      $episode['user']['first_name'] . " " . $episode['user']['last_name'],
      $episode['category']['name'],
      secondsToMinutesSeconds($episode['duration'])
    ];

    $episode_id = $episode['episode_id'];

    echoTableContent($dataContext, $data,  "handleEpisode($status, $episode_id)", "premium-episode-$episode_id");

    $index++;
  }

  echoClosingTag();
}
