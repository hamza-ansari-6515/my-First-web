<?php
session_start(); include 'db.php';
if(!isset($_SESSION['deliveryboy'])){ header('Location: login.php'); exit(); }
$boy_id = $_SESSION['deliveryboy'];
$duser = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM deliveryboys WHERE id=$boy_id"));
?>
<!DOCTYPE html>
<html><head><title>Delivered History</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav class="gradient-header">
    <span class="brand-name">Delivered Orders (<?=htmlspecialchars($duser['name'])?>)</span>
    <a href="dashboard.php" class="explore-btn" style="float:right;">Back</a>
</nav>
<div class="section">
  <?php
  $orders = mysqli_query($conn,"SELECT * FROM orders WHERE status='Delivered' AND deliveryboy_id=$boy_id");
  ?>
  <table>
    <thead><tr><th>ID</th><th>Product</th><th>User</th><th>Address</th><th>Delivered At</th></tr></thead>
    <tbody>
    <?php while($o=mysqli_fetch_assoc($orders)){
      $prod = mysqli_fetch_assoc(mysqli_query($conn,"SELECT name FROM products WHERE id={$o['product_id']}"));
      $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT name FROM users WHERE id={$o['user_id']}"));
      ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= htmlspecialchars($prod['name']) ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($o['address']) ?></td>
        <td><?= htmlspecialchars($o['updated_at'] ?? '-') ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
