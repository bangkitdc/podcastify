<?php

class Storage
{
    private $storageDir;

    public const USER_AVATAR_PATH = 'user/';
    public const PODCAST_IMAGE_PATH = 'podcast/';
    public const EPISODE_IMAGE_PATH = 'episode/images/';
    public const EPISODE_AUDIO_PATH = 'episode/audios/';

    public function __construct($folderName)
    {
        $this->storageDir = STORAGES_DIR . $folderName;
    }

    private function doesFileExist($fileName)
    {
        return file_exists($this->storageDir . $fileName);
    }

    public static function getFileUrl($PATH, $filename) {
        return "/src/storage/" . $PATH . $filename;
    }

    public function saveAudio($tempName)
    {
        $filesize = filesize($tempName);
        if ($filesize > MAX_SIZE) {
            error_log('Request Entity Too Large');
        }

        $mimetype = mime_content_type($tempName);
        if (!in_array($mimetype, array_keys(ALLOWED_AUDIOS))) {
            error_log('Unsupported Media Type');
        }

        $valid = false;
        while (!$valid) {
            // Set unique random filename
            $fileName = md5(uniqid(mt_rand(), true)) . ALLOWED_AUDIOS[$mimetype];
            $valid = !$this->doesFileExist($fileName);
        }

        $success = move_uploaded_file($tempName, $this->storageDir . $fileName);
        if (!$success) {
            error_log('Internal Server Error');
        }

        return $fileName;
    }

    public function saveImage($tempName)
    {
        $filesize = filesize($tempName);
        if ($filesize > MAX_SIZE) {
            error_log('Request Entity Too Large');
        }

        $mimetype = mime_content_type($tempName);
        if (!in_array($mimetype, array_keys(ALLOWED_IMAGES))) {
            error_log('Unsupported Media Type');
        }

        $valid = false;
        while (!$valid) {
            // Set unique random filename
            $fileName = md5(uniqid(mt_rand(), true)) . ALLOWED_IMAGES[$mimetype];
            $valid = !$this->doesFileExist($fileName);
        }

        $success = move_uploaded_file($tempName, $this->storageDir . $fileName);
        if (!$success) {
            error_log('Internal Server Error');
        }

        return $fileName;
    }

    public function deleteFile($fileName)
    {
        if (!$this->doesFileExist($fileName)) {
            return;
        }

        $success = unlink($this->storageDir . $fileName);
        if (!$success) {
            error_log('Internal Server Error');
        }
    }
}
