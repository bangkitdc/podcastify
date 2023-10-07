<?php

require_once BASE_URL . '/src/config/storage.php';

function episodeList($episodes = null, $is_skeleton = false, $click_evt = "") {
    require_once VIEWS_DIR . "/components/shares/tables/primary.php";
    $dataHeader = ["Episode Title", "Description", "Duration", "Created At"];

    echoTableHeader($dataHeader, [35, 30, 15, 15]);

    $index = 1;

    foreach ($episodes as $episode) {
        $datetime = new DateTime($episode->created_at);
        $datetime->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $formatted_time = $datetime->format('Y-m-d H:i:s');

        $dataContext = [
        "number",
        "thumbnail",
        "eps_title",
        "",
        "eps_description",
        "duration",
        "created_at"
        ];

        $data = [
        $index,
        Storage::getFileUrl(Storage::EPISODE_IMAGE_PATH, $episode->image_url),
        ucwords($episode->title),
        "",
        $episode->description,
        $episode->duration,
        $formatted_time
        ];

        echoTableContent($dataContext, $data, "goToEpisodeDetail($episode->episode_id)");

        $index++;
    }


    echoClosingTag();
}

function echoEpsListJS(){
    echo '
        <script src="' . JS_DIR . 'podcast/eps_list.js"></script>
    ';
}
