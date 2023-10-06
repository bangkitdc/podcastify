<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/no_button_file_uploader.css">
</head>
<?php

function customImageUploader($input_id = "")
{
  $allowed_img = implode(',', array_keys(ALLOWED_IMAGES));
  echo
  "
    <input type=\"file\" id=\"$input_id\" class='file-uploader' name=\"$input_id\" accept=\"$allowed_img\" />
    ";
}
