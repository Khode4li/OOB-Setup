<?php

namespace config;

class registry
{
    private static array $data = [];

    public static function get(string $key)
    {
        if (isset(self::$data[$key]) && !empty(self::$data[$key]))
            return self::$data[$key];
        throw new \Exception("the provided key: '{$key}' does not exist");
    }

    public static function set(string $key, mixed $value, bool $replace = false): void
    {
        if (isset(self::$data[$key])) {
            if ($replace) {
                self::$data[$key] = $value;
            }
        } else {
            self::$data[$key] = $value;
        }
    }
}