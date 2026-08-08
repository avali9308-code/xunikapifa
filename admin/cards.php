<?php require "auth.php";$d=db();
$pid=isset($_GET["pid"])?intval($_GET["pid"]):0;
$ps=$d->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
if(!empty($_POST["ac"])&&$pid){
    $ls=array_filter(array_map("trim",explode("
",$_POST["ct"])));
    $s=$d->prepare("INSERT INTO cards(product_id,content)VALUES(?,?)");
    foreach($ls as $x)if($x)$s->execute([$pid,$x]);
    header("Location: cards.php?pid=$pid");exit;
}
$ww=$pid?"WHERE product_id=$pid":"";
$list=$d->query("SELECT c.*,p.name pn FROM cards c LEFT JOIN products p ON p.id=c.product_id $ww ORDER BY c.id DESC LIMIT 500")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>卡密</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="a"><div class="c"><h1>后台</h1><nav><a href="index.php">控制台</a><a href="products.php">商品</a><a href="cards.php">卡密</a><a href="orders.php">订单</a><a href="logout.php">退出</a></nav></div></header>
<main class="c">
<h2>选择商品</h2>
<div class="fl"><a href="cards.php" class="btn sm <?=$pid==0?"on":""?>">全部</a>
<?php foreach($ps as $x){echo '<a href="?pid='.$x["id"].'" class="btn sm '.($pid==$x["id"]?"on":"").'">'.h($x["name"]).'</a> ';} ?>
</div>
<?php if($pid){ ?>
<h3>批量加卡密（每行一个）</h3>
<form method="post" class="f"><textarea name="ct" rows="6" placeholder="一行一个" required></textarea><button class="btn" name="ac">导入</button></form>
<?php } ?>
<h2>卡密列表</h2>
<table><tr><th>ID</th><th>商品</th><th>内容</th><th>状态</th><th>时间</th></tr>
<?php foreach($list as $cc){ ?>
<tr><td><?=$cc["id"]?></td><td><?=h($cc["pn"])?></td><td class="m"><?=h($cc["content"])?></td><td><?=$cc["sold"]?'<span class=no>已售</span>':'<span class=ok>未售</span>'?></td><td><?=h($cc["created_at"])?></td></tr>
<?php } ?>
</table></main></body></html>
