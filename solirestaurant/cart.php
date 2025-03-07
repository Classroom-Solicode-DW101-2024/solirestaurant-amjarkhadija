 <?php 
session_start();
try {
    $connect = new PDO("mysql:host=localhost;dbname=solirestaurant", "root", "");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

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

if (isset($_POST['button'])) {
    $idPlat = $_POST['idPlat'];
    if (isset($_SESSION['cart'][$idPlat])) {
        $_SESSION['cart'][$idPlat]['quantity']++;
    }
}

if (isset($_POST['submit'])) {
    $idPlat = $_POST['idPlat'];
    if (isset($_SESSION['cart'][$idPlat])) {
        if ($_SESSION['cart'][$idPlat]['quantity'] > 1) {
            $_SESSION['cart'][$idPlat]['quantity']--;
        } else {
            unset($_SESSION['cart'][$idPlat]);
        }
    }
}

if (isset($_POST['remove_from_cart'])) {
    $idPlat = $_POST['idPlat'];
    unset($_SESSION['cart'][$idPlat]);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Solirestaurant</title>
    <link rel="stylesheet" href="cart.css"> 
</head>
<body>
<nav class="navbar">
        <div class="logo"><a href="index.php"><img src="image/logo.png" alt=""></a></div>
        <ul class="nav-links">
            <li><a href="login.php">Login</a></li>
            <li><a href="cart.php">Cart</a></li>
        </ul>
    </nav>

    <main>
        <div class="cart-container">
            <h2>Your Cart</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="cart-items">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $idPlat => $item):
                        $subtotal = $item['prix'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <div class="cart-item">
                            <h3><?= ($item['nomPlat']) ?></h3>
                            <p>Price: <?= ($item['prix']) ?> DH</p>
                            <p>Quantity: <?= ($item['quantity']) ?></p>
                            <p>Subtotal: <?= $subtotal ?> DH</p>
                            <div class="cart-actions">
                                <form method="post">
                                    <input type="hidden" name="idPlat" value="<?= $idPlat ?>">
                                    <button type="submit" name="submit" class="quantity-btn">-</button>
                                    <button type="submit" name="button" class="quantity-btn">+</button>
                                </form>
                                <form method="post">
                                    <input type="hidden" name="idPlat" value="<?= $idPlat ?>">
                                    <button type="submit" name="remove_from_cart" class="remove-btn">Remove</button>
                                </form>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart-total">
                    <h3>Total: <?= $total ?> DH</h3>
                </div>
                <form method="post">
            <button type="submit" name="validate_order" class="quantity-btn" >Validate Order</button>
        </form>
            <?php else: ?>
                <p class="empty-cart">add plat to your cart!</p>
            <?php endif; ?>
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