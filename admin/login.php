<?php
session_start();
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'] ?? ''; $pass = $_POST['pass'] ?? '';
    if ($user == 'admin' && $pass == 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login | CLOTHES</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    body { background: linear-gradient(120deg,#232a3a 70%,#42b0ee 130%);}
    .admin-login-card {
      max-width:420px; margin:70px auto; background:var(--card-bg); padding:42px 42px 30px 42px;
      border-radius: 16px; box-shadow:0 7px 26px #0148;
      text-align:center;
    }
    .admin-title {font-size:2rem;color:var(--accent2);margin-bottom:29px;}
    .login-input {font-size:1.1rem;padding:15px;border-radius:9px;border:none;background:#121319;color:#fff;margin-bottom:22px;width:96%;}
    .login-btn {background:var(--accent);color:#232a37;font-weight:700;font-size:1.04rem;padding:13px 0;border-radius:9px;width:98%;box-shadow:0 2px 8px #cb3;transition:background .17s;}
    .login-btn:hover {background:var(--accent2);color:#fff;}
    .error-box{background:var(--error);color:#fff;border-radius:8px;padding:10px;margin-bottom:18px;}
    @media (max-width:600px) {.admin-login-card{max-width:95vw;padding:15vw 2vw 6vw 2vw;}}
  </style>
</head>
<body>
<div class="admin-login-card">
  <h2 class="admin-title">Admin Login</h2>
  <?php if (!empty($error)) echo "<div class='error-box'>$error</div>"; ?>
  <form method="POST" style="margin-top:14px;">
    <input type="text" name="user" class="login-input" placeholder="Username" required>
    <input type="password" name="pass" class="login-input" placeholder="Password" required>
    <button class="login-btn">Login</button>
  </form>
</div>
</body>
</html>
