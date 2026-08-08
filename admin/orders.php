<?php require "auth.php";
$list=db()->query("SELECT * FROM orders ORDER BY id DESC LIMIT 500")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>订单</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="a"><div class="c"><h1>后台</h1><nav><a href="index.php">控制台</a><a href="products.php">商品</a><a href="cards.php">卡密</a><a href="orders.php">订单</a><a href="logout.php">退出</a></nav></div></header>
<main class="c">
<h2>订单列表</h2>
<table><tr><th>订单号</th><th>商品</th><th>金额</th><th>卡密</th><th>时间</th></tr>
<?php foreach($list as $o){ ?>
<tr><td><?=h($o["order_no"])?></td><td><?=h($o["product_name"])?></td><td>$<?=number_format($o["price"],2)?></td><td class="m"><?=h($o["card_content"])?></td><td><?=h($o["created_at"])?></td></tr>
<?php } ?>
</table></main></body></html>
