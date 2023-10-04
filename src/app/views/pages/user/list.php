<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_tables.css">
  <link rel="stylesheet" href="<?= CSS_DIR ?>user/list.css">
</head>

<div id="template">
  <div class="title">
    <h2>Users List</h2>
    <p>Manage Podcastify Users</p>
  </div>

  <div id="user-table">
    <?php
      require_once COMPONENTS_PRIVATES_DIR . 'user/tables.php';

      $users = $data['users'];
      $totalPages = $data['totalPages'];
      $currentPage = $data['currentPage'];
      renderUserTable($data['users'], $data['currentPage']);
    ?>
  </div>

  <?php
    require_once COMPONENTS_SHARES_DIR . 'modals/updateModal.php';

    echoUpdateModalTop("userModalUpdate", "User status");
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

  <div class="pagination-wrapper">
    <?php
    require_once VIEWS_DIR . "components/shares/paginations/primary.php";

    $function = [
      "loadUserList(true, false, false, false, $totalPages, $currentPage)",
      "loadUserList(false, true, false, false, $totalPages, $currentPage)",
      "loadUserList(false, false, true, false, $totalPages, $currentPage)",
      "loadUserList(false, false, false, true, $totalPages, $currentPage)"
    ];

    echoPaginationNav("user", $currentPage, $totalPages, $function);
    ?>
  </div>
</div>

<script src="<?= JS_DIR ?>/user/list.js"></script>
<script src="<?= JS_DIR ?>/components/modal.js"></script>
<script src="<?= JS_DIR ?>/user/pagination.js"></script>