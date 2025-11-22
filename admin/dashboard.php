<?php
session_start();
include '../db.php';
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit();
}

// Total counts
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders"))['c'] ?? 0;
$total_delivered = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE status='Delivered'"))['c'] ?? 0;
$total_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE status='Pending'"))['c'] ?? 0;
$total_deliveryboys = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM deliveryboys"))['c'] ?? 0;
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard | CLOTHES</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    body {
      background: #191a1d;
      color: #eee;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0; padding: 0;
    }
    nav.admin-header {
      background: linear-gradient(120deg, #232a37 60%, #42b0ee 120%);
      color: #fff;
      padding: 20px 32px;
      font-size: 1.3rem;
      font-weight: 700;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .back-arrow {
      position: absolute;
      left: 20px; top: 25px;
      background: #eabf4d;
      border: none;
      padding: 6px 20px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 1.3rem;
      cursor: pointer;
      color: #232a37;
      box-shadow: 0 2px 12px #cba81988;
      z-index: 1000;
    }
    .admin-section {
      max-width: 980px;
      margin: 60px auto 40px;
      padding: 0 18px;
    }
    .admin-title {
      color: #f0bc2f;
      font-weight: 700;
      font-size: 2.2rem;
      margin-bottom: 26px;
      text-align: center;
    }
    .admin-cards {
      display: flex;
      gap: 22px;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 50px;
    }
    .admin-card {
      background: #232a37;
      flex: 1 1 210px;
      max-width: 210px;
      padding: 28px 22px;
      border-radius: 14px;
      color: #eabf4d;
      text-align: center;
      font-weight: 700;
      font-size: 1.1rem;
      text-decoration: none;
      box-shadow: 0 8px 22px #0d141daa;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      user-select: none;
    }
    .admin-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 32px #fecf3aaa;
      color: #fcfbe8;
    }
    .admin-card svg {
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
      fill: currentColor;
    }
    .stats-container {
      display: flex;
      justify-content: space-between;
      gap: 28px;
      flex-wrap: wrap;
      max-width: 980px;
      margin: 0 auto;
    }
    .stat-box {
      background: #232a37;
      border-radius: 14px;
      color: #eabf4d;
      flex: 1 1 220px;
      padding: 34px 0;
      text-align: center;
      box-shadow: 0 6px 24px #0d141dbb;
      user-select: none;
      transition: background 0.3s ease;
    }
    .stat-box h3 {
      font-size: 1.3rem;
      margin-bottom: 12px;
      font-weight: 700;
    }
    .stat-box p {
      font-size: 3.4rem;
      margin: 0;
      font-weight: 900;
      letter-spacing: 2px;
    }
    .stat-box a {
      color: #f0bc2f;
      display: inline-block;
      margin-top: 14px;
      font-weight: 600;
      text-decoration: underline;
      font-size: 1rem;
      cursor: pointer;
    }
    .stat-box:hover {
      background: #1c222f;
    }
  </style>
</head>
<body>
<button onclick="location.href='logout.php'" class="back-arrow">&#8678; Logout</button>

<nav class="admin-header">
  <span>Admin Panel</span>
  <span>Welcome, <?= htmlspecialchars($admin_name) ?></span>
</nav>

<div class="admin-section">
  <h1 class="admin-title">Dashboard</h1>

  <div class="admin-cards">
    <a href="products.php" class="admin-card" title="Manage Products">
      <svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="7"/><rect x="4" y="13" width="16" height="7"/></svg>
      Manage Products
    </a>
    <a href="categories.php" class="admin-card" title="Manage Categories">
      <svg viewBox="0 0 24 24"><circle cx="8" cy="8" r="5"/><circle cx="16" cy="16" r="5"/></svg>
      Manage Categories
    </a>
    <a href="orders.php" class="admin-card" title="Manage Orders">
      <svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13"/><line x1="3" y1="7" x2="21" y2="7" stroke="#ffbe3c" stroke-width="2"/></svg>
      Manage Orders
    </a>
    <a href="deliveryboys.php" class="admin-card" title="Delivery Boys Panel">
      <svg viewBox="0 0 24 24"><path d="M7 16v-1a4 4 0 0 1 8 0v1"/><circle cx="12" cy="8" r="3"/></svg>
      Delivery Boys
    </a>
  </div>

  <div class="stats-container">
    <div class="stat-box">
      <h3>Total Orders</h3>
      <p><?= $total_orders ?></p>
    </div>
    <div class="stat-box" style="color:#a3db88;">
      <h3>Delivered Orders</h3>
      <p><?= $total_delivered ?></p>
    </div>
    <div class="stat-box" style="color:#f8bb4b;">
      <h3>Pending Orders</h3>
      <p><?= $total_pending ?></p>
    </div>
    <div class="stat-box" style="color:#42b0ee;">
      <h3>Delivery Boys</h3>
      <p><?= $total_deliveryboys ?></p>
      <a href="deliveryboys.php">View Delivery Boys</a>
    </div>
  </div>
</div>
</body>
</html>
