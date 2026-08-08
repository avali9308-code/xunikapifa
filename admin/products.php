<?php require __DIR__ . "/../config.php"; if(!is_admin()) go("login.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>商品管理 - 后台</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="admin-nav">
  <div class="wrap">
    <strong>后台</strong>
    <a href="index.php">控制台</a>
    <a href="products.php" class="on">商品</a>
    <a href="cards.php">卡密</a>
    <a href="orders.php">订单</a>
    <a href="logout.php" style="float:right">退出</a>
  </div>
</nav>
<div class="wrap">
  <h2>添加商品</h2>

  <?php
  // 处理添加
  if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["name"])) {
      try {
          $name = trim($_POST["name"]);
          $price = (float)$_POST["price"];
          $desc = trim($_POST["description"] ?? "");
          $stmt = db()->prepare("INSERT INTO products (name,price,description) VALUES (?,?,?)");
          $stmt->execute([$name, $price, $desc]);
          echo '<div class="ok">✅ 添加成功！商品：'.$name.'</div>';
      } catch (Exception $e) {
          echo '<div class="err">❌ 添加失败：'.$e->getMessage().'</div>';
      }
  }

  // 处理删除
  if (!empty($_GET["del"])) {
      try {
          db()->prepare("DELETE FROM products WHERE id=?")->execute([(int)$_GET["del"]]);
          db()->prepare("DELETE FROM cards WHERE product_id=?")->execute([(int)$_GET["del"]]);
          go("products.php");
      } catch (Exception $e) {
          echo '<div class="err">❌ 删除失败：'.$e->getMessage().'</div>';
      }
  }
  ?>

  <form method="post" class="form">
    <input name="name" required placeholder="商品名称（例：Netflix 会员 1 个月）">
    <input name="price" type="number" step="0.01" required placeholder="价格（例：20）" value="0">
    <textarea name="description" rows="3" placeholder="商品描述"></textarea>
    <button type="submit" class="btn">添加</button>
  </form>

  <h2>列表</h2>
  <table class="tbl">
    <thead><tr><th>ID</th><th>名称</th><th>价格</th><th>库存</th><th>操作</th></tr></thead>
    <tbody>
    <?php
    $rows = db()->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    if (!$rows) echo '<tr><td colspan="5" style="text-align:center;color:#999;padding:30px">暂无商品</td></tr>';
    foreach ($rows as $r) {
        $cnt = db()->prepare("SELECT COUNT(*) FROM cards WHERE product_id=? AND status=0")->execute([$r["id"]]) ?: 0;
        $cnt = db()->query("SELECT COUNT(*) FROM cards WHERE product_id={$r['id']} AND status=0")->fetchColumn();
        echo '<tr>
            <td>'.$r["id"].'</td>
            <td>'.h($r["name"]).'</td>
            <td>'.$r["price"].'</td>
            <td>'.$cnt.'</td>
            <td><a href="?del='.$r["id"].'" onclick="return confirm(\'确定删除？\')">删除</a></td>
        </tr>';
    }
    ?>
    </tbody>
  </table>
</div>
</body>
</html>
