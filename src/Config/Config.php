<?php

namespace App\Config;

class Config
{
    private static array $config = [];

    public static function load(): void
    {
        self::$config['app'] = require __DIR__ . '/app.php';
        self::$config['database'] = require __DIR__ . '/database.config.php';
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (empty(self::$config)) {
            self::load();
        }

        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                return $default;
            }
            $config = $config[$k];
        }

        return $config;
    }

    public static function set(string $key, mixed $value): void
    {
        if (empty(self::$config)) {
            self::load();
        }

        $keys = explode('.', $key);
        $config = &self::$config;

        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                $config[$k] = [];
            }
            $config = &$config[$k];
        }

        $config = $value;
    }

    public static function has(string $key): bool
    {
        if (empty(self::$config)) {
            self::load();
        }

        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                return false;
            }
            $config = $config[$k];
        }

        return true;
    }
} 