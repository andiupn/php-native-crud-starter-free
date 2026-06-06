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

/**
 * APP/_LAYOUT.PHP - Main layout component.
 */

if (!function_exists('renderLayoutHeader')) {
    function renderLayoutHeader(string $pageTitle = '', string $activeMenu = 'site/index', string $containerClass = 'container-lg'): void
    {
        $appName = config('app_name', 'CRUD Simple');
        $fullTitle = trim($pageTitle) !== '' ? sprintf('%s | %s', $pageTitle, $appName) : $appName;

        $navItems = [
            'site/index' => [
                'label' => 'Home',
                'route' => 'site/index',
                'icon'  => 'house-door',
            ],
            'item/index' => [
                'label' => 'Item List',
                'route' => 'item/index',
                'icon'  => 'list-ul',
            ],
            'item/create' => [
                'label' => 'Add Item',
                'route' => 'item/create',
                'icon'  => 'plus-circle',
            ],
        ];
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="CRUD Simple with Bootstrap 5 for managing item data in a modern and responsive way.">
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%23198754'/%3E%3Cpath d='M18 20h28v6H18zm0 10h28v6H18zm0 10h18v6H18z' fill='white'/%3E%3C/svg%3E">
    <link href="<?= htmlspecialchars(asset_url('vendor/bootstrap/bootstrap.min.css'), ENT_QUOTES, 'UTF-8'); ?>" rel="stylesheet">
    <link href="<?= htmlspecialchars(asset_url('vendor/bootstrap-icons/bootstrap-icons.css'), ENT_QUOTES, 'UTF-8'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars(asset_url('css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
</head>
<body class="d-flex flex-column min-vh-100 bg-body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-lg">
            <a class="navbar-brand fw-semibold text-white" href="<?= htmlspecialchars(base_url('?route=site/index'), ENT_QUOTES, 'UTF-8'); ?>">
                <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-lg-3">
                    <?php foreach ($navItems as $key => $item):
                        $isActive = $key === $activeMenu;
                        $url = base_url('?route=' . $item['route']);
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-white<?= $isActive ? ' active fw-semibold' : ''; ?>" href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>"<?= $isActive ? ' aria-current="page"' : ''; ?>>
                                <i class="bi bi-<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?> me-1"></i><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-4">
        <div class="<?= htmlspecialchars($containerClass, ENT_QUOTES, 'UTF-8'); ?>">
<?php
    }
}

if (!function_exists('renderLayoutFooter')) {
    function renderLayoutFooter(): void
    {
        ?>
        </div>
    </main>

    <footer class="bg-success py-4 mt-auto">
        <div class="container-lg">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <p class="mb-0 text-white small">
                    &copy; <?= date('Y'); ?> <?= htmlspecialchars(config('app_name', 'CRUD Simple'), ENT_QUOTES, 'UTF-8'); ?>. Built for basic CRUD practice.
                </p>
                <p class="mb-0 small">
                    <a href="https://kuncimu.com" class="text-white" target="_blank" rel="noopener">kuncimu.com</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="<?= htmlspecialchars(asset_url('vendor/bootstrap/bootstrap.bundle.min.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
    <script src="<?= htmlspecialchars(asset_url('js/script.js'), ENT_QUOTES, 'UTF-8'); ?>" defer></script>
</body>
</html>
<?php
    }
}
