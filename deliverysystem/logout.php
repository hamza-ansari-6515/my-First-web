<?php
session_start();
unset($_SESSION['deliveryboy']);
header('Location: login.php');
exit;
?>
