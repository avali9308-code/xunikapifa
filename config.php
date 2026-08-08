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
init_db();
function h($s){return htmlspecialchars($s,ENT_QUOTES,"UTF-8");}
function go($u){header("Location: $u");exit;}
function is_admin(){return !empty($_SESSION["admin"]);}
function ono(){return date("YmdHis").str_pad(mt_rand(1,9999),4,"0",STR_PAD_LEFT);}
