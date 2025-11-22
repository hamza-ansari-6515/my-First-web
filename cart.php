<?php
session_start();
if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["update"])) {
        $id = intval($_POST["update"]);
        $qtys = $_POST["qty"] ?? [];
        foreach ($_SESSION["cart"] as &$item) {
            if ($item["id"] == $id && isset($qtys[$id]) && intval($qtys[$id])>0) {
                $item["qty"] = intval($qtys[$id]);
            }
        }
    }
    if (isset($_POST["delete"])) {
        $id = intval($_POST["delete"]);
        $_SESSION["cart"] = array_filter($_SESSION["cart"], function($item)use($id){ return $item["id"] != $id; });
    }
    if (isset($_POST["buy_this"])) {
        $_SESSION["buy_this"] = intval($_POST["buy_this"]);
        header("Location: checkout.php?single=1");
        exit;
    }
    if (isset($_POST["buy_all"])) {
        unset($_SESSION["buy_this"]);
        header("Location: checkout.php");
        exit;
    }
}
$total = 0;
foreach ($_SESSION["cart"] as $item){ $total += $item["qty"]*$item["price"]; }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="gradient-header"><span class="brand-name">CLOTHES</span><a href="index.php">Home</a></nav>
<div class="section">
    <h2 class="section-title">Your Cart</h2>
    <form method="POST">
    <table class="table-cart">
        <thead>
            <tr><th>Product</th><th>Size</th><th>Qty</th><th>Price</th><th>Remove</th><th>Buy This</th></tr>
        </thead>
        <tbody>
            <?php foreach($_SESSION["cart"] as $item){ ?>
            <tr>
                <td><?= htmlspecialchars($item["name"]) ?></td>
                <td><?= htmlspecialchars($item["size"]) ?></td>
                <td>
                    <input type="number" name="qty[<?= $item['id']?>]" value="<?= $item["qty"] ?>" min="1" style="width:55px;">
                    <button name="update" value="<?= $item['id']?>" class="explore-btn" style="padding:2px 11px;margin-left:6px;">Change</button>
                </td>
                <td>₹<?= $item["qty"]*$item["price"] ?></td>
                <td><button name="delete" value="<?= $item['id']?>" class="btn-delete">Delete</button></td>
                <td><button name="buy_this" value="<?= $item['id']?>" class="explore-btn" style="padding:5px 14px;">Buy This</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="text-align:right;font-size:1.13rem;margin-top:18px;margin-bottom:8px;">
        <strong>Total: ₹<?= $total ?></strong>
    </div>
    <div style="text-align:right;">
        <button name="buy_all" class="btn-checkout" style="margin-right:8px;">Buy All & Checkout</button>
    </div>
    </form>
</div>
</body>
</html>
