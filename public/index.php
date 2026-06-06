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

require_once __DIR__ . '/../app/_helper.php';

$route = sanitizeRouteParam($_GET['route'] ?? 'site/index');

$viewPath = resolveViewPath($route);

if (!is_file($viewPath)) {
    respondWithHttpError(404, 'Page not found');
    exit;
}

renderView($route);
