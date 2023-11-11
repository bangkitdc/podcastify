<?php
// Membership box component

function baseCardsBox($membership = null, $click_evt = "")
{
  $creator_name = $membership['first_name'] . ' ' . $membership['last_name'];
  $status = $membership['status'];
  $img_url = IMAGES_DIR . "podcast-template.png";

  echo
  "
    <div class=\"membership-content-container\" onclick=\"$click_evt\">
      <div class=\"membership-img-placeholder\">
        <img src=\"$img_url\" alt=\"membershipImage\" class=\"membership-img\">
      </div>
    ";
  echo
  "
    <p class=\"membership-creator\">{$creator_name}</p>
    <div class=\"membership-creator-container\">
        <p class=\"membership-status\">
          {$status}
        </p>
      </div>
    </div>
    ";
}

function renderCreatorCardList($creators) {
  foreach ($creators as $creator) {
    $userId = $creator['user_id'];
    baseCardsBox($creator, "showCreator($userId)");
  }
}