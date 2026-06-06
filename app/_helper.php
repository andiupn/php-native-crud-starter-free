<?php
declare(strict_types=1);

/**
 * ================================================================
 *  WATERMARK / LICENSE NOTICE
 *  Email   : andi.upn@gmail.com
 *  Website : kuncimu.com
 *  Info    : This source code is created and only sold officially on the mentioned website
 *            or official online store on the mentioned website.
 *            Support development by purchasing from the original store. Thank you.
 * ================================================================
 */

require_once __DIR__ . '/../config/config.php';

/**
 * Clean route value from request to only contain safe characters.
 */
function sanitizeRouteParam(?string $route): string
{
    $route = $route ?? '';
    $route = trim($route, "/ \\\t\n\r");

    if ($route === '') {
        return 'site/index';
    }

    $route = preg_replace('#[^a-zA-Z0-9_/.-]#', '', $route) ?? '';
    $route = preg_replace('#/{2,}#', '/', $route) ?? '';

    if ($route === '' || $route === '.') {
        return 'site/index';
    }

    return $route;
}

/**
 * Determine view file location based on sanitized route.
 */
function resolveViewPath(string $route): string
{
    $route = str_replace(['..', '\\'], '', $route);
    $path = base_path('app/' . $route . '.php');

    return $path;
}

/**
 * Render PHP view file and automatically extract given data.
 */
function renderView(string $route, array $data = []): void
{
    $viewPath = resolveViewPath($route);

    if (!is_file($viewPath)) {
        respondWithHttpError(404, 'Page not found');
        return;
    }

    extract($data, EXTR_SKIP);
    include $viewPath;
}

/**
 * Send simple error page with specific HTTP code.
 */
function respondWithHttpError(int $code, string $message = 'An error occurred'): void
{
    http_response_code($code);
    header('Content-Type: text/html; charset=utf-8');
    $safeCode = htmlspecialchars((string) $code, ENT_QUOTES, 'UTF-8');
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $homeUrl = htmlspecialchars(base_url(), ENT_QUOTES, 'UTF-8');

    $body = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{$safeCode} – Error</title>
    <style>
        body {font-family: system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; padding: 3rem; background: #f6f7fb; color: #2d2d2d; text-align: center;}
        h1 {font-size: 2.5rem; margin-bottom: 1rem;}
        p {margin: 0 auto; max-width: 32rem; line-height: 1.6;}
        a {color: #0d6efd; text-decoration: none;}
        a:hover {text-decoration: underline;}
    </style>
</head>
<body>
    <h1>An Error Occurred</h1>
    <p>Code: <strong>{$safeCode}</strong></p>
    <p>{$safeMessage}</p>
    <p><a href="{$homeUrl}">Back to home</a></p>
</body>
</html>
HTML;

    echo $body;
    exit;
}

/**
 * Escape string before displaying in HTML.
 */
function escape(?string $text): string
{
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect user to another URL and stop script execution.
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Determine application base URL only once.
 */
function detectBaseUrl(): string
{
    static $detected = null;

    if ($detected !== null) {
        return $detected;
    }

    $configured = trim((string) config('base_url', ''));

    if ($configured !== '' && $configured !== '/' && $configured !== '.') {
        $detected = '/' . ltrim($configured, '/');
    } else {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $scriptDir = trim($scriptDir);
        if ($scriptDir === '' || $scriptDir === '/' || $scriptDir === '.') {
            $detected = '';
        } else {
            $detected = '/' . ltrim($scriptDir, '/');
        }
    }

    $detected = rtrim($detected, '/');

    return $detected;
}

/**
 * Separate path and query string parts from `base_url()` argument.
 *
 * @return array{0:string,1:string} Format [path, query]
 */
function splitPathAndQuery(string $path): array
{
    if ($path === '') {
        return ['', ''];
    }

    if ($path[0] === '?') {
        return ['', substr($path, 1) ?: ''];
    }

    $parts = explode('?', $path, 2);

    return [$parts[0], $parts[1] ?? ''];
}

/**
 * Build absolute URL relative to application base URL.
 */
function base_url(string $path = ''): string
{
    $base = detectBaseUrl();
    $path = $path ?? '';

    [$rawPath, $query] = splitPathAndQuery($path);
    $normalizedPath = trim($rawPath, '/');

    $hasPath = $normalizedPath !== '';

    if ($base === '') {
        $url = $hasPath ? '/' . $normalizedPath : '/';
    } else {
        $url = $hasPath ? $base . '/' . $normalizedPath : $base . '/';
    }

    if ($query !== '') {
        $url .= '?' . $query;
    }

    return $url;
}

/**
 * Build URL for static assets (CSS, JS, images).
 */
function asset_url(string $path): string
{
    $assetsBase = trim((string) config('assets_url', 'assets'), '/');
    $normalizedPath = trim($path ?? '', '/');

    if ($assetsBase === '') {
        return $normalizedPath === '' ? base_url('') : base_url($normalizedPath);
    }

    if ($normalizedPath === '') {
        return base_url($assetsBase);
    }

    return base_url($assetsBase . '/' . $normalizedPath);
}

/**
 * Simple JSON response helper (for health check).
 */
function respondJson(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

