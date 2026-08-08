<?php require "config.php";
$o=$_GET["o"]??"";$r=db()->query("SELECT * FROM orders WHERE order_no="".h($o).""")->fetch(PDO::FETCH_ASSOC);
if(!$r)go("index.php");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>成功</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<header><div class="c"><h1><?=SITE_NAME?></h1><nav><a href="index.php">返回</a></nav></div></header>
<main class="c"><div class="card ok">
<h2>购买成功</h2>
<p>订单号：<b><?=h($r["order_no"])?></b></p>
<p>商品：<?=h($r["product_name"])?></p>
<p>金额：$<?=number_format($r["price"],2)?></p>
<hr>
<p>卡密：</p>
<div class="code"><?=h($r["card_content"])?></div>
<p class="tip">请保存，可凭订单号再次查询</p>
<a href="index.php" class="btn">继续购买</a>
</div></main></body></html>
