<?php
session_start();
include 'db.php';
$user_id = $_SESSION['user'] ?? 0;
if (!$user_id) { header('Location: login.php'); exit; }

$status = $_GET['type'] ?? 'Pending';
$where = $status == 'Delivered' 
    ? "user_id=$user_id AND status='Delivered'" 
    : "user_id=$user_id AND status='Pending'";

$orders = mysqli_query($conn, "SELECT o.*,p.name as pname FROM orders o LEFT JOIN products p ON o.product_id=p.id WHERE $where ORDER BY o.id DESC");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
  $oid = intval($_POST['cancel']);
  mysqli_query($conn,"UPDATE orders SET status='Cancelled' WHERE id=$oid AND user_id=$user_id");
  header('Location: orders.php?type=Pending'); exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Orders | CLOTHES</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .order-tabs {display:flex;gap:14px;margin-bottom:20px;}
    .order-tab {background:#232a37;color:#eabf4d;border-radius:7px;padding:6px 18px;cursor:pointer;font-weight:600;text-decoration:none;}
    .order-tab.active {background:#eabf4d;color:#232a37;}
  </style>
</head>
<body>
<nav class="gradient-header">
    <div class="logo-area">
        <img src="logo.png" class="logo" alt="Logo">
        <span class="brand-name">CLOTHES</span>
    </div>
</nav>
<div class="section" style="max-width:720px;">
  <div class="nav-btns" style="margin-bottom:18px;">
    <button class="nav-btn" onclick="location.href='index.php'">&#8678; Home</button>
    <button class="nav-btn" onclick="location.href='profile.php'">Profile</button>
  </div>
  <h2 class="section-title">Your Orders</h2>
  <div class="order-tabs">
    <a href="?type=Pending" class="order-tab <?= $status == 'Pending' ? 'active' : '' ?>">Pending</a>
    <a href="?type=Delivered" class="order-tab <?= $status == 'Delivered' ? 'active' : '' ?>">Delivered</a>
  </div>
  <table class="table-cart">
    <thead>
      <tr>
        <th>ID</th><th>Product</th><th>Qty</th><th>Size</th><th>Status</th><th>Cancel</th>
      </tr>
    </thead>
    <tbody>
      <?php while($o = mysqli_fetch_assoc($orders)){ ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= htmlspecialchars($o['pname']) ?></td>
          <td><?= $o['quantity'] ?></td>
          <td><?= htmlspecialchars($o['size']) ?></td>
          <td><?= $o['status'] ?></td>
          <td>
            <?php if($o['status'] != 'Cancelled' && $o['status'] == 'Pending'){ ?>
              <form method="POST" onsubmit="return confirmCancel();">
                <button name="cancel" value="<?= $o['id'] ?>" class="btn-delete">Cancel</button>
              </form>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<script>
function confirmCancel(){
  return confirm("Do you really want to cancel?");
}
</script>
</body>
</html>
