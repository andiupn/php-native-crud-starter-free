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
 * Partial form item.
 * Expected variables:
 * - $formData (array)
 * - $typeOptions (array)
 */
?>
<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="<?= escape($formData['name'] ?? '') ?>" placeholder="e.g. Gaming Laptop" required>
    </div>
    <div class="col-md-6">
        <label for="type" class="form-label">Item Type <span class="text-danger">*</span></label>
        <select class="form-select" id="type" name="type" required>
            <option value="">-- Select Type --</option>
            <?php foreach ($typeOptions as $option): ?>
                <option value="<?= escape($option) ?>" <?= ($formData['type'] ?? '') === $option ? 'selected' : '' ?>><?= escape($option) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="category" class="form-label">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="<?= escape($formData['category'] ?? '') ?>" placeholder="Category (optional)">
    </div>
    <div class="col-md-6">
        <label for="amount" class="form-label">Amount (Rp)</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" class="form-control" id="amount" name="amount" value="<?= escape($formData['amount'] ?? '') ?>" min="0" placeholder="0">
        </div>
        <small class="text-muted">Enter 0 if no amount.</small>
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= escape($formData['email'] ?? '') ?>" placeholder="name@domain.com">
    </div>
    <div class="col-md-6">
        <label for="phone" class="form-label">Phone</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?= escape($formData['phone'] ?? '') ?>" placeholder="08123456789">
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Write detailed description (optional)"><?= escape($formData['description'] ?? '') ?></textarea>
        <small class="text-muted">Maximum 500 characters.</small>
    </div>
</div>
