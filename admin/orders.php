<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$status = $_GET['type'] ?? 'Pending';
$where = "status='$status'";
$search = trim($_GET['q'] ?? '');
$addsearch = $search ? " AND (address LIKE '%$search%' OR mobile LIKE '%$search%' OR id='$search')" : "";
$res = mysqli_query($conn,"SELECT * FROM orders WHERE $where $addsearch ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Orders | CLOTHES</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    .admin-tabs {display:flex;gap:14px;margin-bottom:20px;}
    .admin-tab {background:#232a37;color:#eabf4d;border-radius:7px;padding:6px 18px;cursor:pointer;font-weight:600;text-decoration:none;}
    .admin-tab.active {background:#eabf4d;color:#232a37;}
  </style>
</head>
<body>
<button onclick="location.href='dashboard.php'" class="back-arrow">&#8678;</button>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section">
  <h2 class="admin-title">Orders</h2>
  <div class="admin-tabs">
    <a href="?type=Pending" class="admin-tab <?= $status=='Pending'?'active':'' ?>">Pending</a>
    <a href="?type=Approved" class="admin-tab <?= $status=='Approved'?'active':'' ?>">Approved</a>
    <a href="?type=Assigned" class="admin-tab <?= $status=='Assigned'?'active':'' ?>">Assigned</a>
    <a href="?type=Delivered" class="admin-tab <?= $status=='Delivered'?'active':'' ?>">Delivered</a>
  </div>
  <form style="margin-bottom:18px;">
    <input class="search-input" name="q" type="search" placeholder="Search address, mobile, order id" value="<?= htmlspecialchars($search) ?>">
    <button class="admin-actions-btn">Search</button>
  </form>
  <table class="table-orders">
    <thead>
      <tr>
        <th>ID</th><th>User</th><th>Product</th><th>Qty</th><th>Size</th><th>Address</th><th>Mobile</th><th>Status</th>
        <?php if($status=='Pending'||$status=='Approved'){ ?><th>Actions</th><?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php while($o=mysqli_fetch_assoc($res)){
        $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT name,mobile FROM users WHERE id={$o['user_id']}"));
        $prod = mysqli_fetch_assoc(mysqli_query($conn,"SELECT name FROM products WHERE id={$o['product_id']}"));
      ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= htmlspecialchars($user['name'] ?? '') ?></td>
        <td><?= htmlspecialchars($prod['name'] ?? '') ?></td>
        <td><?= $o['quantity'] ?></td>
        <td><?= htmlspecialchars($o['size']) ?></td>
        <td><?= htmlspecialchars($o['address']) ?></td>
        <td><?= htmlspecialchars($o['mobile']) ?></td>
        <td><?= $o['status'] ?></td>
        <?php if($status=='Pending'){ ?>
          <td>
            <form method="POST" action="order_update.php" style="display:flex;gap:3px;">
              <input type="hidden" name="id" value="<?= $o['id'] ?>">
              <select name="status">
                <option <?= $o['status']=='Pending'?'selected':'' ?>>Pending</option>
                <option <?= $o['status']=='Approved'?'selected':'' ?>>Approved</option>
              </select>
              <button class="admin-actions-btn">Update</button>
            </form>
          </td>
        <?php } elseif($status=='Approved'){ ?>
          <td>
            <form method="POST" action="order_assign.php" style="margin-top:3px;">
              <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
              <button class="admin-actions-btn" style="background:var(--accent2);color:#232;">Assign Delivery</button>
            </form>
          </td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
