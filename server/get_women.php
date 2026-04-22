<?php
include('connection.php');

$stmt = $conn->prepare("SELECT product_id, name, description, price, image, stock 
                       FROM products 
                       WHERE category_id = 1
                       LIMIT 3");
$stmt->execute();
$women_products = $stmt->get_result();
?>