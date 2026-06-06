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
require_once base_path('app/model_item.php');
require_once base_path('app/_layout.php');

$searchKeyword = trim($_GET['search'] ?? '');
$statusParam = strtolower(trim($_GET['status'] ?? ''));
$statusAlerts = [
    'created' => [
        'class' => 'success',
        'icon' => 'check-circle-fill',
        'title' => 'Item successfully added.',
        'description' => 'New item has been added to the list and is ready to be managed.'
    ],
    'updated' => [
        'class' => 'info',
        'icon' => 'pencil-square',
        'title' => 'Item successfully updated.',
        'description' => 'Item data has been updated successfully.'
    ],
    'deleted' => [
        'class' => 'warning',
        'icon' => 'trash3-fill',
        'title' => 'Item successfully deleted.',
        'description' => 'Data has been removed from the list. You can add new items anytime.'
    ],
];
$statusAlert = $statusAlerts[$statusParam] ?? null;
$items = $searchKeyword !== '' ? searchItems($searchKeyword) : getAllItems();
$totalItems = count($items);

renderLayoutHeader('Item List', 'item/index', 'container-lg');
?>

<?php if ($statusAlert !== null): ?>
    <section class="mb-4">
        <div class="alert alert-<?= htmlspecialchars($statusAlert['class'], ENT_QUOTES, 'UTF-8'); ?> border-0 shadow-sm d-flex align-items-start gap-3 mb-0">
            <i class="bi bi-<?= htmlspecialchars($statusAlert['icon'], ENT_QUOTES, 'UTF-8'); ?> fs-4"></i>
            <div>
                <h6 class="mb-1"><?= escape($statusAlert['title']); ?></h6>
                <p class="mb-0 text-muted"><?= escape($statusAlert['description']); ?></p>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-semibold mb-1"><i class="bi bi-list-ul me-2 text-primary"></i>Item List</h1>
            <p class="text-muted mb-0">Manage item data available in the system.</p>
        </div>
        <div class="d-flex flex-column align-items-md-end gap-2">
            <span class="text-muted small"><i class="bi bi-hash me-1"></i>Total items: <strong><?= $totalItems ?></strong></span>
            <a href="<?= htmlspecialchars(base_url('?route=item/create'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Add Item
            </a>
        </div>
    </div>
</section>

<section class="mb-4">
    <form method="GET" action="<?= htmlspecialchars(base_url(), ENT_QUOTES, 'UTF-8'); ?>" class="row gy-2 gx-2 align-items-end">
        <input type="hidden" name="route" value="item/index">
        <div class="col-md-8 col-lg-9">
            <label for="search" class="form-label">Search item</label>
            <input type="text"
                   id="search"
                   name="search"
                   class="form-control"
                   placeholder="Enter name, type, category, or description"
                   value="<?= escape($searchKeyword) ?>"
                   autocomplete="off">
        </div>
        <div class="col-md-4 col-lg-3">
            <label class="form-label">Quick filter</label>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= htmlspecialchars(base_url('?route=item/index'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-collection me-1"></i>All
                </a>
                <a href="<?= htmlspecialchars(base_url('?route=item/index&search=Electronics'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-laptop me-1"></i>Electronics
                </a>
                <a href="<?= htmlspecialchars(base_url('?route=item/index&search=Accessories'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-earbuds me-1"></i>Accessories
                </a>
                <a href="<?= htmlspecialchars(base_url('?route=item/index&search=Beverage'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-cup-straw me-1"></i>Beverage
                </a>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-search me-1"></i>Search
            </button>
            <?php if ($searchKeyword !== ''): ?>
                <a href="<?= htmlspecialchars(base_url('?route=item/index'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-link btn-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset search
                </a>
            <?php endif; ?>
        </div>
    </form>
</section>

<?php if ($searchKeyword !== ''): ?>
    <section class="row g-4 mb-4">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-3 mb-0">
                <i class="bi bi-info-circle-fill fs-4"></i>
                <div>
                    <h6 class="mb-1">Search results</h6>
                    <p class="mb-0 text-muted">Found <strong><?= $totalItems ?></strong> items for keyword "<strong><?= escape($searchKeyword) ?></strong>".</p>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ($totalItems > 0): ?>
    <section class="card border-0 shadow-sm border-accent-primary">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 crud-list-table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Category</th>
                            <th scope="col" class="text-end">Amount</th>
                            <th scope="col">Contact</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($items as $item): ?>
                            <tr>
                                <td class="text-center text-muted crud-cell-number" data-label="No"><?= $no++ ?></td>
                                <td data-label="Name">
                                    <div class="fw-semibold"><?= escape($item['name']) ?></div>
                                    <?php
                                        $rawDescription = trim((string)($item['description'] ?? ''));
                                        if ($rawDescription !== ''):
                                            if (function_exists('mb_substr') && function_exists('mb_strlen')) {
                                                $shortDescription = mb_strlen($rawDescription, 'UTF-8') > 80
                                                    ? mb_substr($rawDescription, 0, 80, 'UTF-8') . '...'
                                                    : $rawDescription;
                                            } else {
                                                $shortDescription = strlen($rawDescription) > 80
                                                    ? substr($rawDescription, 0, 80) . '...'
                                                    : $rawDescription;
                                            }
                                    ?>
                                        <div class="small text-muted mt-1"><?= escape($shortDescription) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Type"><?= escape($item['type']) ?></td>
                                <td data-label="Category">
                                    <?php if ($item['category'] !== ''): ?>
                                        <?= escape($item['category']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end" data-label="Amount">
                                    <?php if ((int)$item['amount'] > 0): ?>
                                        <?= escape(formatRupiah($item['amount'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="crud-contact-cell" data-label="Contact">
                                    <?php if (!empty($item['email'])): ?>
                                        <div><a href="mailto:<?= escape($item['email']) ?>" class="link-secondary"><?= escape($item['email']) ?></a></div>
                                    <?php endif; ?>
                                    <?php if (!empty($item['phone'])):
                                        $phoneHref = preg_replace('/[^0-9+]/', '', $item['phone']);
                                    ?>
                                        <div><a href="tel:<?= escape($phoneHref) ?>" class="link-secondary"><?= escape($item['phone']) ?></a></div>
                                    <?php endif; ?>
                                    <?php if (empty($item['email']) && empty($item['phone'])): ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center crud-actions-cell" data-label="Action">
                                    <a href="<?= htmlspecialchars(base_url('?route=item/edit&id=' . (int)$item['id']), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <a href="<?= htmlspecialchars(base_url('?route=item/delete&id=' . (int)$item['id']), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-danger btn-sm" data-item="<?= escape($item['name']) ?>">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="text-center py-5 bg-white border rounded-3 border-accent-primary">
        <p class="lead mb-2"><i class="bi bi-inbox me-2 text-primary"></i>No data available to display.</p>
        <?php if ($searchKeyword !== ''): ?>
            <p class="text-muted">No items found for keyword "<strong><?= escape($searchKeyword) ?></strong>".</p>
        <?php else: ?>
            <p class="text-muted">Start by adding your first item.</p>
        <?php endif; ?>
        <a href="<?= htmlspecialchars(base_url('?route=item/create'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Add Item
        </a>
    </section>
<?php endif; ?>

<?php
renderLayoutFooter();
?>
