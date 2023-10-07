<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>episode/crud_episode.css">
</head>
<div id="template">
  <div class="edit-episode-container">
    <?php

    require_once VIEWS_DIR . "/components/shares/inputs/text.php";
    require_once VIEWS_DIR . "/components/shares/upload/baseFileUploader.php";
    require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";
    require_once VIEWS_DIR . "/components/shares/modals/baseModal.php";

    actionModal("edit-episode-confirm-modal", "Save changes for this episode ?", "edit-episode-modal-ok", "edit-episode-modal-cancel");
    actionModal("delete-episode-confirm-modal", "Are you sure to DELETE this episode ?", "delete-episode-modal-ok", "delete-episode-modal-cancel");

    $episode_data = $data['episode'] ? $data['episode'][0] : null;

    $id = $episode_data ? $episode_data->episode_id : '';
    $title = $episode_data ? $episode_data->title : '';
    $description = $episode_data ? $episode_data->description : '';

    if ($episode_data != null) {
      echo "<p class=\"edit-episode-container-title\">Edit Episode '$title'</p>";
    }
    ?>

    <form id="edit-episode-form" class="edit-episode-form">
      <div>
        <p>Episode Title</p>
        <?php baseInputText("Edit Episode Title", $title, "episode-title-input") ?>
      </div>

      <div>
        <p>Description</p>
        <?php baseInputText("Edit Description", $description, "episode-description-input") ?>
      </div>

      <div class="edit-episode-file">
        <p>Change poster file : </p>
        <?php baseImageUploader("edit-poster-file-upload", '', 'edit-preview-poster', false) ?>
        <input type="hidden" id="edit-preview-poster-filename" name="edit-preview-poster-filename">
      </div>

      <div class="edit-episode-file">
        <p>Change audio file : </p>
        <?php baseAudioUploader("edit-audio-file-upload", '', false) ?>
        <input type="hidden" id="edit-audio-filename" name="edit-audio-filename">
      </div>


      <?php
      if ($episode_data != null) {
        echo "<input type=\"hidden\" id=\"episode_id\" name=\"episode_id\" value=\"$id\" />";
      }
      ?>

      <div class="edit-episode-buttons">
        <?php baseButton('Cancel', 'cancel-change') ?>
        <?php baseButton("Save Changes", "save-change-episode", "submit"); ?>
        <?php baseButton("Delete Podcast", "delete-episode", "negative"); ?>
      </div>

    </form>
  </div>
</div>
<?php echoJsFile();
echoModalJS(); ?>
<!-- <script src="<?= JS_DIR ?>episode/handle_upload_edit.js"></script> -->