<?php

namespace Core;

class Request
{
    public static function all()
    {
        $data = array_merge($_GET, $_POST);

        if (self::isJson()) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = array_merge($data, $jsonData);
            }
        }

        return $data;
    }

    public static function input($key)
    {
        $data = self::all();
        return $data[$key] ?? null;
    }

    public static function query($key)
    {
        return $_GET[$key] ?? null;
    }

    private static function isJson()
    {
        return isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }
}
