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

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    redirect(base_url('?route=item/index'));
}

$item = getItemById($id);
if (!$item) {
    redirect(base_url('?route=item/index'));
}

$errorMessage = '';
$successMessage = '';
$formData = [
    'name'  => $item['name'] ?? '',
    'type' => $item['type'] ?? '',
    'description'  => $item['description'] ?? '',
    'category'   => $item['category'] ?? '',
    'amount'    => (string)($item['amount'] ?? ''),
    'email'      => $item['email'] ?? '',
    'phone'    => $item['phone'] ?? '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name'  => trim($_POST['name'] ?? ''),
        'type' => trim($_POST['type'] ?? ''),
        'description'  => trim($_POST['description'] ?? ''),
        'category'   => trim($_POST['category'] ?? ''),
        'amount'    => trim($_POST['amount'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'phone'    => trim($_POST['phone'] ?? '')
    ];

    $validation = validateItemData($formData);

    if ($validation['valid']) {
        $payload = $formData;
        $payload['amount'] = (int) ($formData['amount'] === '' ? 0 : $formData['amount']);

        if (updateItem($id, $payload)) {
            redirect(base_url('?route=item/index&status=updated'));
        } else {
            $errorMessage = 'Failed to update item. Please try again.';
        }
    } else {
        $errorMessage = implode('<br>', array_map('escape', $validation['errors']));
    }
}

$typeOptions = prepareTypeOptions($formData['type'] ?? '');

renderLayoutHeader('Edit Item', 'item/index', 'container-lg');
?>

<section class="mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-semibold mb-1 text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Item</h1>
            <p class="text-muted mb-0">Updating data for item "<?= escape($item['name']) ?>".</p>
        </div>
        <div class="text-muted small">
            <i class="bi bi-hash"></i> #<?= (int)$item['id'] ?> · <i class="bi bi-calendar"></i> <?= date('d M Y H:i', strtotime($item['date_created'])) ?>
        </div>
    </div>
</section>

<section class="mb-4">
    <div class="alert alert-warning mb-0">
        <i class="bi bi-shield-exclamation me-2"></i><strong>Note:</strong> This exercise example does not use CSRF tokens. Add protection before using in production.
    </div>
</section>

<?php if ($errorMessage !== ''): ?>
    <section class="mb-4">
        <div class="alert alert-danger mb-0">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $errorMessage ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($successMessage !== ''): ?>
    <section class="mb-4">
        <div class="alert alert-success mb-0">
            <i class="bi bi-check-circle-fill me-2"></i><?= escape($successMessage) ?>
        </div>
    </section>
<?php endif; ?>

<section class="row g-4 mb-5">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100 border-accent-warning">
            <div class="card-body p-4">
                <h2 class="h5 fw-semibold mb-4 text-warning"><i class="bi bi-clipboard-check me-2"></i>Item Details</h2>
                <form method="POST" action="<?= htmlspecialchars(base_url('?route=item/edit&id=' . $id), ENT_QUOTES, 'UTF-8'); ?>" novalidate>
                    <?php include __DIR__ . '/_form.php'; ?>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="submit" class="btn btn-warning btn-sm text-dark">
                            <i class="bi bi-check-circle me-1"></i>Save Changes
                        </button>
                        <a href="<?= htmlspecialchars(base_url('?route=item/index'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                        <a href="<?= htmlspecialchars(base_url('?route=item/delete&id=' . (int)$item['id']), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Delete Item
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100 border-accent-warning">
            <div class="card-body p-4">
                <h3 class="h6 fw-semibold mb-3 text-warning"><i class="bi bi-clipboard-data me-2"></i>Item Summary</h3>
                <dl class="row mb-0 text-muted small">
                    <dt class="col-5">Item ID</dt>
                    <dd class="col-7 fw-semibold text-dark"><i class="bi bi-hash me-1"></i>#<?= (int)$item['id'] ?></dd>

                    <dt class="col-5">Created</dt>
                    <dd class="col-7 text-dark"><i class="bi bi-calendar me-1"></i><?= date('d M Y H:i', strtotime($item['date_created'])) ?></dd>

                    <dt class="col-5">Type</dt>
                    <dd class="col-7 text-dark"><i class="bi bi-tag me-1"></i><?= escape($item['type']) ?></dd>

                    <dt class="col-5">Category</dt>
                    <dd class="col-7 text-dark">
                        <?php if ($item['category'] !== ''): ?>
                            <i class="bi bi-bookmark me-1"></i><?= escape($item['category']) ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-5">Amount</dt>
                    <dd class="col-7 text-dark">
                        <?php if ((int)$item['amount'] > 0): ?>
                            <i class="bi bi-currency-dollar me-1"></i><?= escape(formatRupiah($item['amount'])) ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</section>

<?php
renderLayoutFooter();
?>
