<?php require __DIR__ . "/../config.php"; if(!is_admin()) go("login.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>控制台 - 后台管理</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.dash{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-top:20px}
.box{background:#fff;padding:24px;border-radius:10px;text-align:center;box-shadow:0 2px 6px rgba(0,0,0,.06)}
.box .num{font-size:32px;font-weight:bold;color:#4f46e5;margin-bottom:8px}
.box .lab{color:#666;font-size:14px}
</style>
</head>
<body>
<nav class="admin-nav">
  <div class="wrap">
    <strong>后台管理</strong>
    <a href="index.php" class="on">控制台</a>
    <a href="products.php">商品</a>
    <a href="cards.php">卡密</a>
    <a href="orders.php">订单</a>
    <a href="login.php?act=logout" style="float:right">退出</a>
  </div>
</nav>
<div class="wrap">
  <h2>欢迎回来</h2>
  <div class="dash">
    <div class="box">
      <div class="num"><?php echo db()->query("SELECT COUNT(*) FROM products")->fetchColumn(); ?></div>
      <div class="lab">商品总数</div>
    </div>
    <div class="box">
      <div class="num"><?php echo db()->query("SELECT COUNT(*) FROM cards WHERE status=0")->fetchColumn(); ?></div>
      <div class="lab">可用卡密</div>
    </div>
    <div class="box">
      <div class="num"><?php echo db()->query("SELECT COUNT(*) FROM orders")->fetchColumn(); ?></div>
      <div class="lab">订单总数</div>
    </div>
    <div class="box">
      <div class="num">¥ <?php echo number_format(db()->query("SELECT SUM(price) FROM orders")->fetchColumn(),2); ?></div>
      <div class="lab">销售总额</div>
    </div>
  </div>
</div>
</body>
</html>
