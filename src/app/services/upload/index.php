<?php

require_once BASE_URL . '/src/config/storage.php';

class UploadService {

    private $podcast_storage;

    public function __construct() {
        $this->podcast_storage = new Storage(Storage::PODCAST_IMAGE_PATH);
    }

    public function upload() {
        if (isset($_FILES['data'])) {
            $tempName = $_FILES['data']['tmp_name'];
            $fileName = $this->podcast_storage->saveImage($tempName);
            echo $fileName;
            return;
        }
        echo "No Files Uploaded!";
    }
}
