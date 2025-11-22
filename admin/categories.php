<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$res = mysqli_query($conn,"SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Categories</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="admin-header"><span class="brand">Admin Panel</span><a href="dashboard.php">Dashboard</a></nav>
<div class="admin-section">
  <h2 class="admin-title">Categories</h2>
  <a href="category_add.php" class="admin-actions-btn" style="margin-bottom:12px;display:inline-block;">+ Add Category</a>
  <table class="table-orders">
    <thead>
      <tr><th>ID</th><th>Name</th><th>Edit</th><th>Delete</th></tr>
    </thead>
    <tbody>
      <?php while($c=mysqli_fetch_assoc($res)){ ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><a href="category_edit.php?id=<?= $c['id'] ?>" class="admin-actions-btn">Edit</a></td>
        <td><a href="category_del.php?id=<?= $c['id'] ?>" class="admin-actions-btn cancel">Delete</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
