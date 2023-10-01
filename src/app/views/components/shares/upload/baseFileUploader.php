<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_file_uploader.css">
</head>
<?php

function baseFileUploader($input_id = "", $input_class = "", $img_id = "", $img_class = "") {
    echo
    "
    <div class=\"file-uploader-container\">
        <input type=\"file\" id=\"$input_id\" class=\"file-uploader $input_class\" />
        <img id=\"$img_id\" src=\"#\" alt=\"User img\" class=\"image-preview $img_class\" />
    </div>
    ";
}
