<?php
include 'db.php';
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='$email'"));
    if ($user) {
        // Generate OTP (random 4-6 digit)
        $otp = rand(100000, 999999);
        // Store OTP for this user (needs users table-with field otp, expires_at, or temp table)
        mysqli_query($conn, "UPDATE users SET otp='$otp' WHERE id={$user['id']}");
        // Send OTP/email (dummy, implement mail() or PHPMailer for live)
        // mail($email, "Your password reset OTP", "Your OTP is: $otp"); // Live server only
        
        $message = "OTP sent to your email. Enter it in the reset password page.";
    } else {
        $message = "No user found with this email.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .msg-box{background:#faf3d4;color:#2a1;padding:10px 18px;border-radius:8px;margin-bottom:12px;}
    </style>
</head>
<body>
<nav class="gradient-header">
    <div class="logo-area">
        <img src="logo.png" class="logo" alt="Logo">
        <span class="brand-name">CLOTHES</span>
    </div>
</nav>
<div class="section" style="max-width:380px;margin:50px auto;">
    <h2 class="section-title" style="text-align:center;">Forgot Password</h2>
    <?php if (!empty($message)) echo "<div class='msg-box'>$message</div>"; ?>
    <form method="POST" style="display:flex;flex-direction:column;gap:18px;">
        <div>
            <label>Email</label>
            <input type="email" name="email" class="search-input" required>
        </div>
        <button class="explore-btn" style="width:100%;">Send OTP / Reset Link</button>
    </form>
    <div style="margin-top:12px;font-size:0.97rem;">
        <a href="login.php" style="color:var(--accent2);text-decoration:underline;">Cancel & Login</a>
    </div>
</div>
</body>
</html>
