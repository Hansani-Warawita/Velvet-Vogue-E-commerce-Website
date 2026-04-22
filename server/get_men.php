<?php
include('connection.php');

$stmt = $conn->prepare("SELECT product_id, name, description, price, image, stock 
                       FROM products 
                       WHERE category_id = 2
                       LIMIT 3");
$stmt->execute();
$men_products = $stmt->get_result();
?>