<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'base_components/modal.css">';

function infoModal($modal_id, $text, $ok_id, $modal_class = "") {
    echo
    "
    <div id=\"$modal_id\" class=\"info-modal modal $modal_class\">
        <div class=\"modal-content\">
            <p>$text</p>
            <button class=\"close-btn\" id=\"$ok_id\">Okay!</button>
        </div>
    </div>
    ";
}

function actionModal($modal_id, $text, $okay_id, $cancel_id, $modal_class = "") {
    echo
    "
    <div id=\"$modal_id\" class=\"action-modal modal $modal_class\">
        <div class=\"modal-content\">
            <p>$text</p>
            <div>
                <button class=\"okay-btn\" id=\"$okay_id\">Yes</button>
                <button class=\"close-btn\" id=\"$cancel_id\">Cancel</button>
            </div>
        </div>
    </div>
    ";
}

function echoModalJS() {
    echo '<script src="' . JS_DIR . 'modal.js"></script>';
}
