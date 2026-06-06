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

$databasePath = config('db_path');
$databaseDir = dirname($databasePath);

if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0775, true);
}

if (!file_exists($databasePath)) {
    $db = new SQLite3($databasePath);
    $db->exec('PRAGMA foreign_keys = ON');

    $db->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            type TEXT NOT NULL,
            description TEXT,
            category TEXT,
            amount INTEGER DEFAULT 0,
            email TEXT,
            phone TEXT,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    SQL);

    $sampleItems = [
        ['Gaming Laptop', 'Electronics', 'High-performance gaming laptop with RTX graphics', 'Computer', 15000000, 'admin@example.com', '08123456789'],
        ['Wireless Mouse', 'Accessories', 'Ergonomic wireless mouse with precision tracking', 'Peripheral', 250000, 'admin@example.com', '08123456789'],
        ['Mechanical Keyboard', 'Accessories', 'RGB mechanical keyboard with blue switches', 'Peripheral', 800000, 'admin@example.com', '08123456789'],
        ['Premium Coffee', 'Beverage', 'Premium quality arabica coffee beans', 'Food & Drink', 50000, 'coffee@example.com', '08198765432'],
        ['Office Chair', 'Furniture', 'Ergonomic office chair with lumbar support', 'Office', 1200000, 'office@example.com', '08111222333']
    ];

    $stmt = $db->prepare('INSERT INTO items (name, type, description, category, amount, email, phone) VALUES (:name, :type, :description, :category, :amount, :email, :phone)');
    foreach ($sampleItems as $item) {
        $stmt->bindValue(':name', $item[0], SQLITE3_TEXT);
        $stmt->bindValue(':type', $item[1], SQLITE3_TEXT);
        $stmt->bindValue(':description', $item[2], SQLITE3_TEXT);
        $stmt->bindValue(':category', $item[3], SQLITE3_TEXT);
        $stmt->bindValue(':amount', (int) $item[4], SQLITE3_INTEGER);
        $stmt->bindValue(':email', $item[5], SQLITE3_TEXT);
        $stmt->bindValue(':phone', $item[6], SQLITE3_TEXT);
        $stmt->execute();
    }
    $stmt->close();

    $db->close();
}
