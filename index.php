<?php require "config.php";
$ps = db()->query("SELECT p.*,(SELECT COUNT(*) FROM cards WHERE product_id=p.id AND sold=0) s FROM products p ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=SITE_NAME?></title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<header><div class="c"><h1><?=SITE_NAME?></h1><nav><a href="index.php">首页</a> <a href="order.php">查订单</a> <a href="admin/">后台</a></nav></div></header>
<main class="c">
<h2>商品列表</h2>
<?php if(!$ps){echo '<div class="empty">暂无商品，请登录后台添加</div>';}else{ ?>
<div class="g">
<?php foreach($ps as $p){ ?>
<div class="card"><h3><?=h($p["name"])?></h3><p class="price">$<?=number_format($p["price"],2)?></p><p class="desc"><?=h($p["description"])?></p><p class="st">库存 <b><?=$p["s"]?></b></p>
<form method="post" action="buy.php"><input type="hidden" name="id" value="<?=$p["id"]?>"><button class="btn" <?=$p["s"]<=0?"disabled":""?>><?=$p["s"]<=0?"缺货":"购买"?></button></form>
</div>
<?php } ?>
</div>
<?php } ?>
</main>
<footer><div class="c">&copy; <?=date("Y")?> <?=SITE_NAME?></div></footer>
</body></html>
