<?php
session_start();
include 'db.php';
$uid = $_SESSION['user'] ?? 0;
$where = "user_id=$uid";
$orders = mysqli_query($conn,"SELECT o.*,p.name as pname FROM orders o LEFT JOIN products p ON o.product_id=p.id WHERE $where ORDER BY o.id DESC");
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['cancel'])){
  $oid=intval($_POST['cancel']);
  mysqli_query($conn,"UPDATE orders SET status='Cancelled' WHERE id=$oid AND user_id=$uid");
  header('Location: your_orders.php'); exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Orders | CLOTHES</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="gradient-header"><span class="brand-name">CLOTHES</span></nav>
<div class="section">
  <h2 class="section-title">Your Orders</h2>
  <table class="table-cart">
    <thead>
      <tr><th>ID</th><th>Product</th><th>Qty</th><th>Size</th><th>Status</th><th>Cancel</th></tr>
    </thead>
    <tbody>
      <?php while($o=mysqli_fetch_assoc($orders)){ ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= htmlspecialchars($o['pname']) ?></td>
          <td><?= $o['quantity'] ?></td>
          <td><?= htmlspecialchars($o['size']) ?></td>
          <td><?= $o['status'] ?></td>
          <td>
            <?php if($o['status']!='Cancelled'){ ?>
              <form method="POST"><button name="cancel" value="<?= $o['id'] ?>" class="btn-delete">Cancel</button></form>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
