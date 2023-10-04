<?php

function echoUpdateModalTop($modalId)
{
  echo '
    <div class="modal" id="' . $modalId . '">
      <div class="modal-overlay" onclick="closeModal(\'' . $modalId . '\')"></div>
      <div class="modal-content">
        <div class="modal-title">
          User details
          <div class="close-button-modal" onclick="closeModal(\'' . $modalId . '\')">
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