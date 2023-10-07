<head>
<link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_button.css">
</head>
<?php

function baseButton($label, $id = "", $type = "default", $is_disabled = false, $class = "") {
    switch ($type) {
        case "default":
            $class = "base-btn default";
            break;
        case "submit":
        case "positive":
            $class = "base-btn positive";
            break;
        case "negative":
            $class = "base-btn negative";
            break;
        default: // custom type class
            $class = "base-btn $class";
            break;
    }
    $disable_status = $is_disabled ? "disabled" : "";
    $submit_status = $type == "submit" ? "submit" : "button";
    echo "<button id=\"$id\" name=\"$id\" class=\"$class\" $disable_status type=\"$submit_status\">$label</button>";
}
