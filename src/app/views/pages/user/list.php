<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_tables.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>user/list.css">
</head>

<div id="template">
  <!-- <?php
        $users = $data['users'];
        $totalUsers = $data['totalUsers'];

        $totalPages = ceil($totalUsers / 10);

        foreach ($users as $user) {
          echo '
        <div>
          ' . $user->user_id . '
        </div>
      ';
        }
        ?> -->

  <div class="title">
    <h2>Users List</h2>
    <p>Manage Podcastify user</p>
  </div>

  <?php
    require_once VIEWS_DIR . "/components/shares/tables/primary.php";
    require_once COMPONENTS_SHARES_DIR . 'utility/utility.php';

    $users = $data['users'];
    $totalUsers = $data['totalUsers'];

    $totalPages = ceil($totalUsers / 10);

    $dataHeader = ["Username", "Email", "Last Login", "Status"];
    echoTableHeader($dataHeader);

    $index = 1;

    foreach ($users as $user) {
      $data = [
        $index,
        $user->avatar_url ? STORAGE::getFileUrl(STORAGE::USER_AVATAR_PATH, $user->avatar_url) : IMAGES_DIR . "avatar-template.png",
        $user->username, 
        $user->first_name . " " . $user->last_name,
        $user->email,
        timeAgo($user->last_login),
        $user->status == 1 ? "Active" : "Inactive"
      ];

      echoTableContent($data);

      $index ++;
    }

    echoClosingTag();
  ?>
</div>