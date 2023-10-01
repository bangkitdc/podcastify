<div id="template">
  <div class="add-episode-container">
    <p class="add-episode-container-title">Add Episode</p>

    <form class="add-episode-form" method="POST" action="/episode/add">

      <div>
        <p>Select Podcast: </p>
        <select class="add-episode-form-select" id="dropdown" name="podcast_id">
          <?php
          $ctr = 0;
          $podcasts = [
            1 => 'Podcast A',
            2 => 'Podcast B',
            3 => 'Podcast C',
          ];
          foreach ($podcasts as $id => $name) {
            echo "<option value=\"$id\">$name</option>";
          }
          ?>
        </select>
      </div>

      <div>
        <p>Episode Title</p>
        <input type="text" name="title" placeholder="Enter episode title..." require>
      </div>

      <div>
        <p>Description</p>
        <input type="text" name="description" placeholder="Enter episode description..." require>
      </div>  

      <div>
        <p>Categories</p>
        <input type="text" name="category" placeholder="Enter episode category" require>
      </div>

      <div class="add-episode-file">
        <p>Choose the poster file : </p>
        <input type="file" name="image_file" id="file">
      </div>

      <div class="add-episode-file">
        <p>Choose the audio file : </p>
        <input type="file" name="audio_file" id="file" require>
      </div>

      <div class="add-episode-buttons">
        <button type="button" onclick="window.location.href = '/episode'" class="cancel-add-episode-button">Cancel</button>
        <button type="submit" class="confirm-add-episode-button">Add Episode</button>
      </div>

    </form>
  </div>
</div>

<!-- Todo : Get podcasts data -->