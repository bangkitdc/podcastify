<?php

function renderUserTable($users, $currentPage)
{
  require_once VIEWS_DIR . "/components/shares/tables/primary.php";
  require_once COMPONENTS_SHARES_DIR . 'utility/utility.php';

  $dataHeader = ["Username", "Email", "Last Login", "Status"];
  echoTableHeader($dataHeader, [35, 30, 20, 10]);

  $index = 1 + (($currentPage - 1) * 10);

  foreach ($users as $user) {
    $dataContext = [
      "number",
      "user_avatar",
      "username",
      "fulllname",
      "email",
      "last_login",
      "status"
    ];

    $data = [
      $index,
      $user->avatar_url ? STORAGE::getFileUrl(STORAGE::USER_AVATAR_PATH, $user->avatar_url) : IMAGES_DIR . "avatar-template.png",
      $user->username,
      $user->first_name . " " . $user->last_name,
      $user->email,
      timeAgo($user->last_login), // utility function
      $user->status == 1 ? "Active" : "Inactive"
    ];

    echoTableContent($dataContext, $data, "showModalEditStatusUser(" . $user->user_id . ", 'userModalUpdate')", "_user_" . $user->user_id);

    $index++;
  }

  echoClosingTag();
}