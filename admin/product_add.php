<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $name=$_POST['name']; $price=$_POST['price']; $cat=$_POST['category_id'];
  $stock=$_POST['stock']; $size=$_POST['size']; $color=$_POST['color'];
  $desc=$_POST['description']; $image_urls = [];
  if (!empty($_POST['imageurls'])) foreach(explode(',', $_POST['imageurls']) as $url) $image_urls[] = trim($url);
  foreach ($_FILES['images']['tmp_name'] ?? [] as $k => $tmp) {
    if ($tmp && $_FILES['images']['error'][$k]==0) {
      if (!is_dir("../images")) mkdir("../images",0777,true);
      $filename = uniqid().basename($_FILES['images']['name'][$k]);
      $target = "../images/$filename";
      move_uploaded_file($tmp, $target);
      $image_urls[] = "images/$filename";
    }
  }
  $images = implode(',', $image_urls);
  mysqli_query($conn, "INSERT INTO products (name,price,category_id,stock,size,color,description,images)
    VALUES ('$name','$price','$cat','$stock','$size','$color','$desc','$images')");
  header('Location: products.php');
}
$cats = mysqli_query($conn,"SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section" style="max-width:600px;">
  <h2 class="admin-title">Add Product</h2>
  <form method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:15px;">
    <input name="name" class="search-input" placeholder="Name" required>
    <input name="price" type="number" class="search-input" placeholder="Price" required>
    <select name="category_id" class="search-input" required>
      <option value="">Category</option>
      <?php while($cat=mysqli_fetch_assoc($cats)){ echo "<option value='{$cat['id']}'>{$cat['name']}</option>"; } ?>
    </select>
    <input name="stock" type="number" class="search-input" placeholder="Stock" required>
    <input name="size" class="search-input" placeholder="Sizes (comma, eg: S,M,L)">
    <input name="color" class="search-input" placeholder="Color">
    <textarea name="description" class="search-input" placeholder="Description"></textarea>
    <label>Select product images (multiple allowed):</label>
    <input type="file" name="images[]" accept="image/*" multiple required>
    <small style="color:#ffc;">Or manual image URLs (comma separated):</small>
    <input name="imageurls" class="search-input" placeholder="(Optional) image1.jpg,image2.jpg">
    <button class="admin-actions-btn" style="width:100%;">Add Product</button>
  </form>
</div>
</body>
</html>
