<?php
include 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $email=$_POST['email']??''; $pass=$_POST['pass']??'';
    $res = mysqli_query($conn,"SELECT * FROM deliveryboys WHERE email='$email' AND password='$pass'");
    if ($d=mysqli_fetch_assoc($res)) {
        $_SESSION['deliveryboy']=$d['id'];
        header('Location: dashboard.php'); exit;
    } else { $error="Invalid credentials!"; }
}
?>
<!DOCTYPE html>
<html><head><title>Delivery Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="login-center">
    <form method="POST">
        <h2>Delivery Boy Login</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="pass" placeholder="Password" required>
        <button>Login</button>
        <div><a href="register.php">New delivery boy? Register</a></div>
    </form>
</div>
</body>
</html>
