<head>
    <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_input_text.css">

</head>
<?php

function baseInputText($placeholder, $value, $id = "", $is_required = true, $class = "") {
    $required_status = $is_required ? 'required' : '';
    echo
    '
        <input type="text" placeholder="'. $placeholder .'" value="' . $value . '" class="base-input ' . $class . '" id="' . $id . '"' . $required_status . 'name="' . $id . '" />
        <div id="' . $id . '-alert" class="alert-hide">
            <img src="' . ICONS_DIR . 'warning.svg" alt="Warning No ' . $id . '" width="14px">
            <p></p>
        </div>
    ';
}

/**
 * $name will become id and this will be used in js file
 */
function echoInputText($name, $tabIndex, $isPassword = false, $eyeIcon = false)
{
    $capitalizedName = ucwords(str_replace('-', ' ', $name));

    if ($isPassword) {
        echo '
            <div class="form-group">
                <label for="' . $name . '">' . $capitalizedName . '</label>
            ';

        if ($eyeIcon) {
            echo '
                <div class="relative-container">
                    <input type="password" name="' . $name . '" placeholder="' . $capitalizedName . '" id="' . $name . '" class="password-input" autocomplete="on" tabindex="' . $tabIndex . '">
                    <div class="btn-eye">
                        <img class="eye-icon" src="' . ICONS_DIR . 'eye-closed.svg" alt="Hide ' . $capitalizedName . '">
                    </div>
                </div>
            ';
        } else {
            echo '
                <input type="password" name="' . $name . '" placeholder="' . $capitalizedName . '" id="' . $name . '" class="password-input" autocomplete="on" tabindex="' . $tabIndex . '">
            ';
        }

        echo '
                <div id="' . $name .'-alert" class="alert-hide">
                    <img src="' . ICONS_DIR .'warning.svg" alt="Warning No ' . $capitalizedName . '" width="14px">
                    <p></p>
                </div>
            </div>
        ';
    } else {
        echo '
            <div class="form-group">
                <label for="' . $name . '">' . $capitalizedName . '</label>
                <input type="text" name="' . $name . '" placeholder="' . $capitalizedName . '" id="' . $name . '" tabindex="' . $tabIndex . '">
                <div id="' . $name . '-alert" class="alert-hide">
                    <img src="' . ICONS_DIR . 'warning.svg" alt="Warning No ' . $capitalizedName . '" width="14px">
                    <p></p>
                </div>
            </div>
        ';
    }
}

function echoJsFile()
{
    echo '
        <script src="' . JS_DIR . 'lib/debounce.js"></script>
        <script src="' . JS_DIR . 'components/inputText.js"></script>
    ';
}
