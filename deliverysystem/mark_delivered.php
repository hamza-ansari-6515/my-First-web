<?php
session_start();
include 'db.php';

if (!isset($_SESSION['deliveryboy'])) {
  header('Location: login.php');
  exit();
}

$boy_id = intval($_SESSION['deliveryboy']);
$order_id = intval($_POST['order_id'] ?? 0);

if ($order_id) {
  // Update orders table status to Delivered and assign deliveryboy_id to this boy
  mysqli_query($conn, "UPDATE orders SET status='Delivered', deliveryboy_id=$boy_id WHERE id=$order_id");

  // Increment delivered count for delivery boy (make sure this column exists)
  mysqli_query($conn, "UPDATE deliveryboys SET delivered_count = delivered_count + 1 WHERE id=$boy_id");
}

header("Location: dashboard.php");
exit();
?>
