<?php
session_start(); include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
$oid = intval($_POST['order_id'] ?? 0);
if ($oid) {
    mysqli_query($conn,"UPDATE orders SET status='Assigned' WHERE id=$oid AND status='Approved'");
}
header("Location: orders.php?type=Approved");
exit;
?>
