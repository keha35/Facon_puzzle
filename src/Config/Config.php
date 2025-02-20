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

    /**
     * Get a configuration value
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
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

    /**
     * Set a configuration value
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void
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

    /**
     * Check if a configuration value exists
     * 
     * @param string $key
     * @return bool
     */
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