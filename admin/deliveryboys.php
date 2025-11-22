<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
  header('Location: login.php');
  exit();
}

$q = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM deliveryboys";
if ($q !== '') {
    $sql .= " WHERE name LIKE '%$q%' OR email LIKE '%$q%' OR mobile LIKE '%$q%'";
}
$sql .= " ORDER BY delivered_count DESC";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delivery Boys | Admin Panel</title>
  <style>
    body {
      background: #191a1d;
      color: #eee;
      font-family: Arial, sans-serif;
      margin: 0; padding: 20px;
    }
    h2 {
      color: #eabf4d;
      margin-bottom: 20px;
    }
    form.search-form {
      margin-bottom: 22px;
    }
    input.search-input {
      padding: 8px 12px;
      font-size: 1.1rem;
      border-radius: 8px;
      border: none;
      width: 280px;
      outline: none;
      box-shadow: 0 0 12px #42b0eea0;
      background: #232a37;
      color: #eee;
    }
    button.search-btn {
      background: #42b0ee;
      border: none;
      color: #fff;
      padding: 8px 18px;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      margin-left: 12px;
      font-weight: 700;
      transition: background-color 0.2s ease;
    }
    button.search-btn:hover {
      background: #1e7ada;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 900px;
    }
    th, td {
      padding: 12px 16px;
      border-bottom: 1px solid #333;
      text-align: left;
    }
    th {
      background: #232a37;
      color: #f0bc2f;
    }
    tbody tr:hover {
      background: #353b4a;
    }
    a.view-orders {
      background: #eabf4d;
      padding: 7px 13px;
      border-radius: 7px;
      text-decoration: none;
      color: #232a37;
      font-weight: 600;
      box-shadow: 0 3px 14px #cba82870;
      transition: background 0.25s;
    }
    a.view-orders:hover {
      background: #cfac1a;
    }
  </style>
</head>
<body>
  <h2>Delivery Boys</h2>

  <form method="GET" class="search-form">
    <input type="search" name="q" placeholder="Search by name, email, or mobile" value="<?= htmlspecialchars($q) ?>" class="search-input" />
    <button type="submit" class="search-btn">Search</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Delivered Count</th><th>View Orders</th>
      </tr>
    </thead>
    <tbody>
      <?php while($boy = mysqli_fetch_assoc($res)) { ?>
        <tr>
          <td><?= $boy['id'] ?></td>
          <td><?= htmlspecialchars($boy['name']) ?></td>
          <td><?= htmlspecialchars($boy['email']) ?></td>
          <td><?= htmlspecialchars($boy['mobile']) ?></td>
          <td><?= $boy['delivered_count'] ?></td>
          <td><a href="deliveryboy_orders.php?id=<?= $boy['id'] ?>" class="view-orders">View Orders</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
