<head>
  <link rel="stylesheet" href="<?= CSS_DIR ?>base_components/base_tables.css">
</head>
<?php

$dataHeader = ["Username", "Email", "Last Login", "Status"];

function echoTableHeader($dataHeader = [])
{
  // $dataHeader = ["Username", "Email", "Last Login", "Status"];

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
$dataContent = [1, "<?= IMAGES_DIR ?>sample-podcast-1.jpg", "Icad", "Icad Basuki", "icad@gmail.com", "1 hour ago", "Active"];

function echoTableContent($dataContent = []) {
  // $dataContent = [1, IMAGES_DIR . "sample-podcast-1.jpg", "Icad", "Icad Basuki", "icad@gmail.com", "1 hour ago", "Active"];
  
  echo '
    <tr class="content-tables">
      <td style="padding-left:14px">' . $dataContent[0] . '</td>
      <td class="content-title">
        <img class="content-img" src="' . $dataContent[1] . '" alt="image1">
        <div class="content-text">
          <p class="content-first">' . $dataContent[2] . '</p>
          <p class="content-second">' . $dataContent[3] . '</p>
        </div>
      </td>
  ';

  for ($i = 4; $i < count($dataContent); $i++) {
    echo '<td>' . $dataContent[$i] . '</td>';
  }
}

function echoClosingTag()
{
  echo '
      </tr>
    </table>
  ';
}