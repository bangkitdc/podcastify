<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_tables.css">
</head>
<?php

// $dataHeader = ["Username", "Email", "Last Login", "Status"];

function echoTableHeader($dataHeader = [])
{
  echo '
    <table class="tables">
      <tr>
        <th style="font-size:16px;">#</th>
  ';

  foreach ($dataHeader as $d) {
    echo '
      <th>' . $d . '</th>
    ';
  }

  echo '
    </tr>
    <tr>
      <td colspan="5" class="gap"></td>
    </tr>
  ';
}

// number, img, title, subtitle, ... (bebas)
// $dataContent = [1, "IMAGES_DIR . sample-podcast-1.jpg", "Icad", "Icad Basuki", "icad@gmail.com", "1 hour ago", "Active"];

function echoTableContent($dataContext = [], $dataContent = [], $onClick = "", $id = "") {  
  echo '
    <tr class="content-tables" onclick="' . $onClick . '" id="' . $id . '">
      <td style="padding-left:14px">' . $dataContent[0] . '</td>
      <td class="content-title">
        <img class="content-img" id="' . $dataContext[1] . $id . '" src="' . $dataContent[1] . '" alt="Image User ' . $id . '">
        <div class="content-text">
          <p class="content-first" id="' . $dataContext[2] . $id . '">' . $dataContent[2] . '</p>
          <p class="content-second" id="' . $dataContext[3] . $id . '">' . $dataContent[3] . '</p>
        </div>
      </td>
  ';

  for ($i = 4; $i < count($dataContent); $i++) {
    echo '<td id="' . $dataContext[$i] . $id . '">' . $dataContent[$i] . '</td>';
  }
}

function echoClosingTag()
{
  echo '
      </tr>
    </table>
  ';
}