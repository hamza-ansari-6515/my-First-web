<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$id = intval($_GET['id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    header('Location: categories.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete Category</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section" style="max-width:400px;margin-top:60px;">
  <h2 class="admin-title">Delete Category?</h2>
  <form method="POST" onsubmit="return confirm('Do you really want to delete this category?');">
    <button class="admin-actions-btn cancel" style="width:100%;">Delete</button>
  </form>
  <a href="categories.php" class="admin-actions-btn" style="margin-top:18px;display:block;">Cancel</a>
</div>
</body>
</html>
