<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>episode/crud_episode.css">
</head>
<div id="template">
  <div class="add-episode-container">
    <?php

    require_once VIEWS_DIR . "/components/shares/inputs/text.php";
    require_once VIEWS_DIR . "/components/shares/upload/baseFileUploader.php";
    require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";
    ?>
    <p class="add-episode-container-title">Add Episode</p>

    <form class="add-episode-form" method="POST" action="/episode/add">

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

      <div>
        <p>Categories</p>
        <?php baseInputText("Enter Episode Category", '', "episode-category-input") ?>
      </div>

      <div class="add-episode-file">
        <p>Choose the poster file : </p>
        <?php baseFileUploader("poster-file-upload", '', 'preview-image', false)?>
      </div>

      <div class="add-episode-file">
        <p>Choose the audio file : </p>
        <?php baseFileUploader("audio-file-upload", '', 'preview-image', true)?>
      </div>

      <div class="add-episode-buttons">
        <button type="button" onclick="window.location.href = '/episode'" class="cancel-add-episode-button">Cancel</button>
        <button type="submit" class="confirm-add-episode-button">Add Episode</button>
      </div>

    </form>
  </div>
</div>

<!-- Todo : Get podcasts data -->