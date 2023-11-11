<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>membership/membership.css">
  <title>Podcastify | Membership</title>
</head>

<div id="template">
  <div class="title">
    <h2>Creators Membership</h2>
    <p>Get more from creators that you love</p>
  </div>

  <?php
  require_once VIEWS_DIR . "components/shares/paginations/primary.php";
  require_once VIEWS_DIR . "components/privates/membership/cards.php";

  $creators = $data['creators'];
  $currentPage = $data['currentPage'] ?? 1;
  $totalPages = $data['totalPages'] ?? 1;

  // Membership container view
  echo "<div id=\"membership-container\" class=\"membership-container\">";
  if (count($creators) > 0) {
    echo "<div id=\"creator-cards\" class=\"membership-box-area\">";
    renderCreatorCardList($creators);
    echo "</div>";

    $function = [
      "loadCreatorList(true, false, false, false, $totalPages)",
      "loadCreatorList(false, true, false, false, $totalPages)",
      "loadCreatorList(false, false, true, false, $totalPages)",
      "loadCreatorList(false, false, false, true, $totalPages)"
    ];

    echoPaginationNav("creator", $currentPage, $totalPages, $function);
  } else {
    echo "<div class=\"membership-info-wrapper\"><h1 class=\"no-membership-info\">No Membership Available</h1></div>";
  }
  echo "</div>";
  ?>
</div>

<script src="<?= JS_DIR ?>/membership/pagination.js"></script>
<script src="<?= JS_DIR ?>/membership/creator.js"></script>