<?php
require __DIR__ . "/../config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $u = trim($_POST["username"] ?? "");
    $p = trim($_POST["password"] ?? "");

    // ✅ 自动读取 config.php 里的账号密码，不显示给任何人
    if ($u === ADMIN_USER && $p === ADMIN_PASS) {
        $_SESSION["admin"] = true;
        go("index.php");
    } else {
        $error = "❌ 账号或密码错误！";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>后台登录</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{background:#f5f7fa;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh}
.box{background:#fff;padding:30px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);width:100%;max-width:360px}
h2{text-align:center;margin-bottom:24px;color:#222}
.err{background:#fee;padding:10px;border-radius:6px;color:#c53030;margin-bottom:16px;text-align:center}
input{display:block;width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;margin-bottom:16px;font-size:15px}
button{width:100%;padding:12px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:16px;cursor:pointer;border-radius:8px}
button:hover{background:#4338ca}
</style>
</head>
<body>
<div class="box">
  <h2>🔐 后台登录</h2>
  <?php if ($error): ?><div class="err"><?php echo $error; ?></div><?php endif; ?>
  <form method="post">
    <input type="text" name="username" placeholder="请输入账号" required>
    <input type="password" name="password" placeholder="请输入密码" required>
    <button type="submit">登录</button>
  </form>
</div>
</body>
</html>
