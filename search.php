<?php
include "db.php";
$q = trim($_GET["q"] ?? "");
echo '<!DOCTYPE html>
<html>
<head>
    <title>Search | CLOTHES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<button onclick="window.history.back()" class="back-arrow">&#8678;</button>
<nav class="gradient-header"><span class="brand-name">CLOTHES</span><a href="index.php">Home</a></nav>
<div class="section"><h2 class="section-title">Search Results</h2>
<div class="search-section">
    <span class="search-icon">&#128269;</span>
    <form action="search.php" method="GET" style="flex:1;">
        <input class="search-input" name="q" type="search" value="'.htmlspecialchars($q).'" placeholder="Search clothes..."/>
    </form>
</div>';
if ($q == "") {
    echo "<p>Please enter a search query.</p></div></body></html>"; exit;
}
$res = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$q%' ORDER BY id DESC");
if (mysqli_num_rows($res) == 0) {
    echo "<p>No products found for <b>$q</b>.</p>";
} else {
    echo '<div class="categories-row" style="display:grid; grid-template-columns:repeat(3,1fr); gap:22px;">';
    while($prod = mysqli_fetch_assoc($res)){
        echo '<div class="cat-card" onclick="location.href=\'product.php?id='.$prod['id'].'\'"><img src="'.$prod['image1'].'" alt="'.$prod['name'].'"><h4>'.$prod['name'].'</h4><p>₹'.$prod['price'].'</p><a href="product.php?id='.$prod['id'].'" class="explore-btn product-view-btn">View</a></div>';
    }
    echo '</div>';
}
echo '</div></body></html>';
?>
