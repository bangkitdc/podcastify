<?php

class ResponseHelper 
{
    public const HTTP_STATUS_OK = 200;
    public const HTTP_STATUS_CREATED = 201;
    public const HTTP_STATUS_ACCEPTED = 202;
    public const HTTP_STATUS_MOVED_PERMANENTLY = 301;
    public const HTTP_STATUS_FOUND = 302;
    public const HTTP_STATUS_BAD_REQUEST = 400;
    public const HTTP_STATUS_UNAUTHORIZED = 401;
    public const HTTP_STATUS_FORBIDDEN = 403;
    public const HTTP_STATUS_NOT_FOUND = 404;
    public const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;
    public const HTTP_STATUS_NOT_ACCEPTABLE = 406;
    public const HTTP_STATUS_PAYLOAD_TOO_LARGE = 413;
    public const HTTP_STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;
    /**
     * JSON response
     */
    public static function response($data, $status_code = self::HTTP_STATUS_OK)
    {
        if (!isset($data)) {
            $data = array();
        }

        $response_data = array(
            'status' => $status_code,
            'data' => $data
        );

        header('Content-Type: application/json', true, $status_code);
        $json = json_encode($response_data);
        echo $json;
    }

    public static function responseNotAllowedMethod()
    {
        self::response(["status_message" => "METHOD NOT ALLOWED"], self::HTTP_STATUS_METHOD_NOT_ALLOWED);
    }
}