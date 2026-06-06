<?php
declare(strict_types=1);

/*
 * ================================================================
 *  WATERMARK / LICENSE NOTICE
 *  Email   : andi.upn@gmail.com
 *  Website : kuncimu.com
 *  Info    : This source code is created and only sold officially on the mentioned website
 *            or official online store on the mentioned website.
 *            Support development by purchasing from the original store. Thank you.
 * ================================================================
 */

/**
 * CONFIG/CONFIG.PHP - CRUD Simple Application Configuration
 */

$config = [
    'app_name'    => getenv('APP_NAME') ?: 'PHP CRUD Starter Free',
    'base_path'   => dirname(__DIR__),
    'base_url'    => getenv('APP_BASE_URL') ?: null,
    'assets_url'  => getenv('APP_ASSETS_URL') ?: 'assets',
    'db_path'     => getenv('DB_PATH') ?: dirname(__DIR__) . '/db/database.sqlite',
];

/**
 * Get configuration value by key.
 */
function config(string $key, mixed $default = null): mixed
{
    global $config;

    return $config[$key] ?? $default;
}

/**
 * Get absolute path based on project root.
 */
function base_path(string $path = ''): string
{
    $root = rtrim(config('base_path'), DIRECTORY_SEPARATOR);

    if ($path === '') {
        return $root;
    }

    return $root . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
}

/**
 * Get global SQLite3 connection.
 */
function getDB(): SQLite3
{
    static $db = null;

    if ($db === null) {
        $db = new SQLite3(config('db_path'));
        $db->exec('PRAGMA foreign_keys = ON');
    }

    return $db;
}

require_once __DIR__ . '/setup.php';
