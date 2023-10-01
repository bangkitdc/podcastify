<head>
<link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_button.css">
</head>
<?php

function baseButton($label, $id = "", $type = "default", $class = "") {
    switch ($type) {
        case "default":
            $class = "base-btn default";
            break;
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
    echo "<button id=\"$id\" class=\"$class\">$label</button>";
}
