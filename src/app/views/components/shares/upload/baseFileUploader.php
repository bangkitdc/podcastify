<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_file_uploader.css">
</head>
<?php

function baseImageUploader($input_id = "", $input_class = "", $img_id = "", $is_required = true, $img_class = "") {
    $required_status = $is_required ? 'required' : '';
    $allowed_img = implode(',', array_keys(ALLOWED_IMAGES));
    echo
    "
    <div class=\"file-uploader-container\">
        <input type=\"file\" id=\"$input_id\" class=\"file-uploader $input_class\" $required_status name=\"$input_id\" accept=\"$allowed_img\" aria-label=\"image-upload\" />
        <label for=\"$input_id\" class=\"file-uploader-label\">
            Choose File
        </label>
        <span id=\"filename-$input_id\"></span>
        <img id=\"$img_id\" src=\"#\" alt=\"User img\" class=\"image-preview $img_class\" />
    </div>
    ";
}

function baseAudioUploader($input_id = "", $input_class = "", $is_required = true) {
    $required_status = $is_required ? 'required' : '';
    $allowed_audio = implode(',', array_keys(ALLOWED_AUDIOS));
    echo
    "
    <div class=\"file-uploader-container\">
        <input type=\"file\" id=\"$input_id\" class=\"file-uploader $input_class\" $required_status name=\"$input_id\" accept=\"$allowed_audio\" aria-label=\"audio-upload\" />
        <label for=\"$input_id\" class=\"file-uploader-label\">
            Choose File
        </label>
        <span id=\"filename-$input_id\"></span>
    </div>
    ";
}
