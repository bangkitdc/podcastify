<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>episode/crud_episode.css">
</head>
<div id="template">
  <div class="add-episode-container">
    <?php

    require_once VIEWS_DIR . "/components/shares/inputs/text.php";
    require_once VIEWS_DIR . "/components/shares/upload/baseFileUploader.php";
    require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";
    require_once VIEWS_DIR . "/components/shares/modals/baseModal.php";

    actionModal("add-episode-confirm-modal", "Are you sure to create this episode ?", "add-episode-modal-ok", "add-episode-modal-cancel");
    infoModal("add-episode-audio-modal", "Please Upload Your Audio File!", "add-episode-audio-modal-ok")
    ?>
    <p class="add-episode-container-title">Add Episode</p>

    <form id="add-episode-form" class="add-episode-form">

      <div>
        <p>Select Podcast: </p>
        <select class="add-episode-form-select" id="dropdown" name="podcast_id">
          <?php
          foreach ($data['podcasts'] as $name => $id) {
            echo "<option value=\"$id\">$name</option>";
          }
          ?>
        </select>
      </div>

      <div>
        <p>Episode Title</p>
        <?php baseInputText("Enter Episode Title", '', "episode-title-input") ?>
      </div>

      <div>
        <p>Description</p>
        <?php baseInputText("Enter Episode Description", '', "episode-description-input") ?>
      </div>

      <div class="add-episode-file">
        <p>Choose the poster file : </p>
        <?php baseImageUploader("poster-file-upload", '', 'preview-poster', false)?>
        <input type="hidden" id="preview-poster-filename" name="preview-poster-filename">
      </div>

      <div class="add-episode-file">
        <p>Choose the audio file : </p>
        <?php baseAudioUploader("audio-file-upload", '', false)?>
        <input type="hidden" id="audio-filename" name="audio-filename">
      </div>

      <div class="add-episode-buttons">
        <button type="button" onclick="window.location.href = '/episode'" class="cancel-add-episode-button">Cancel</button>
        <button type="submit" class="confirm-add-episode-button">Add Episode</button>
      </div>

    </form>
  </div>
</div>
<?php echoJsFile(); echoModalJS()?>
<script src="<?= JS_DIR ?>/episode/handle_upload.js"></script>
