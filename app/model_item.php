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
 * Get all data from database.
 */
function getAllItems(): array
{
    $db = getDB();

    $result = $db->query('SELECT * FROM items ORDER BY name');
    if ($result === false) {
        return [];
    }

    $items = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $items[] = $row;
    }

    $result->finalize();

    return $items;
}

/**
 * Get unique item types from database.
 */
function getTypeOptions(): array
{
    $db = getDB();

    $result = $db->query('SELECT DISTINCT type FROM items WHERE type <> "" ORDER BY type COLLATE NOCASE');
    if ($result === false) {
        return [];
    }

    $options = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        if (!isset($row['type'])) {
            continue;
        }

        $options[] = (string) $row['type'];
    }

    $result->finalize();

    return $options;
}

/**
 * Default item type options when database has no data.
 */
function getDefaultTypeOptions(): array
{
    return ['Electronics', 'Accessories', 'Beverage', 'Other'];
}

/**
 * Merge type options from database and default, then clean them.
 */
function prepareTypeOptions(string $selectedType = ''): array
{
    $options = array_merge(getTypeOptions(), getDefaultTypeOptions());

    $selectedType = trim($selectedType);
    if ($selectedType !== '') {
        $options[] = $selectedType;
    }

    $options = array_map(static function ($option): string {
        return trim((string) $option);
    }, $options);

    $options = array_filter($options, static function ($option): bool {
        return $option !== '';
    });

    $seen = [];
    $normalized = [];
    foreach ($options as $option) {
        $lower = function_exists('mb_strtolower')
            ? mb_strtolower($option, 'UTF-8')
            : strtolower($option);

        if (isset($seen[$lower])) {
            continue;
        }

        $seen[$lower] = true;
        $normalized[] = $option;
    }

    natcasesort($normalized);

    return array_values($normalized);
}

/**
 * Get one item by ID.
 */
function getItemById(int $id): ?array
{
    $db = getDB();

    $stmt = $db->prepare('SELECT * FROM items WHERE id = :id');
    if ($stmt === false) {
        return null;
    }

    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($result === false) {
        $stmt->close();
        return null;
    }

    $item = $result->fetchArray(SQLITE3_ASSOC) ?: null;

    $result->finalize();
    $stmt->close();

    return $item;
}

/**
 * Add new item to database.
 */
function addItem(array $data): bool
{
    $db = getDB();

    $stmt = $db->prepare('INSERT INTO items (name, type, description, category, amount, email, phone)
        VALUES (:name, :type, :description, :category, :amount, :email, :phone)');

    if ($stmt === false) {
        return false;
    }

    $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
    $stmt->bindValue(':type', $data['type'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $data['description'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':category', $data['category'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':amount', (int) ($data['amount'] ?? 0), SQLITE3_INTEGER);
    $stmt->bindValue(':email', $data['email'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':phone', $data['phone'] ?? '', SQLITE3_TEXT);

    $result = $stmt->execute();
    $success = $result !== false;

    if ($result instanceof SQLite3Result) {
        $result->finalize();
    }

    $stmt->close();

    return $success;
}

/**
 * Update existing item.
 */
function updateItem(int $id, array $data): bool
{
    $db = getDB();

    $stmt = $db->prepare('UPDATE items SET
            name = :name,
            type = :type,
            description = :description,
            category = :category,
            amount = :amount,
            email = :email,
            phone = :phone
        WHERE id = :id');

    if ($stmt === false) {
        return false;
    }

    $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
    $stmt->bindValue(':type', $data['type'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $data['description'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':category', $data['category'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':amount', (int) ($data['amount'] ?? 0), SQLITE3_INTEGER);
    $stmt->bindValue(':email', $data['email'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':phone', $data['phone'] ?? '', SQLITE3_TEXT);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    $result = $stmt->execute();
    $success = $result !== false;

    if ($result instanceof SQLite3Result) {
        $result->finalize();
    }

    $stmt->close();

    return $success;
}

/**
 * Delete item from database.
 */
function deleteItem(int $id): bool
{
    $db = getDB();

    $stmt = $db->prepare('DELETE FROM items WHERE id = :id');

    if ($stmt === false) {
        return false;
    }

    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    $result = $stmt->execute();
    $success = $result !== false;

    if ($result instanceof SQLite3Result) {
        $result->finalize();
    }

    $stmt->close();

    return $success;
}

/**
 * Search items by keyword.
 */
function searchItems(string $keyword): array
{
    $db = getDB();

    $stmt = $db->prepare('SELECT * FROM items
        WHERE name LIKE :keyword
           OR type LIKE :keyword
           OR category LIKE :keyword
           OR description LIKE :keyword
        ORDER BY name');

    if ($stmt === false) {
        return [];
    }

    $stmt->bindValue(':keyword', '%' . $keyword . '%', SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result === false) {
        $stmt->close();
        return [];
    }

    $items = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $items[] = $row;
    }

    $result->finalize();
    $stmt->close();

    return $items;
}

/**
 * Simple input validation.
 */
function validateItemData(array $data): array
{
    $errors = [];

    if (empty(trim($data['name'] ?? ''))) {
        $errors[] = 'Item name is required';
    }

    if (empty(trim($data['type'] ?? ''))) {
        $errors[] = 'Item type is required';
    }

    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (isset($data['amount']) && $data['amount'] !== '' && $data['amount'] !== null) {
        if (!is_numeric($data['amount'])) {
            $errors[] = 'Amount must be a number';
        } elseif ((float) $data['amount'] < 0) {
            $errors[] = 'Amount cannot be negative';
        }
    }

    return [
        'valid'  => empty($errors),
        'errors' => $errors,
    ];
}

/**
 * Format currency to Rupiah.
 */
function formatRupiah(int $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
