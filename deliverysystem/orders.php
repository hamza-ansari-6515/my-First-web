<?php
// deliveryboy/orders.php
<?php
session_start(); include 'db.php';
if(!isset($_SESSION['deliveryboy'])){ header('Location: login.php'); exit(); }

// Show only assigned (pending pickup) orders for this delivery boy
$res = mysqli_query($conn,"SELECT * FROM orders WHERE status='Assigned' AND deliveryboy_id={$_SESSION['deliveryboy']} ORDER BY id DESC");
?>
<!-- List and accept button logic -->
