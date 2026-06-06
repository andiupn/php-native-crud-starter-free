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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        if (deleteItem($id)) {
            redirect(base_url('?route=item/index&status=deleted'));
        } else {
            $errorMessage = 'Failed to delete item. Please try again.';
        }
    } else {
        redirect(base_url('?route=item/index'));
    }
}

renderLayoutHeader('Delete Item', 'item/index', 'container-lg');
?>

<section class="mb-4">
    <div class="card border-0 shadow-sm border-accent-danger">
        <div class="card-body p-4">
            <h1 class="h4 fw-semibold text-danger mb-3"><i class="bi bi-trash3 me-2"></i>Delete Item</h1>
            <p class="text-muted mb-0">Make sure you are absolutely sure before permanently deleting this item.</p>
        </div>
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
        <div class="card border-0 shadow-sm h-100 border-accent-danger">
            <div class="card-body p-4">
                <h2 class="h5 fw-semibold text-danger mb-3"><i class="bi bi-file-earmark-text me-2"></i>Item Summary</h2>
                <?php if ($successMessage === ''): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>Deletion is permanent and cannot be recovered.
                    </div>
                <?php endif; ?>

                <dl class="row text-muted small mb-4">
                    <dt class="col-5">Name</dt>
                    <dd class="col-7 text-dark fw-semibold"><i class="bi bi-box-seam me-1"></i><?= escape($item['name']) ?></dd>

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

                    <dt class="col-5">Email</dt>
                    <dd class="col-7 text-dark">
                        <?php if ($item['email'] !== ''): ?>
                            <a href="mailto:<?= escape($item['email']) ?>" class="link-danger text-decoration-none">
                                <i class="bi bi-envelope me-1"></i><?= escape($item['email']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-5">Phone</dt>
                    <dd class="col-7 text-dark">
                        <?php if ($item['phone'] !== ''):
                            $phoneHref = preg_replace('/[^0-9+]/', '', $item['phone']);
                        ?>
                            <a href="tel:<?= escape($phoneHref) ?>" class="link-danger text-decoration-none">
                                <i class="bi bi-telephone me-1"></i><?= escape($item['phone']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-5">Description</dt>
                    <dd class="col-7 text-dark">
                        <?php if ($item['description'] !== ''): ?>
                            <div class="text-muted"><?= nl2br(escape($item['description'])) ?></div>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </dd>
                </dl>

                <form method="POST" action="<?= htmlspecialchars(base_url('?route=item/delete&id=' . $id), ENT_QUOTES, 'UTF-8'); ?>" class="d-flex flex-wrap gap-2 pt-3 border-top">
                    <?php if ($successMessage === ''): ?>
                        <input type="hidden" name="confirm" value="yes">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Yes, Delete This Item
                        </button>
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars(base_url('?route=item/index'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                    <a href="<?= htmlspecialchars(base_url('?route=item/edit&id=' . (int)$item['id']), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-pencil-square me-1"></i>Edit Item
                    </a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100 border-accent-danger">
            <div class="card-body p-4">
                <h3 class="h6 fw-semibold text-danger mb-3"><i class="bi bi-shield-lock me-2"></i>Security Note</h3>
                <ul class="list-unstyled text-muted small d-grid gap-2 mb-0">
                    <li class="d-flex gap-2 align-items-start">
                        <i class="bi bi-check2-circle text-success"></i>
                        <span>Confirmation is required to prevent accidental deletion.</span>
                    </li>
                    <li class="d-flex gap-2 align-items-start">
                        <i class="bi bi-archive text-warning"></i>
                        <span>Deleted data cannot be recovered, backup if necessary.</span>
                    </li>
                    <li class="d-flex gap-2 align-items-start">
                        <i class="bi bi-eye text-primary"></i>
                        <span>Double-check the item name and details before pressing the delete button.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
renderLayoutFooter();
?>
