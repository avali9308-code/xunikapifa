<?php require "config.php";
$r=null;
if(!empty($_POST["o"])){$r=db()->query("SELECT * FROM orders WHERE order_no="".h($_POST["o"]).""")->fetch(PDO::FETCH_ASSOC);}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>查订单</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<header><div class="c"><h1><?=SITE_NAME?></h1><nav><a href="index.php">首页</a> <a href="admin/">后台</a></nav></div></header>
<main class="c">
<h2>订单查询</h2>
<form method="post" class="f"><input name="o" placeholder="输入订单号" required><button class="btn">查询</button></form>
<?php if($_POST&&!$r){echo '<div class="e">未找到</div>';}
if($r){ ?>
<div class="card"><p>订单号：<?=h($r["order_no"])?></p><p>商品：<?=h($r["product_name"])?></p><p>金额：$<?=number_format($r["price"],2)?></p><p>卡密：</p><div class="code"><?=h($r["card_content"])?></div></div>
<?php } ?>
</main></body></html>
