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
    <p>Manage Podcastify Users</p>
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

  require_once COMPONENTS_SHARES_DIR . 'modals/updateModal.php';

  echoUpdateModalTop("userModalUpdate")
  ?>

  <form method="" class="modal-body" id="userModalUpdate-form">
    <img class="modal-image" src="" alt="Profile Image">
    <div class="modal-form">
      <input type="hidden" name="user_id" id="userModalUpdate-user_id" value="">
      <select class="option-bar" name="status" id="userModalUpdate-status">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
      </select>
      <div class="btn-wrapper">
        <button type="submit" class="btn secondary btn-save">Save</button>
      </div>
    </div>
  </form>

  <?php
    $description = "By proceeding, you agree to change Podcastify users's status. Please make sure you have the rights.";
    echoUpdateModalBottom($description);
  ?>

</div>

<script src="<?= JS_DIR ?>/components/modal.js"></script>
<script src="<?= JS_DIR ?>/user/list.js"></script>