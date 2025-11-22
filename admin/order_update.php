<?php
session_start();
include '../db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }

// For status update:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oid = intval($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if($oid && in_array($status, ['Pending','Approved','Assigned','Delivered'])) {
        mysqli_query($conn,"UPDATE orders SET status='$status' WHERE id=$oid");
    }
    // Assign Delivery logic: (called from Approved section form with hidden assign flag, or with a button)
    if (isset($_POST['assign_delivery']) && $oid) {
        mysqli_query($conn,"UPDATE orders SET status='Assigned' WHERE id=$oid AND status='Approved'");
    }
}

// Redirect user back to orders page (preserve tab, if any)
$redirect = $_SERVER['HTTP_REFERER'] ?? 'orders.php';
header("Location: $redirect");
exit;
?>
