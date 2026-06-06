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

$errorMessage = '';
$successMessage = '';
$formData = [
    'name'  => '',
    'type' => '',
    'description'  => '',
    'category'   => '',
    'amount'    => '',
    'email'      => '',
    'phone'    => ''
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

        if (addItem($payload)) {
            redirect(base_url('?route=item/index&status=created'));
        } else {
            $errorMessage = 'Failed to add item. Please try again.';
        }
    } else {
        $errorMessage = implode('<br>', array_map('escape', $validation['errors']));
    }
}

$typeOptions = prepareTypeOptions($formData['type'] ?? '');

renderLayoutHeader('Add Item', 'item/create', 'container-lg');
?>

<section class="mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-semibold mb-1 text-success"><i class="bi bi-plus-circle me-2"></i>Add New Item</h1>
            <p class="text-muted mb-0">Fill out the form below to save item data.</p>
        </div>
        <div>
            <a href="<?= htmlspecialchars(base_url('?route=item/index'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to list
            </a>
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
        <div class="card border-0 shadow-sm h-100 border-accent-success">
            <div class="card-body p-4">
                <h2 class="h5 fw-semibold mb-4 text-success"><i class="bi bi-clipboard-plus me-2"></i>Item Details</h2>
                <form method="POST" action="<?= htmlspecialchars(base_url('?route=item/create'), ENT_QUOTES, 'UTF-8'); ?>" novalidate>
                    <?php include __DIR__ . '/_form.php'; ?>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-check-circle me-1"></i>Save Item
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100 border-accent-success">
            <div class="card-body p-4">
                <h3 class="h6 fw-semibold mb-3 text-success"><i class="bi bi-lightbulb me-2"></i>Filling Tips</h3>
                <ul class="list-unstyled text-muted d-grid gap-2 mb-0">
                    <li class="d-flex gap-2">
                        <i class="bi bi-asterisk text-danger"></i>
                        <span><strong>Name & type</strong> are required.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-currency-dollar text-success"></i>
                        <span>Amount only accepts positive numbers.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-envelope text-primary"></i>
                        <span>Email and phone are optional.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-card-text text-info"></i>
                        <span>Description helps provide additional context.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
renderLayoutFooter();
?>

