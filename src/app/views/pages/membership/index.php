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

    $memberships = $data['memberships'];
    $currentPage = $data['currentPage'] ?? 1;
    $totalPages = $data['totalPages'] ?? 1;

    // Membership container view
    echo "<div id=\"membership-container\" class=\"membership-container\">";
    if (count($memberships) > 0) {
      echo "<div class=\"membership-box-area\">";
      foreach ($memberships as $membership) {
        baseContentBox($membership, false, "showMembership($membership->membership_id)");
      }
      echo "</div>";

      echoPaginationNav("membership", $currentPage, $totalPages, $function);
    } else {
      echo "<div class=\"membership-info-wrapper\"><h1 class=\"no-membership-info\">No Membership Available</h1></div>";
    }
    echo "</div>";
  ?>
</div>