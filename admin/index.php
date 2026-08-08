<?php require "auth.php";
$d=db();$st=[
    "p"=>$d->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    "c"=>$d->query("SELECT COUNT(*) FROM cards")->fetchColumn(),
    "s"=>$d->query("SELECT COUNT(*) FROM cards WHERE sold=1")->fetchColumn(),
    "o"=>$d->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    "a"=>$d->query("SELECT COALESCE(SUM(price),0) FROM orders WHERE status=1")->fetchColumn(),
];
$os=$d->query("SELECT * FROM orders ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>控制台</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="a"><div class="c"><h1>后台</h1><nav><a href="index.php">控制台</a><a href="products.php">商品</a><a href="cards.php">卡密</a><a href="orders.php">订单</a><a href="../">前台</a><a href="logout.php">退出</a></nav></div></header>
<main class="c">
<div class="g s">
<div class="card"><p>商品</p><h3><?=$st["p"]?></h3></div>
<div class="card"><p>卡密</p><h3><?=$st["c"]?></h3></div>
<div class="card"><p>已售</p><h3><?=$st["s"]?></h3></div>
<div class="card"><p>订单</p><h3><?=$st["o"]?></h3></div>
<div class="card"><p>销售</p><h3>$<?=number_format($st["a"],2)?></h3></div>
</div>
<h3>最近订单</h3>
<table><tr><th>订单号</th><th>商品</th><th>金额</th><th>时间</th></tr>
<?php foreach($os as $x){echo "<tr><td>".h($x["order_no"])."</td><td>".h($x["product_name"])."</td><td>$".number_format($x["price"],2)."</td><td>".h($x["created_at"])."</td></tr>";} ?>
</table>
</main></body></html>
