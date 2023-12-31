<head>
    <title>Podcastify | Manage</title>
    <meta name="description" content="Manage your podcast.">
    <link rel="stylesheet" href="<?= CSS_DIR ?>podcast/podcast_management.css">
</head>
<div id="template">
  <div>
    <?php
        require_once VIEWS_DIR . "/components/shares/inputs/text.php";
        require_once VIEWS_DIR . "/components/shares/inputs/select.php";
        require_once VIEWS_DIR . "/components/shares/upload/baseFileUploader.php";
        require_once VIEWS_DIR . "/components/shares/buttons/baseButton.php";
        require_once VIEWS_DIR . "/components/shares/modals/baseModal.php";

        $type = isset($data['type']) ? $data['type'] : '';
        $podcast = $type == 'edit' ? $data['podcast'] : null;
        $category_opt = $data['categories'];
        $podcast_category = isset($data['podcast_category']) ? $data['podcast_category'] : $category_opt[0];

        $podcast_name = $type == 'edit' ? ucwords($podcast->title) : '';
        $podcast_creator = $type == 'edit' ? $podcast->creator_name : '';
        $podcast_desc = $type == 'edit' ? $podcast->description : '';

        // For alter editing & create UI
        $management_heading = $type == 'edit' ? 'Edit Podcast' : 'Add Podcast';
        $edit_extra_text = $type == 'edit' ? 'Change ' : '';
        $form_id = $type == 'edit' ? 'update-form' : 'create-podcast';

        if ($type != 'edit') {
            infoModal("manage-modal-file", "Please Upload Poster Image!", "manage-modal-ok");
        }
        actionModal("manage-modal-create", "Are you sure to create this podcast ?", "create-modal-ok", "create-modal-cancel");
        actionModal("manage-modal-save", "Are you sure to save changes ?", "save-modal-ok", "save-modal-cancel");
        actionModal("manage-modal-delete", "Are you sure to delete this podcast ?", "delete-modal-ok", "delete-modal-cancel");

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
            <p>$edit_extra_text Category</p>
        ";
        baseSelect($category_opt, $podcast_category, 'podcast-category-selection');
        echo "
            <p>Upload New Poster</p>
        ";

        baseImageUploader("file-upload", "", "preview-image", false);

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

        echoJsFile();
        echoModalJS();
        echoSelectJS();
    ?>
  </div>
</div>
<script src="<?= JS_DIR ?>podcast/handle_upload.js"></script>
