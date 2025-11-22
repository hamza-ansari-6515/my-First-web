<?php
session_start();
$cart = ($_GET['single']??0) && isset($_SESSION["buy_this"])
    ? array_filter($_SESSION["cart"], fn($item)=>$item["id"] == $_SESSION["buy_this"])
    : $_SESSION["cart"];
$total = 0; foreach($cart as $item){ $total += $item["qty"]*$item["price"]; }

if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($cart)) {
    // Database insert: dummy/demo
    // Save shipping info + items in 'orders' table, status, etc.
    // For each product in cart
    include 'db.php';
    $user_id = $_SESSION['user'] ?? 0;
    $address = $_POST['address'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    foreach($cart as $itm){
        mysqli_query($conn,"INSERT INTO orders (user_id,product_id,quantity,size,color,status,address,mobile) VALUES ('$user_id','{$itm['id']}','{$itm['qty']}','{$itm['size']}','','Pending','$address','$mobile')");
    }
    // Clear cart if buy all
    if (!($_GET['single']??0)) $_SESSION["cart"] = [];
    unset($_SESSION["buy_this"]);
    header("Location: profile.php?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="gradient-header">
    <span class="brand-name">CLOTHES</span>
    <a href="index.php">Home</a>
</nav>
<div class="section" style="max-width:510px;">
    <h2 class="section-title" style="text-align:center;">Checkout</h2>
    <form method="POST" style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label>Mobile Number</label>
            <input name="mobile" type="text" class="search-input" required>
        </div>
        <div>
            <label>Shipping Address</label>
            <textarea name="address" class="search-input" style="min-height:60px;" required></textarea>
        </div>
        <div style="background:#232532a1;padding:16px;border-radius:10px;margin-top:8px;">
            <strong>Order Summary</strong>
            <ul style="padding-left:20px;margin:10px;">
                <?php foreach ($cart as $item) { ?>
                <li><?= htmlspecialchars($item['name']) ?> (<?= htmlspecialchars($item['size']) ?>): <?= $item['qty'] ?> × ₹<?= $item['price'] ?> = <b>₹<?= $item['qty']*$item['price'] ?></b></li>
                <?php } ?>
            </ul>
            <div style="border-top:1px solid #999;padding-top:4px;"><b>Total Amount:</b> <span style="color:var(--btn-accent);font-size:1.13rem;">₹<?= $total ?></span></div>
        </div>
        <button class="btn-checkout">Place Order</button>
    </form>
</div>
</body>
</html>
