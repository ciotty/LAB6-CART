<?php
session_start();
require 'products.php';  
if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] == $product_id) {
            $product = $p;
            break;
        }
    }
    
    if ($product) {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        } else {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        }
    }
}

header('Location: index.php');
exit();
?>
