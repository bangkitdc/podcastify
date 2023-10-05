<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'base_components/modal_update.css">';

function echoUpdateModalTop($modalId, $modalTitle)
{
  echo '
    <div class="modal" id="' . $modalId . '">
      <div class="modal-overlay" onclick="closeModal(\'' . $modalId . '\', true)"></div>
      <div class="modal-content">
        <div class="modal-title">
          ' . $modalTitle . '
          <div class="close-button-modal" onclick="closeModal(\'' . $modalId . '\', true)">
            <img src="' . ICONS_DIR . 'close.svg" alt="Close Button">
          </div>
        </div>
  ';
}

function echoUpdateModalBottom($description)
{
  echo '
    <div class="modal-footer">
      ' . $description . '
    </div>
  </div>
</div>
  ';
}