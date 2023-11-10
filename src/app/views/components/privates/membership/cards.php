<?php
// Membership box component

function baseContentBox($membership = null, $click_evt = "")
{
  $creator_name = $membership->creator_name;
  $status = $membership->status;
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
    <p class=\"membership-title\">{$creator_name}</p>
    <div class=\"membership-creator-container\">
        <p class=\"membership-creator\">
          {$status}
        </p>
      </div>
    </div>
    ";
}
