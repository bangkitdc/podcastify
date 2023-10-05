<?php

require_once BASE_URL . '/src/config/storage.php';

class UploadService {

    private $storage;

    public function __construct($folderName) {
        $this->storage = new Storage($folderName);
    }

    public function upload($file_type) {
        switch ($file_type) {
            case "image":
                if (isset($_FILES['data'])) {
                    $tempName = $_FILES['data']['tmp_name'];
                    $fileName = $this->storage->saveImage($tempName);
                    echo $fileName;
                    return;
                }
                break;
            case "audio":
                if (isset($_FILES['data'])) {
                    $tempName = $_FILES['data']['tmp_name'];
                    $fileName = $this->storage->saveAudio($tempName);
                    echo $fileName;
                    return;
                }
                break;
            default:
                echo "Unsupported File Type!";
                break;
        }
    }
}
