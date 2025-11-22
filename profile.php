<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user_id = intval($_SESSION['user']);
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Profile | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .nav-btns { display: flex; gap:15px; margin-bottom: 23px;}
        .nav-btn { background: #eabf4d; color: #232a37; font-weight: 700; border-radius: 7px; padding: 7px 18px; border:none; cursor:pointer; box-shadow:0 2px 10px #cb3;}
    </style>
</head>
<body>
<nav class="gradient-header">
    <div class="logo-area">
        <img src="logo.png" class="logo" alt="Logo">
        <span class="brand-name">CLOTHES</span>
    </div>
    <div class="nav-right">
        <a href="logout.php" class="explore-btn" style="float:right;">Logout</a>
    </div>
</nav>
<div class="section" style="max-width:500px;">
    <div class="nav-btns">
        <button class="nav-btn" onclick="location.href='index.php'">&#8678; Home</button>
        <button class="nav-btn" onclick="location.href='orders.php'">Your Orders</button>
    </div>
    <h2 class="section-title">Your Profile</h2>
    <div><b>Name:</b> <?= isset($user['name']) ? htmlspecialchars($user['name']) : "Not found" ?></div>
    <div><b>Email:</b> <?= isset($user['email']) ? htmlspecialchars($user['email']) : "Not found" ?></div>
    <div><b>Mobile:</b> <?= isset($user['mobile']) ? htmlspecialchars($user['mobile']) : "Not found" ?></div>
</div>
</body>
</html>
