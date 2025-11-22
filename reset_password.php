<?php
include 'db.php';
$email=$_GET['email'];
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $pass=$_POST['pass'];
    mysqli_query($conn, "UPDATE users SET password='$pass', otp=NULL WHERE email='$email'");
    header('Location: login.php');
}
?>
<form method="POST">
    <input type="password" name="pass" required>
    <button>Reset Password</button>
</form>
