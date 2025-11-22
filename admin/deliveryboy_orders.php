<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
  header('Location: login.php');
  exit();
}

$boy_id = intval($_GET['id'] ?? 0);
if(!$boy_id){
  die("Invalid Delivery Boy ID");
}

$query = "SELECT o.*, p.name AS product_name FROM orders o LEFT JOIN products p ON o.product_id=p.id WHERE o.deliveryboy_id=$boy_id ORDER BY o.id DESC";
$res = mysqli_query($conn, $query);

$boy = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM deliveryboys WHERE id=$boy_id"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Orders of <?= htmlspecialchars($boy['name']) ?></title>
  <style>
    body {
      background: #191a1d;
      color: #eee;
      font-family: Arial, sans-serif;
      margin: 0; padding: 20px;
    }
    a.back-link {
      color: #42b0ee;
      text-decoration: underline;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 20px;
      cursor: pointer;
    }
    h2 {
      color: #eabf4d;
      margin-bottom: 18px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 950px;
    }
    th, td {
      padding: 12px 16px;
      border-bottom: 1px solid #444;
      text-align: left;
    }
    th {
      background: #232a37;
      color: #f0bc2f;
    }
    tbody tr:hover {
      background: #353b4a;
    }
  </style>
</head>
<body>
  <a href="deliveryboys.php" class="back-link">&larr; Back to Delivery Boys List</a>
  <h2>Orders of Delivery Boy: <?= htmlspecialchars($boy['name']) ?></h2>
  <table>
    <thead>
      <tr>
        <th>Order ID</th><th>User ID</th><th>Product</th><th>Quantity</th><th>Status</th><th>Address</th>
      </tr>
    </thead>
    <tbody>
      <?php while($order = mysqli_fetch_assoc($res)) { ?>
        <tr>
          <td><?= $order['id'] ?></td>
          <td><?= $order['user_id'] ?></td>
          <td><?= htmlspecialchars($order['product_name']) ?></td>
          <td><?= $order['quantity'] ?></td>
          <td><?= $order['status'] ?></td>
          <td><?= htmlspecialchars($order['address']) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
