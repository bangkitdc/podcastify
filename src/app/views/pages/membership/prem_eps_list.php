<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>membership/creator_detail.css">
</head>

<div id="template">
  <div class="creator-detail-container">
    <?php
    require_once VIEWS_DIR . "components/privates/membership/creator_detail.php";
    creator_detail($data['creator']);
    ?>
  </div>
  <h3 class="episode-list-title">Premium Episodes</h3>
  <div id="episodes-table">
    <?php
    require_once COMPONENTS_PRIVATES_DIR . 'membership/tables.php';

    $episodes = $data['episodes'];
    $currentPage = $data['currentPage'];

    if (count($episodes) > 0) {
      renderEpisodesTable($episodes, $currentPage);
    } else {
      echo '<h3 class="no-episodes">No premium episodes yet from this creator</h3>';
    }
    ?>
  </div>

  <div class="pagination-wrapper">
    <?php
    require_once VIEWS_DIR . "components/shares/paginations/primary.php";

    $currentPage = $data['currentPage'] ?? 1;
    $totalPages = $data['totalPages'];
    $function = [
      "loadEpisodeList(true, false, false, false, $totalPages)",
      "loadEpisodeList(false, true, false, false, $totalPages)",
      "loadEpisodeList(false, false, true, false, $totalPages)",
      "loadEpisodeList(false, false, false, true, $totalPages)"
    ];

    echoPaginationNav("episode", $currentPage, $totalPages, $function);
    ?>
  </div>
</div>

<script src="<?= JS_DIR ?>/membership/pagination.js"></script>