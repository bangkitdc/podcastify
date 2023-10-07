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
                    $filesize = filesize($tempName);
                    if ($filesize > MAX_SIZE) {
                        throw new Exception('Request Entity Too Large', ResponseHelper::HTTP_STATUS_PAYLOAD_TOO_LARGE);
                    }
                    $fileName = $this->storage->saveImage($tempName);
                    echo $fileName;
                    return;
                }
                break;
            case "audio":
                if (isset($_FILES['data'])) {
                    $tempName = $_FILES['data']['tmp_name'];
                    $filesize = filesize($tempName);
                    if ($filesize > MAX_SIZE) {
                        throw new Exception('Request Entity Too Large', ResponseHelper::HTTP_STATUS_PAYLOAD_TOO_LARGE);
                    }
                    $fileName = $this->storage->saveAudio($tempName);
                    echo $fileName;
                    return;
                }
                break;
            default:
                throw new Exception('Unsupported File Type!', ResponseHelper::HTTP_STATUS_BAD_REQUEST);
        }
    }

    public function getUniqueFilename() {
        $file = $_FILES['data']['tmp_name'];

        $filesize = filesize($file);
        if ($filesize > MAX_SIZE) {
            throw new Exception('Request Entity Too Large', ResponseHelper::HTTP_STATUS_PAYLOAD_TOO_LARGE);
        }

        $mimetype = mime_content_type($file);
        if (!in_array($mimetype, array_keys(ALLOWED_IMAGES))) {
            throw new Exception('Unsupported Media Type', ResponseHelper::HTTP_STATUS_UNSUPPORTED_MEDIA_TYPE);
        }

        return $this->storage->getUniqueRandomName() . ALLOWED_IMAGES[$mimetype];
    }

    public function replaceAvatarImage($oldfileName, $fileName) {
        $this->storage->deleteFile($oldfileName);

        $file = $_FILES['data']['tmp_name'];
        $this->storage->saveAvatarImage($fileName, $file);
    }
}
