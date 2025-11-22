<?php
session_start(); include 'db.php';
if(!isset($_SESSION['deliveryboy'])){ header('Location: login.php'); exit(); }
$boy_id = $_SESSION['deliveryboy'];
$duser = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM deliveryboys WHERE id=$boy_id"));
?>
<!DOCTYPE html>
<html><head><title>Profile</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav class="gradient-header">
    <span class="brand-name">Delivery Profile</span>
    <a href="logout.php" class="logout-btn">Logout</a>
</nav>
<div class="section" style="max-width:400px;">
  <h2>Profile</h2>
  <div><b>Name:</b> <?= htmlspecialchars($duser['name']) ?></div>
  <div><b>Mobile:</b> <?= htmlspecialchars($duser['mobile']) ?></div>
  <div><b>Email:</b> <?= htmlspecialchars($duser['email']) ?></div>
</div>
</body>
</html>
