<?php
// 强制显示所有错误
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
date_default_timezone_set("Asia/Phnom_Penh");

// 自动创建 data 目录
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
    chmod($dataDir, 0777);
}

define("DB_PATH", $dataDir . "/shop.db");
define("ADMIN_USER", "tianyout");       // 你的账号
define("ADMIN_PASS", "tianyou123");    // 你的密码
define("SITE_NAME", "自动售货系统");

function db() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO("sqlite:" . DB_PATH);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("数据库连接失败：" . $e->getMessage());
        }
    }
    return $pdo;
}

function init_db() {
    $dbFile = DB_PATH;
    $needsTables = false;

    if (!file_exists($dbFile)) {
        $needsTables = true;
    } else {
        if (filesize($dbFile) == 0) {
            $needsTables = true;
            @unlink($dbFile);
        }
    }

    if ($needsTables) {
        try {
            $d = db();
            $d->exec("CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                price REAL NOT NULL DEFAULT 0,
                description TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            $d->exec("CREATE TABLE IF NOT EXISTS cards (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                code TEXT NOT NULL,
                status INTEGER DEFAULT 0,
                order_no TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
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

init_db();

function h($s){return htmlspecialchars($s,ENT_QUOTES,"UTF-8");}
function go($u){header("Location: ".$u);exit;}
function is_admin(){return !empty($_SESSION["admin"]);}
function ono(){return date("YmdHis").str_pad(mt_rand(1,9999),4,"0",STR_PAD_LEFT);}
