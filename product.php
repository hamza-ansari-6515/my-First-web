<?php
session_start();
include 'db.php';
$id = intval($_GET['id'] ?? 1);
$prod = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE id=$id"));
$images = explode(',', $prod['images'] ?? $prod['image1']);

// --- Add to cart/order confirm and stock decrease ---
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["add_cart"])) {
    $size = $_POST["size"] ?? "M";
    $qty = intval($_POST["qty"] ?? 1);

    // Reduce stock if available
    if ($qty > 0 && $qty <= $prod['stock']) {
        $newStock = $prod['stock'] - $qty;
        mysqli_query($conn, "UPDATE products SET stock=$newStock WHERE id=$id");
        $cart_item = [
            "id"    => $prod['id'],
            "name"  => $prod['name'],
            "qty"   => $qty,
            "size"  => $size,
            "price" => $prod['price']
        ];
        if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];
        $_SESSION["cart"][] = $cart_item;
        header("Location: cart.php");
        exit;
    } else {
        $error = "Not enough stock!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($prod['name']) ?> | CLOTHES</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .img-slider {max-width:410px;margin:0 auto;position:relative;}
    .img-slider img {width:100%;height:310px;object-fit:cover;border-radius:14px;display:none;}
    .img-slider img.active {display:block;}
    .slider-nav {position:absolute;top:45%;width:100%;display:flex;justify-content:space-between;}
    .slider-btn {background:#eabf4d;border:none;padding:9px 14px;border-radius:10px;font-weight:700;font-size:1.2rem;cursor:pointer;opacity:.8;}
    .size-row {display:flex;gap:12px;margin:16px 0 13px 0;}
    .size-btn {background:#232a37;color:#eabf4d;border-radius:7px;border:none;padding:7px 21px;font-size:1.11rem;font-weight:700;cursor:pointer;box-shadow:0 2px 8px #cb3;transition:background .15s;}
    .size-btn.selected,.size-btn:active {background:#eabf4d;color:#232a37;}
    .prod-details {margin-top:24px;}
    .prod-title {font-size:2.1rem;color:#eabf4d;margin-bottom:9px;}
    .prod-desc {font-size:1.07rem;color:#fff;background:#181a22;padding:12px;border-radius:8px;}
  </style>
</head>
<body>
<nav class="gradient-header">
    <div class="logo-area">
        <img src="logo.png" class="logo" alt="Logo">
        <span class="brand-name">CLOTHES</span>
    </div>
    <div class="nav-right">
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>
    </div>
</nav>
<div class="section" style="max-width:700px;">
    <div class="img-slider" id="slider">
      <?php foreach($images as $i=>$url){ ?>
        <img src="<?= trim($url) ?>" <?= $i==0 ? 'class="active"' : '' ?> id="prodimg<?= $i ?>" 
          onerror="this.onerror=null;this.src='images/noimg.png';">
      <?php } ?>
      <div class="slider-nav">
        <button class="slider-btn" onclick="slideImg(-1)">&lt;</button>
        <button class="slider-btn" onclick="slideImg(1)">&gt;</button>
      </div>
    </div>
    <div class="prod-details">
      <div class="prod-title"><?= htmlspecialchars($prod['name']) ?></div>
      <div><b>Price:</b> ₹<?= $prod['price'] ?></div>
      <div><b>Color:</b> <?= htmlspecialchars($prod['color']) ?></div>
      <div class="prod-desc"><?= htmlspecialchars($prod['description']) ?></div>
      <form method="POST" style="margin-top:17px;">
        <div class="size-row" id="sizeRow">
          <?php foreach(['S','M','L','XL','XXL'] as $sz){ ?>
            <button type="button" class="size-btn" onclick="setSize('<?= $sz ?>')" id="btnSize<?= $sz ?>"><?= $sz ?></button>
          <?php } ?>
        </div>
        <input type="hidden" name="size" id="selectedSize" value="M">
        <div style="margin:12px 0;">
            <label><b>Quantity:</b></label>
            <input type="number" name="qty" min="1" max="<?= $prod['stock'] ?>" value="1" style="width:52px;">
        </div>
        <?php if (!empty($error)) { ?>
            <div style="background:#e32849;color:#fff;border-radius:7px;padding:8px 13px;margin-bottom:7px;"><?= $error ?></div>
        <?php } ?>
        <button type="submit" name="add_cart" class="explore-btn" style="margin-top:10px;">Add to Cart</button>
      </form>
    </div>
    <script>
      // Image slider
      let currentImg=0;
      function slideImg(dir){
        let imgs=document.querySelectorAll('#slider img');
        imgs[currentImg].classList.remove('active');
        currentImg=(currentImg+dir+imgs.length)%imgs.length;
        imgs[currentImg].classList.add('active');
      }
      // Size select buttons
      function setSize(sz){
        document.getElementById('selectedSize').value=sz;
        ['S','M','L','XL','XXL'].forEach(function(size){
          document.getElementById('btnSize'+size).classList.remove('selected');
        });
        document.getElementById('btnSize'+sz).classList.add('selected');
      }
      // Default select "M"
      setSize('M');
    </script>
</div>
</body>
</html>
