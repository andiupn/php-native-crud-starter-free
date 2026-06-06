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

require_once __DIR__ . '/../_helper.php';
require_once base_path('app/_layout.php');

$appName = config('app_name', 'CRUD Simple');
$appDescription = 'Simple application to manage item data with focus on basic CRUD flow.';

renderLayoutHeader('Home', 'site/index');
?>

<section class="mb-5">
    <div class="card border-0 shadow-sm border-start border-4 border-primary">
        <div class="card-body p-4 p-lg-5">
            <h1 class="h3 fw-semibold mb-3"><i class="bi bi-house-door me-2 text-primary"></i>Welcome to <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="text-muted mb-4"><?= htmlspecialchars($appDescription, ENT_QUOTES, 'UTF-8'); ?> Use the navigation above to view item list or add new data.</p>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= htmlspecialchars(base_url('?route=item/index'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">
                    <i class="bi bi-list-ul me-1"></i>View Item List
                </a>
                <a href="<?= htmlspecialchars(base_url('?route=item/create'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add New Item
                </a>
            </div>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
            <div class="card-body p-4">
                <h2 class="h5 fw-semibold mb-3"><i class="bi bi-diagram-3 me-2 text-info"></i>Short CRUD Flow</h2>
                <ol class="ps-3 text-muted mb-0 d-grid gap-2">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-plus-circle-fill text-success"></i>
                        <span>Add new data through the <strong>Add Item</strong> menu.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-search text-primary"></i>
                        <span>View and search data on the <strong>Item List</strong> page.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-pencil-square text-warning"></i>
                        <span>Use edit or delete actions as needed.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-save text-secondary"></i>
                        <span>Always save changes to update data.</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-secondary">
            <div class="card-body p-4">
                <h2 class="h5 fw-semibold mb-3"><i class="bi bi-lightbulb me-2 text-secondary"></i>Learning Tips</h2>
                <ul class="list-unstyled text-muted mb-0 d-grid gap-2">
                    <li class="d-flex gap-2">
                        <i class="bi bi-folder2-open text-primary"></i>
                        <span><strong>Study folder structure:</strong> note the separation between config, model, and view.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-input-cursor-text text-success"></i>
                        <span><strong>Check form code:</strong> file `app/item/_form.php` shows data binding method.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-shield-check text-info"></i>
                        <span><strong>Observe helper:</strong> functions in `app/_helper.php` help maintain output security.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-flask text-danger"></i>
                        <span><strong>Experiment:</strong> change CSS or add new fields to understand the full flow.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
renderLayoutFooter();