<?php
require 'config.php';


$categories = $pdo->query("SELECT DISTINCT categoriePlat FROM plat")->fetchAll(PDO::FETCH_ASSOC);
$cuisines = $pdo->query("SELECT DISTINCT typeCuisine FROM plat")->fetchAll(PDO::FETCH_ASSOC);


$selected_category = $_POST['category'] ?? '';
$selected_cuisine = $_POST['cuisine'] ?? '';


$query = "SELECT * FROM plat";
$params = [];

if ($selected_category) {
    $query .= " WHERE categoriePlat = :category";
    $params['category'] = $selected_category;
}
if ($selected_cuisine) {
    $query .= $selected_category ? " AND typeCuisine = :cuisine" : " WHERE typeCuisine = :cuisine";
    $params['cuisine'] = $selected_cuisine;
}


$stmt = $pdo->prepare($query);
$stmt->execute($params);
$plats = $stmt->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['add_to_cart'])) {
    $idPlat = $_POST['idPlat'];
    $nomPlat = $_POST['nomPlat'];
    $prix = $_POST['prix'];

    if (!isset($_SESSION['cart'][$idPlat])) {
        $_SESSION['cart'][$idPlat] = ['nomPlat' => $nomPlat, 'prix' => $prix, 'quantity' => 1];
    } else {
        $_SESSION['cart'][$idPlat]['quantity']++;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Solirestaurant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="#"><img src="image/logo.png" alt=""></a></div>
        <ul class="nav-links">
            <li><a href="login.php" >Login</a></li>
            <li><a href="cart.php">Cart</a></li>
        </ul>
    </nav>
    
    <section class="center">
        <h1>COMFORT FOOD MADE<br> WITH PLANT-BASED</h1>
        <h3>INGREDIENTS AND LOTS OF LOVE</h3>
    </section>

    <main>
        <div class="filter-container">
            <form method="POST">
                <label for="category">Filter by Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= ($category['categoriePlat']) ?>" 
                            <?= ($selected_category == $category['categoriePlat']) ? 'selected' : '' ?>>
                            <?= ($category['categoriePlat']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="cuisine">Filter by Cuisine:</label>
                <select name="cuisine" id="cuisine">
                    <option value="">All Cuisines</option>
                    <?php foreach ($cuisines as $cuisine): ?>
                        <option value="<?= ($cuisine['typeCuisine']) ?>" 
                            <?= ($selected_cuisine == $cuisine['typeCuisine']) ? 'selected' : '' ?>>
                            <?= ($cuisine['typeCuisine']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Filter</button>
            </form>
        </div>

        <div class="menu-container">
            <?php foreach ($plats as $plat): ?>
                <div class="card">
                    <h3><?= ($plat['nomPlat']) ?></h3>
                    <p>Category: <?= ($plat['categoriePlat']) ?></p>
                    <p>Type: <?= ($plat['TypeCuisine']) ?></p>
                    <p>Price: <?= ($plat['prix']) ?> DH</p>
                    <?php if (!empty($plat['image'])): ?>
                        <img src="<?= ($plat['image']) ?>" alt="<?= ($plat['nomPlat']) ?>">
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="idPlat" value="<?= ($plat['idPlat']) ?>">
                        <input type="hidden" name="nomPlat" value="<?= ($plat['nomPlat']) ?>">
                        <input type="hidden" name="prix" value="<?= ($plat['prix']) ?>">
                        <input type="submit" name="add_to_cart" value="Add to Cart" class="add-to-cart">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Solirestaurant. All rights reserved.</p>
            <div class="social-icons">
                <a href="#"><img src="image/fc.png" alt="Facebook"></a>
                <a href="#"><img src="image/x.png" alt="Twitter"></a>
                <a href="#"><img src="image/ig.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>
</body>
</html>
