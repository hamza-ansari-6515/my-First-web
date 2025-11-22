<?php
include 'db.php';
$email=$_GET['email'];
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $otp=$_POST['otp'];
    $res=mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND otp='$otp'");
    if (mysqli_num_rows($res)==1) {
        // Show reset password form
        header('Location: reset_password.php?email='.$email);
    } else { echo "Invalid OTP"; }
}
?>
<form method="POST"><input name="otp"><button>Verify</button></form>
