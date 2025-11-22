<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$id=intval($_GET['id']);
$p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE id=$id"));
$cats = mysqli_query($conn,"SELECT * FROM categories");
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $name=$_POST['name'];$price=$_POST['price'];$stock=$_POST['stock'];$size=$_POST['size'];
    $cat=$_POST['category_id'];
    $color=$_POST['color'];$desc=$_POST['description'];$img=$_POST['image1'];
    mysqli_query($conn,"UPDATE products SET name='$name',price='$price',stock='$stock',size='$size',category_id='$cat',color='$color',description='$desc',image1='$img' WHERE id=$id");
    header('Location: products.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section" style="max-width:600px;">
  <h2 class="admin-title">Edit Product</h2>
  <form method="POST" style="display:flex;flex-direction:column;gap:14px;">
    <input name="name" class="search-input" value="<?= $p['name'] ?>" required>
    <input name="price" type="number" class="search-input" value="<?= $p['price'] ?>" required>
    <select name="category_id" class="search-input" required>
      <?php while($cat=mysqli_fetch_assoc($cats)){ ?>
        <option value="<?= $cat['id'] ?>" <?= $p['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
      <?php } ?>
    </select>
    <input name="stock" type="number" class="search-input" value="<?= $p['stock'] ?>" required>
    <input name="size" class="search-input" value="<?= $p['size'] ?>">
    <input name="color" class="search-input" value="<?= $p['color'] ?>">
    <textarea name="description" class="search-input"><?= $p['description'] ?></textarea>
    <input name="image1" class="search-input" value="<?= $p['image1'] ?>">
    <button class="admin-actions-btn" style="width:100%;">Update Product</button>
  </form>
</div>
</body>
</html>
