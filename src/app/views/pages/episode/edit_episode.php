<div id="template">
  <div class="edit-episode-container">
    <p class="edit-episode-container-title">Edit Episode</p>

    <form class="edit-episode-form" method="PATCH">
      <div>
        <p>Episode Title</p>
        <input type="text" name="title" placeholder="$title" require>
      </div>

      <div>
        <p>Description</p>
        <input type="text" name="description" placeholder="$description" require>
      </div>

      <div>
        <p>Categories</p>
        <input type="text" name="category" placeholder="Enter episode category" require>
      </div>

      <div class="edit-episode-file">
        <p>Change poster file : </p>
        <input type="file" name="image_file" id="file">
      </div>

      <div class="edit-episode-file">
        <p>Change audio file : </p>
        <input type="file" name="audio_file" id="file" require>
      </div>

      <div class="edit-episode-buttons">
        <button type="button" onclick="window.location.href = '/episode'" class="cancel-edit-episode-button">Cancel</button>
        <?php
        $episode_data = $data['episode'] ? $data['episode'][0] : null;
        $id = $episode_data ? $episode_data->episode_id : '';

        if ($episode_data != null) {
          echo "<input type=\"hidden\" id=\"episode_id\" name=\"episode_id\" value=\"$id\" />";
        };

        echo "<button type=\"submit\" formmethod=\"PATCH\" formaction=\"/episode/edit?episode_id=$id\" class=\"confirm-edit-episode-button\">Edit Episode</button>";
        ?>
        <button class="delete-edit-episode-button">Delete Episode</button>
      </div>

    </form>
  </div>
</div>

<!-- Todo : Patch and Delete on Buttons -->