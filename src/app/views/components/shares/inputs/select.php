<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_select.css">
</head>
<?php

function baseSelect($options, $selected_value, $id = "", $is_required = true, $class = "") {
    $required_status = $is_required ? 'required' : '';
    echo '
    <div class="base-select-box">
        <select class="base-select ' . $class . '" id="' . $id . '" ' . $required_status . ' name="' . $id . '" aria-label="select field">';
    foreach ($options as $option) {
        $selected = ($option == $selected_value) ? 'selected' : '';
        echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
    }
    echo
    '
        </select>
        <div class="base-select-arrow-icon" id="base-select-arrow-' . $id . '">
            <img src="' . ICONS_DIR . 'down-arrow.svg" alt="down_arrow" />
        </div>
    </div>
    ';
}

function baseCheckbox($options, $selected_values, $id = "", $label = "", $is_required = true, $class = "") {
    $checkboxes_options = $options;
    array_unshift($checkboxes_options, "All");

    echo '
    <div class="base-checkbox-box" id="' . $id . '">

        <input class="base-checkbox-blank-field" type="text" value="' . $label . '" id="checkbox-blank-field-' . $id . '" disabled aria-label="checkbox field" />
        <div class="base-checkbox ' . $class . '" name="' . $id . '">
        ';
        $checked = ($selected_values == "All") ? 'checked' : '';
        $index = 0;
        foreach ($checkboxes_options as $opt) {
            echo
            '
                <div class="checkboxes-box">
                    <input type="checkbox" value="' . $opt . '" id="checkbox-' . $id . '-' . $index . '" ' . $checked . ' aria-label="checkbox value" />
                    <label for="checkbox-' . $id . '">' . $opt . '</label>
                </div>

            ';
            $index++;
        }

    echo
    '
        </div>
        <div class="base-checkbox-arrow-icon" id="base-checkbox-arrow-' . $id . '">
            <img src="' . ICONS_DIR . 'down-arrow.svg" alt="down_arrow" />
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
