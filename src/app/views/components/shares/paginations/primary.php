<?php

echo '<link rel="stylesheet" href="' . CSS_DIR . 'base_components/base_pagination.css">';

// paginationId, currentPage, totalpages, onClick event
function echoPaginationNav($paginationId, $currentPage, $totalPages, $onClick = [])
{
  echo
  '
    <div class="list-nav">
      <button class="nav-btn" onclick="' . $onClick[0] . '">
        <img src="' . ICONS_DIR . 'skip_previous.svg" width="20px" />
      </button>
      <button class="nav-btn" onclick="' . $onClick[1] . '">
        <img src="' . ICONS_DIR . 'left-arrow.svg" width="16px" />
      </button>
      <div class="nav-info">
        <span id="' . $paginationId . '-list-page-num">' . $currentPage . '</span> of <span id="' . $paginationId . '-list-total-pages">' . $totalPages . '</span>
      </div>
      <button class="nav-btn" onclick="' . $onClick[2] . '">
        <img src="' . ICONS_DIR . 'right-arrow.svg" width="16px" />
      </button>
      <button class="nav-btn" onclick="' . $onClick[3] . '">
        <img src="' . ICONS_DIR . 'skip_next.svg" width="20px" />
      </button>
    </div>
    ';
}
