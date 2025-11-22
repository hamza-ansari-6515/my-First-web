// pickup.php (delivery boy action)
<?php
session_start(); include 'db.php';
if(!isset($_SESSION['deliveryboy'])){ header('Location: login.php'); exit(); }

$order_id = intval($_GET['order_id'] ?? 0);
if ($order_id) {
    // Check if already assigned
    $res = mysqli_query($conn,"SELECT * FROM orders WHERE id=$order_id");
    if ($row=mysqli_fetch_assoc($res)){
        if($row['status']=='Pending'){ // only pending can be picked
            mysqli_query($conn,"UPDATE orders SET status='Assigned', deliveryboy_id={$_SESSION['deliveryboy']} WHERE id=$order_id");
            echo "Order assigned successfully.";
        } else {
            echo "Order already assigned or completed.";
        }
    }
}
?>
