<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$q = trim($_GET['q'] ?? '');
$sql = "SELECT p.*,c.name as cname FROM products p LEFT JOIN categories c ON p.category_id=c.id";
if ($q != '') {
  $sql .= " WHERE p.name LIKE '%$q%' OR c.name LIKE '%$q%'";
}
$res = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Products | Admin</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<nav class="admin-header"><span class="brand">Admin Panel</span></nav>
<div class="admin-section">
  <h2 class="admin-title">Products</h2>
  <form style="margin-bottom:18px;">
    <input class="search-input" name="q" type="search" placeholder="Search products or category" value="<?= htmlspecialchars($q) ?>">
    <button class="admin-actions-btn">Search</button>
    <a href="product_add.php" class="admin-actions-btn" style="margin-left:16px;">+ Add Product</a>
  </form>
  <table class="table-orders">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Edit</th><th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php while($p = mysqli_fetch_assoc($res)){ ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= htmlspecialchars($p['cname']) ?></td>
        <td>₹<?= $p['price'] ?></td>
        <td><?= $p['stock'] ?></td>
        <td><a href="product_edit.php?id=<?= $p['id'] ?>" class="admin-actions-btn">Edit</a></td>
        <td>
          <form method="POST" action="product_del.php?id=<?= $p['id'] ?>" onsubmit="return confirm('Do you really want to delete this product?');" style="display:inline;">
            <button class="admin-actions-btn cancel">Delete</button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
