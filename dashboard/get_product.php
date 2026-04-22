<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include('../server/connection.php');

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'product' => $product]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Product ID required']);
}
?>
