<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>podcast/podcast_management.css">
</head>
<div id="template">
  <div>
    <?php
        require_once VIEWS_DIR . "/components/shares/inputs/text.php";
        require_once VIEWS_DIR . "/components/shares/upload/baseFileUploader.php";
        require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";

        $type = isset($data['type']) ? $data['type'] : '';
        $podcast = $type == 'edit' ? $data['podcast'] : null;

        $podcast_name = $type == 'edit' ? $podcast->title : '';
        $podcast_creator = $type == 'edit' ? $podcast->creator_name : '';
        $podcast_desc = $type == 'edit' ? $podcast->description : '';

        // For alter editing & create UI
        $management_heading = $type == 'edit' ? 'Edit Podcast' : 'Add Podcast';
        $edit_extra_text = $type == 'edit' ? 'Change ' : '';
        $form_id = $type == 'edit' ? 'update-form' : 'create-podcast';

        echo
        "
        <form id=\"$form_id\">
        <div class=\"podcast-management-container\">
            <h1>$management_heading</h1>
            <p>$edit_extra_text Podcast Name</p>
        ";
        baseInputText("Enter a podcast name", $podcast_name, "podcast-name-input");
        echo "
            <p>$edit_extra_text Creator Name</p>
        ";
        baseInputText("Enter a creator name", $podcast_creator, "podcast-creator-input");
        echo "
            <p>$edit_extra_text Description</p>
        ";
        baseInputText("Enter a description", $podcast_desc, "podcast-desc-input");
        echo "
            <p>Upload New Poster</p>
        ";
        if ($type == "edit") {
            baseFileUploader("file-upload", "", "preview-image", false);
        } else {
            baseFileUploader("file-upload", "", "preview-image", false);
        }
        echo "<input type=\"hidden\" id=\"preview-image-filename\" name=\"preview-image-filename\">";
        if ($podcast != null) {
            echo "<input type=\"hidden\" id=\"podcast-id\" name=\"podcast-id\" value=\"$podcast->podcast_id\" />";
        }
        echo "<div class=\"podcast-management-action\">";
            baseButton("Cancel", "cancel-change");
            baseButton("Save Changes", "save-change", "submit");
            if ($type == "edit") {
                baseButton("Delete Podcast", "delete-podcast", "negative");
            }
        echo "</div>";
        echo "</div></form>";
    ?>
  </div>
</div>
