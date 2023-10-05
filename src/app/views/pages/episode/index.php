<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>episode/episode_card.css">
</head>
<div id="template">
  <div class="episode-container">
    <div id="episode-list-container" class="episode-list-container">
      <h1>Episodes</h1>
      <?php
      // require_once VIEWS_DIR . "components/privates/episode/episode_card.php";
      require_once VIEWS_DIR . "components/shares/paginations/primary.php";
      require_once VIEWS_DIR . "components/shares/tables/primary.php";

      echoTableHeader(["Title", "Duration", "Upload Date"], [60, 20, 15]);
      $ctr = 1;
      foreach ($data['episodes'] as $episode) {
        $id = $episode ? $episode->episode_id : '';
        $title = $episode ? $episode->title : '';
        $creator = $episode ? $episode->creator_name : '';
        $duration = $episode ? $episode->duration / 60 : '';
        $image = $episode->image_url ? Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->image_url) : '';
        $upload_date = $episode->created_at ? formatDate($episode->created_at) : '';

        echoTableContent(["num", "img", "title", "creator", "duration", "upload_date"], [$ctr, $image, $title, $creator, $duration . " minutes", $upload_date], "window.location.href='/episode/$id'", "episode-list");

        $ctr++;

        // episode_card($episode);
      }
      echoClosingTag();

      echo "</div>";

      $current_page = $data['currentPage'];
      $total_pages = $data['totalPages'];

      echoPaginationNav("episode-pagination", $current_page, $total_pages, [
        "loadEpisodeList(true, false, false, false, $total_pages, $current_page)",
        "loadEpisodeList(false, true, false, false, $total_pages, $current_page)",
        "loadEpisodeList(false, false, true, false, $total_pages, $current_page)",
        "loadEpisodeList(false, false, false, true, $total_pages, $current_page)"
      ]);

      function formatDate($dateString)
      {
        $dateTime = new DateTime($dateString);

        $day = $dateTime->format('d');
        $month = $dateTime->format('F');
        $year = $dateTime->format('Y');

        return $month . ' ' . $day . ', ' . $year;
      }
      ?>
    </div>
  </div>
  <script src="<?= JS_DIR ?>/episode/pagination.js"></script>