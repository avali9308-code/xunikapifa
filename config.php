<?php
session_start();
date_default_timezone_set("Asia/Phnom_Penh");
define("DB_PATH", __DIR__ . "/data/shop.db");
define("ADMIN_USER", "tianyou1");
define("ADMIN_PASS", "tianyou123");
define("SITE_NAME", "自动售货系统");
function db() {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO("sqlite:" . DB_PATH);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}
function init_db() {
    if (!file_exists(DB_PATH)) {
        $d = db();
        $d->exec("CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT,name TEXT NOT NULL,price REAL NOT NULL DEFAULT 0,description TEXT,created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
        $d->exec("CREATE TABLE cards (id INTEGER PRIMARY KEY AUTOINCREMENT,product_id INTEGER NOT NULL,content TEXT NOT NULL,sold INTEGER NOT NULL DEFAULT 0,order_id INTEGER,created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
        $d->exec("CREATE TABLE orders (id INTEGER PRIMARY KEY AUTOINCREMENT,order_no TEXT UNIQUE NOT NULL,product_id INTEGER NOT NULL,product_name TEXT NOT NULL,price REAL NOT NULL,card_content TEXT,status INTEGER NOT NULL DEFAULT 0,created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
        @chmod(DB_PATH, 0666);
    }
}
function init_db() {
    $dbFile = DB_PATH;
    $needsTables = false;

    // 数据库文件不存在 → 需要新建
    if (!file_exists($dbFile)) {
        $needsTables = true;
    } else {
        // 文件存在但为空 → 也需要建表
        if (filesize($dbFile) == 0) {
            $needsTables = true;
            // 删掉空文件，让 PDO 重新干净地创建
            @unlink($dbFile);
        }
    }

    if ($needsTables) {
        try {
            $d = db();
            // 商品表
            $d->exec("CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                price REAL NOT NULL DEFAULT 0,
                description TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            // 卡密表
            $d->exec("CREATE TABLE IF NOT EXISTS cards (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                code TEXT NOT NULL,
                status INTEGER DEFAULT 0,
                order_no TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            // 订单表
            $d->exec("CREATE TABLE IF NOT EXISTS orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_no TEXT UNIQUE NOT NULL,
                product_id INTEGER NOT NULL,
                product_name TEXT NOT NULL,
                price REAL NOT NULL,
                email TEXT DEFAULT '',
                code TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            @chmod($dbFile, 0666);
        } catch (Exception $e) {
            die("建表失败：" . $e->getMessage());
        }
    }
}
