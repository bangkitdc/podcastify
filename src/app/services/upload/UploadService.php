<?php

class UploadService {
    public static function upload() {
        $type = isset($_GET["type"]) ? filter_var($_GET["type"], FILTER_SANITIZE_STRING) : "image";

        $data = json_decode(file_get_contents('php://input'), true);

        if ($type == "image") {
            $upload_dir = IMAGES_DIR;
        } else { // for audio type files
            $upload_dir = AUDIOS_DIR;
        }

        $upload_file = BASE_URL . $upload_dir . basename($data['filename']);
        if (file_put_contents($upload_file, base64_decode($data['data']))) {
            echo $upload_file;
            return $upload_file;
        } else {
            return "ERROR";
        }

    }
}
