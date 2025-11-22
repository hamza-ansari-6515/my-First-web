<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? ''; $pass = $_POST['pass'] ?? '';
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if (mysqli_num_rows($res) == 1) {
        session_start();
        $_SESSION['user'] = mysqli_fetch_assoc($res)['id'];
        header('Location: profile.php');
    } else {
        $error = "Wrong email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
    <style>.forgot-link{color:var(--accent2);text-decoration:underline;font-size:.97rem;}</style>
</head>
<body>
<nav class="gradient-header">
    <div class="logo-area">
        <img src="logo.png" class="logo" alt="Logo">
        <span class="brand-name">CLOTHES</span>
    </div>
</nav>
<div class="section" style="max-width:370px;margin:50px auto;">
    <h2 class="section-title" style="text-align:center;">Login</h2>
    <?php if (!empty($error)) echo "<div style='background:var(--error);color:#fff;padding:10px;border-radius:8px;margin-bottom:18px;text-align:center;'>$error</div>"; ?>
    <form method="POST" style="display:flex;flex-direction:column;gap:20px;">
        <div>
            <label>Email</label>
            <input type="email" name="email" class="search-input" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="pass" class="search-input" required>
        </div>
        <button class="explore-btn" style="width:100%;margin-top:7px;">Login</button>
        <div style="display:flex;justify-content:space-between;margin-top:10px;">
            <a href="register.php" class="forgot-link">New user? Register</a>
            <a href="forgot.php" class="forgot-link">Forgot Password / OTP?</a>
        </div>
    </form>
</div>
</body>
</html>
