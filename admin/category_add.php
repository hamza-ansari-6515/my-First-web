<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $name=$_POST['name'];
  mysqli_query($conn,"INSERT INTO categories (name) VALUES ('$name')");
  header('Location: categories.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Category</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section" style="max-width:400px;">
  <h2 class="admin-title">Add Category</h2>
  <form method="POST" style="display:flex;flex-direction:column;gap:17px;">
    <input name="name" class="search-input" placeholder="Name" required>
    <button class="admin-actions-btn" style="width:100%;">Add Category</button>
  </form>
</div>
</body>
</html>
