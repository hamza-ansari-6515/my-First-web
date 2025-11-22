<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$id=intval($_GET['id']);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $name=$_POST['name'];
    $photo=$_POST['photo_url'];
    mysqli_query($conn,"UPDATE categories SET name='$name',photo_url='$photo' WHERE id=$id");
    header('Location: categories.php');
}
$cat = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM categories WHERE id=$id"));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Category | Admin</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section" style="max-width:400px;">
  <h2 class="admin-title">Edit Category</h2>
  <form method="POST" style="display:flex;flex-direction:column;gap:15px;">
    <input name="name" class="search-input" value="<?= $cat['name']?>" required>
    <input name="photo_url" class="search-input" value="<?= $cat['photo_url']?>" required>
    <button class="admin-actions-btn" style="width:100%;">Update Category</button>
  </form>
</div>
</body>
</html>
