<?php

class Sanitizer {
    public static function sanitizeParam($param, $default = "") {
        return isset($_GET[$param]) ? filter_var($_GET[$param], FILTER_SANITIZE_STRING) : $default;
    }

    public static function sanitizeArrayParam($param, $default = []) {
        return isset($_GET[$param]) ? array_map('filter_var', $_GET[$param], array_fill(0, count($_GET[$param]), FILTER_SANITIZE_STRING)) : $default;
    }
}
