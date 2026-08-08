<?php require __DIR__ . "/config.php"; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo h(SITE_NAME); ?></title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:#f5f7fa;color:#333;line-height:1.6}
.header{background:#fff;border-bottom:1px solid #eee;padding:18px 0}
.nav{max-width:1000px;margin:0 auto;padding:0 20px;text-align:right}
.nav a{color:#666;text-decoration:none;margin-left:20px}
.nav a:hover{color:#4f46e5}
.container{max-width:1000px;margin:30px auto;padding:0 20px}
h1{text-align:center;color:#222;margin-bottom:40px;font-size:28px}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px}
.card{background:#fff;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:.2s}
.card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1)}
.card h3{font-size:18px;margin-bottom:10px;color:#222}
.card .price{font-size:24px;color:#e53935;font-weight:bold;margin-bottom:12px}
.card .desc{color:#666;font-size:14px;margin-bottom:16px;min-height:40px}
.card .stock{font-size:13px;color:#888;margin-bottom:16px}
.card .btn{display:block;width:100%;text-align:center;background:#4f46e5;color:#fff;padding:10px;border-radius:8px;text-decoration:none;font-weight:500}
.card .btn:hover{background:#4338ca}
.empty{text-align:center;padding:60px 20px;color:#999;font-size:16px}
.footer{text-align:center;padding:30px;color:#aaa;font-size:13px;margin-top:40px}
</style>
</head>
<body>
<div class="header">
  <div class="nav">
    <a href="index.php">首页</a>
    <a href="order.php">查订单</a>
    <a href="admin/login.php">后台</a>
  </div>
</div>
<div class="container">
  <h1><?php echo h(SITE_NAME); ?></h1>
  <?php
  $products = db()->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
  if (!$products):
  ?>
  <div class="empty">暂无商品，请登录后台添加</div>
  <?php else: ?>
  <div class="grid">
    <?php foreach ($products as $p):
      $stock = db()->prepare("SELECT COUNT(*) FROM cards WHERE product_id=? AND status=0")->execute([$p["id"]]) ?: 0;
      $stock = db()->query("SELECT COUNT(*) FROM cards WHERE product_id={$p['id']} AND status=0")->fetchColumn();
    ?>
    <div class="card">
      <h3><?php echo h($p["name"]); ?></h3>
      <div class="price">¥ <?php echo number_format($p["price"],2); ?></div>
      <div class="desc"><?php echo h($p["description"]); ?></div>
      <div class="stock">库存：<?php echo $stock; ?> 件</div>
      <a href="buy.php?id=<?php echo $p["id"]; ?>" class="btn">立即购买</a>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<div class="footer">© <?php echo date("Y"); ?> <?php echo h(SITE_NAME); ?></div>
</body>
</html>
