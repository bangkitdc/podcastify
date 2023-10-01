<?php

class AudioAccess
{
    protected $fileName;
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getDuration()
    {
        $dur = shell_exec("ffmpeg -i " . $this->fileName . " 2>&1");
        if (preg_match("/: Invalid /", $dur)) {
            return false;
        }

        preg_match("/Duration: (.{2}):(.{2}):(.{2})/", $dur, $duration);
        if (!isset($duration[1]) || !isset($duration[2]) || !isset($duration[3])) {
            return false;
        }

        $hours = $duration[1];
        $minutes = $duration[2];
        $seconds = $duration[3];
        return $seconds + ($minutes * 60) + ($hours * 60 * 60);
    }
}