<?php
session_start();
require 'products.php';  

function generateOrderCode($length = 8) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

$order_code = generateOrderCode();

$order_date = date('Y-m-d H:i:s');
$order_items = [];
$total_price = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $cart_item) {
        foreach ($products as $product) {
            if ($product['id'] == $product_id) {
                $order_items[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $cart_item['quantity']
                ];
                $total_price += $product['price'] * $cart_item['quantity'];
                break;
            }
        }
    }

    $order_file = 'orders-' . $order_code . '.txt';
    $file_content = "Order Code: $order_code\n";
    $file_content .= "Date and Time Ordered: $order_date\n\n";
    $file_content .= "Order Items:\n";
    foreach ($order_items as $item) {
        $file_content .= "Product ID: " . $item['id'] . "\n";
        $file_content .= "Product Name: " . $item['name'] . "\n";
        $file_content .= "Price: " . $item['price'] . " PHP\n";
        $file_content .= "Quantity: " . $item['quantity'] . "\n";
        $file_content .= "\n";  
    }
    $file_content .= "Total Price: $total_price PHP\n";

    file_put_contents($order_file, $file_content);

    unset($_SESSION['cart']);
} else {
    $order_summary = "Your cart is empty. Unable to place order.";
}

$order_summary = "Order Code: $order_code<br>";
$order_summary .= "Date and Time Ordered: $order_date<br><br>";
$order_summary .= "Order Items:<br>";

foreach ($order_items as $item) {
    $order_summary .= "Product ID: " . htmlspecialchars($item['id']) . "<br>";
    $order_summary .= "Product Name: " . htmlspecialchars($item['name']) . "<br>";
    $order_summary .= "Price: " . htmlspecialchars($item['price']) . " PHP<br>";
    $order_summary .= "Quantity: " . htmlspecialchars($item['quantity']) . "<br>";
    $order_summary .= "<br>"; 
}

$order_summary .= "Total Price: " . htmlspecialchars($total_price) . " PHP<br>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <div><?php echo $order_summary; ?></div>
</body>
</html>
