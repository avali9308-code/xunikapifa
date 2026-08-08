<?php require "auth.php";$d=db();
if(!empty($_POST["add"])){$s=$d->prepare("INSERT INTO products(name,price,description)VALUES(?,?,?)");$s->execute([$_POST["n"],floatval($_POST["pr"]),$_POST["d"]]);go("products.php");}
if(!empty($_GET["del"])){$id=intval($_GET["del"]);$d->exec("DELETE FROM products WHERE id=$id");$d->exec("DELETE FROM cards WHERE product_id=$id");go("products.php");}
$list=$d->query("SELECT p.*,(SELECT COUNT(*) FROM cards WHERE product_id=p.id AND sold=0)s FROM products p ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>商品</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="a"><div class="c"><h1>后台</h1><nav><a href="index.php">控制台</a><a href="products.php">商品</a><a href="cards.php">卡密</a><a href="orders.php">订单</a><a href="logout.php">退出</a></nav></div></header>
<main class="c">
<h2>添加商品</h2>
<form method="post" class="f"><input name="n" placeholder="名称" required><input name="pr" type="number" step="0.01" placeholder="价格" required><input name="d" placeholder="描述"><button class="btn" name="add">添加</button></form>
<h2>列表</h2>
<table><tr><th>ID</th><th>名称</th><th>价格</th><th>库存</th><th>操作</th></tr>
<?php foreach($list as $p){ ?>
<tr><td><?=$p["id"]?></td><td><?=h($p["name"])?></td><td>$<?=number_format($p["price"],2)?></td><td><?=$p["s"]?></td>
<td><a href="cards.php?pid=<?=$p["id"]?>" class="btn sm">加卡密</a> <a href="?del=<?=$p["id"]?>" onclick="return confirm('删除？')" class="btn sm r">删</a></td></tr>
<?php } ?>
</table></main></body></html>
