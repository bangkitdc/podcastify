<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_input_text.css">
</head>
<?php

function baseInputText($placeholder, $value, $id = "", $is_required = true, $class = "") {
    $required_status = $is_required ? 'required' : '';
    echo
    "
        <input type=\"text\" placeholder=\"$placeholder\" value=\"$value\" class=\"base-input $class\" id=\"$id\" $required_status name=\"$id\" />
    ";
}
