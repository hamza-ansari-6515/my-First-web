<?php
include 'db.php';
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CLOTHES | Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
      .search-top-area { position: relative; display: flex; align-items: center; justify-content: center; margin-top:8px; gap:8px;}
      .search-icon-top { cursor:pointer; width:34px; height:34px; fill:#eabf4d; background:none; border:none; outline:none; transition:opacity .2s;}
      .search-input {padding:10px 38px;width:240px;}
    </style>
</head>
<body>
<nav class="gradient-header" style="padding-left:48px;">
    <div class="logo-area">
        <img src="logo.png" class="logo" alt="Logo">
        <span class="brand-name" style="font-size:1.4rem;">CLOTHES</span>
    </div>
    <div class="search-top-area">
        <svg class="search-icon-top" width="28" height="28" fill="#eabf4d" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="7" stroke="#eabf4d" stroke-width="2" fill="none"/>
          <line x1="17" y1="17" x2="21" y2="21" stroke="#eabf4d" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <form action="search.php" method="GET" style="display:inline;">
            <input class="search-input" name="q" type="search" placeholder="Search clothes..."/>
        </form>
    </div>
    <div class="nav-right">
        <a href="cart.php">Cart</a>
        <a href="profile.php">Account</a>
    </div>
    <button class="toggle-menu">&#9776;</button>
</nav>
<!-- No <button onclick="back">... removed arrow bar from top as requested -->
<div class="section">
    <h2 class="section-title">Shop By Category</h2>
    <div class="categories-row">
        <?php while($cat = mysqli_fetch_assoc($categories)){ ?>
        <div class="cat-card" onclick="location.href='shop.php?cat_id=<?= $cat['id'] ?>'">
            <img src="<?= $cat['photo_url'] ?>" alt="<?= $cat['name'] ?>" onerror="this.onerror=null;this.src='images/noimg.png';">
            <h4><?= $cat['name'] ?></h4>
            <a href="shop.php?cat_id=<?= $cat['id'] ?>" class="explore-btn product-view-btn">Explore</a>
        </div>
        <?php } ?>
    </div>
</div>
<script>
document.querySelector('.toggle-menu').onclick=function(){
    let nav=document.querySelector('.nav-right');
    nav.style.display=nav.style.display === "flex" ? "none":"flex";
};
</script>
</body>
</html>
