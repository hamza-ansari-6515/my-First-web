<?php
include 'db.php';
$cat_id = intval($_GET['cat_id'] ?? 1);
$prod_res = mysqli_query($conn, "SELECT * FROM products WHERE category_id=$cat_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shop | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="gradient-header">
    <span class="brand-name">CLOTHES</span>
    <a href="index.php">Home</a>
</nav>
<section class="section">
    <h2 class="section-title">Products</h2>
    <div class="categories-row">
        <?php while($prod = mysqli_fetch_assoc($prod_res)){ ?>
        <div class="cat-card">
            <img src="<?= $prod['image1'] ?>" alt="<?= $prod['name'] ?>">
            <h4><?= $prod['name'] ?></h4>
            <p>₹<?= $prod['price'] ?></p>
            <a href="product.php?id=<?= $prod['id'] ?>" class="explore-btn">View</a>
        </div>
        <?php } ?>
    </div>
</section>
</body>
</html>
