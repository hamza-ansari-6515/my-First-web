<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';
    mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name','$email','$pass')");
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="gradient-header"><span class="brand-name">CLOTHES</span><a href="index.php">Home</a></nav>
<div class="section" style="max-width:370px;margin-top:50px;border:1px solid #ffbe3c;">
    <h2 class="section-title" style="text-align:center;">Register</h2>
    <form method="POST" style="display:flex;flex-direction:column;gap:20px;">
        <div>
            <label>Name</label>
            <input type="text" name="name" class="search-input" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" class="search-input" required>
        </div>
        <div>
            <label>Password</label>
            <div style="display:flex;align-items:center;">
                <input type="password" id="pass" name="pass" class="search-input" style="flex:1;" required>
                <button type="button" class="explore-btn" onclick="togglePass()" style="margin-left:6px;">Show</button>
            </div>
        </div>
        <button class="explore-btn" style="width:100%;margin-top:7px;">Register</button>
        <div style="text-align:right;margin-top:6px;">
            <a href="login.php" style="color:var(--accent2);text-decoration:underline;">Already registered? Login</a>
        </div>
    </form>
</div>
<script>
function togglePass(){
    var p=document.getElementById('pass');
    p.type = p.type === "password" ? "text" : "password";
}
</script>
</body>
</html>
