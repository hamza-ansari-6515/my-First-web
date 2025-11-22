<?php
session_start();
include 'db.php';

if(!isset($_SESSION['deliveryboy'])){
    header('Location: login.php');
    exit();
}

$boy_id = intval($_SESSION['deliveryboy']);
$duser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM deliveryboys WHERE id=$boy_id"));

// Assigned Orders (status='Assigned' without deliveryboy_id filter, as per tumhara previous request)
$assigned_orders = mysqli_query($conn, "SELECT * FROM orders WHERE status='Assigned' ORDER BY id DESC");

// Delivered Orders for this delivery boy
$delivered_orders = mysqli_query($conn, "SELECT * FROM orders WHERE status='Delivered' AND deliveryboy_id=$boy_id ORDER BY id DESC");

// Delivered count
$delivered_count = intval($duser['delivered_count']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delivery Boy Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
  <div class="user-info">
    <h1>Welcome, <?= htmlspecialchars($duser['name']) ?></h1>
    <p><b>ID:</b> <?= $boy_id ?></p>
  </div>
</div>

<div class="tabs">
  <div class="tab active" data-target="profile">Profile Info</div>
  <div class="tab" data-target="assigned">Assigned Orders</div>
  <div class="tab" data-target="delivered">Delivered Orders</div>
</div>

<section id="profile" class="active">
  <h2>Your Profile</h2>
  <div class="profile-info">
    <p><b>Name:</b> <?= htmlspecialchars($duser['name']) ?></p>
    <p><b>Email:</b> <?= htmlspecialchars($duser['email']) ?></p>
    <p><b>Mobile:</b> <?= htmlspecialchars($duser['mobile']) ?></p>
    <p class="delivered-count">Total Delivered Orders: <?= $delivered_count ?></p>
  </div>
</section>

<section id="assigned">
  <h2>Assigned Orders</h2>
  <?php if (mysqli_num_rows($assigned_orders) == 0): ?>
    <p>No assigned orders available at the moment.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>ID</th><th>Product</th><th>User ID</th><th>Address</th><th>Status</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php while ($order = mysqli_fetch_assoc($assigned_orders)):
          $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM products WHERE id={$order['product_id']}"));
        ?>
          <tr>
            <td><?= $order['id'] ?></td>
            <td><?= htmlspecialchars($p['name'] ?? '-') ?></td>
            <td><?= $order['user_id'] ?></td>
            <td><?= htmlspecialchars($order['address']) ?></td>
            <td><?= $order['status'] ?></td>
            <td>
              <form method="POST" action="mark_delivered.php" style="margin:0;">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <button type="submit" class="deliver-btn">Mark Delivered</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif;?>
</section>

<section id="delivered">
  <h2>Delivered Orders</h2>
  <?php if (mysqli_num_rows($delivered_orders) == 0): ?>
    <p>You have not delivered any orders yet.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>ID</th><th>Product</th><th>User ID</th><th>Address</th><th>Status</th></tr>
      </thead>
      <tbody>
        <?php while ($order = mysqli_fetch_assoc($delivered_orders)):
          $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM products WHERE id={$order['product_id']}"));
        ?>
          <tr>
            <td><?= $order['id'] ?></td>
            <td><?= htmlspecialchars($p['name'] ?? '-') ?></td>
            <td><?= $order['user_id'] ?></td>
            <td><?= htmlspecialchars($order['address']) ?></td>
            <td><?= $order['status'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif;?>
</section>

<script>
  const tabs = document.querySelectorAll('.tab');
  const sections = document.querySelectorAll('section');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const target = tab.getAttribute('data-target');
      sections.forEach(sec => {
        if (sec.id === target) sec.classList.add('active');
        else sec.classList.remove('active');
      });
    });
  });
</script>

</body>
</html>
