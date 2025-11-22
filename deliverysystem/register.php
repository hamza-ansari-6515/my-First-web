<?php
include 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name']??''; $mob=$_POST['mobile']??''; $email=$_POST['email']??''; $pass=$_POST['pass']??'';
    mysqli_query($conn,"INSERT INTO deliveryboys (name,mobile,email,password) VALUES ('$name','$mob','$email','$pass')");
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html><head><title>Delivery Register</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="login-center">
    <form method="POST">
        <h2>Delivery Boy Registration</h2>
        <input name="name" placeholder="Name" required>
        <input name="mobile" placeholder="Mobile" required>
        <input name="email" placeholder="Email" required>
        <input type="password" name="pass" placeholder="Password" required>
        <button>Register</button>
        <div><a href="login.php">Already registered? Login</a></div>
    </form>
</div>
</body>
</html>
