<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_select.css">
</head>
<?php

function baseSelect($options, $selected_value, $id = "", $is_required = true, $class = "") {
    $required_status = $is_required ? 'required' : '';
    echo '
    <div class="base-select-box">
        <select class="base-select ' . $class . '" id="' . $id . '" ' . $required_status . ' name="' . $id . '">';
    foreach ($options as $option) {
        $selected = ($option == $selected_value) ? 'selected' : '';
        echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
    }
    echo
    '
        </select>
        <div class="base-select-arrow-icon" id="base-select-arrow-' . $id . '">
            <img src="' . ICONS_DIR . 'down-arrow-black.svg" />
        </div>
    </div>
    ';
}

function echoSelectJS()
{
    echo '
        <script src="' . JS_DIR . 'components/baseSelect.js"></script>
    ';
}
