<?php require "config.php";
if($_SERVER["REQUEST_METHOD"]!="POST"||empty($_POST["id"]))go("index.php");
$pid=intval($_POST["id"]);
$p=db()->query("SELECT * FROM products WHERE id=$pid")->fetch(PDO::FETCH_ASSOC);
if(!$p)go("index.php");
$c=db()->query("SELECT * FROM cards WHERE product_id=$pid AND sold=0 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if(!$c){go("index.php");}
$o=ono();$d=db();$d->beginTransaction();
$st=$d->prepare("INSERT INTO orders(order_no,product_id,product_name,price,card_content,status)VALUES(?,?,?,?,?,1)");
$st->execute([$o,$pid,$p["name"],$p["price"],$c["content"]]);
$oid=$d->lastInsertId();
$d->exec("UPDATE cards SET sold=1,order_id=$oid WHERE id={$c["id"]}");
$d->commit();
go("success.php?o=$o");
