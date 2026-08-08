<?php require "../config.php";
if(is_admin())go("index.php");$err="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
    if($_POST["u"]===ADMIN_USER&&$_POST["p"]===ADMIN_PASS){$_SESSION["admin"]=1;go("index.php");}
    else $err="账号密码错误";
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>登录</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body class="lg"><div class="lb">
<h2>后台登录</h2>
<?php if($err)echo '<div class="e">'.$err.'</div>';?>
<form method="post"><input name="u" placeholder="账号" required><input type="password" name="p" placeholder="密码" required><button class="btn w">登录</button></form>
<p class="tip">默认 admin / admin123</p>
</div></body></html>
