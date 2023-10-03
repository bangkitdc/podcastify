<?php

class Sanitizer {
    public static function sanitizeStringParam($param, $default = "") {
        return isset($_GET[$param]) ? filter_var($_GET[$param], FILTER_SANITIZE_STRING) : $default;
    }

    public static function sanitizeIntParam($param, $default = 1) {
        return isset($_GET[$param]) ? filter_var($_GET[$param], FILTER_SANITIZE_NUMBER_INT) : $default;
    }

    public static function sanitizeStringArrayParam($param, $default = []) {
        return isset($_GET[$param]) ? array_map('filter_var', $_GET[$param], array_fill(0, count($_GET[$param]), FILTER_SANITIZE_STRING)) : $default;
    }
}
