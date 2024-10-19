<?php
session_start();
require 'products.php';  

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <ul>
        <?php if (empty($_SESSION['cart'])): ?>
            <li>Your cart is empty.</li>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $product_id => $cart_item): ?>
                <li>
                    <?php echo htmlspecialchars($cart_item['name']); ?> - 
                    <?php echo htmlspecialchars($cart_item['price']); ?> PHP 
                    x <?php echo htmlspecialchars($cart_item['quantity']); ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="reset-cart.php">Clear my cart</a>
    <a href="place_order.php">Place the order</a>
</body>
</html>
