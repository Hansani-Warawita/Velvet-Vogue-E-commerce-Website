<?php
session_start();

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('server/connection.php');

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Get order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: index.php");
    exit();
}

// Get order items
$stmt = $conn->prepare("
    SELECT oi.*, p.name, p.image 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.product_id 
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <div class="confirmation-container">
        <div class="confirmation-header">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Order Confirmed!</h1>
            <p>Thank you for your purchase. Your order has been successfully placed.</p>
        </div>

        <div class="order-details">
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="order-info">
                    <p><strong>Order Number:</strong> #<?php echo $order['order_id']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                    <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
                    <p><strong>Status:</strong> <span class="status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></p>
                </div>
            </div>

            <div class="shipping-info">
                <h3>Shipping Information</h3>
                <p><strong><?php echo htmlspecialchars($order['full_name']); ?></strong></p>
                <p><?php echo htmlspecialchars($order['address']); ?></p>
                <p><?php echo htmlspecialchars($order['city'] . ', ' . $order['state'] . ' ' . $order['zip_code']); ?></p>
                <p><?php echo htmlspecialchars($order['phone']); ?></p>
                <p><?php echo htmlspecialchars($order['email']); ?></p>
            </div>

            <div class="order-items">
                <h3>Items Ordered</h3>
                <div class="items-list">
                    <?php while ($item = $order_items->fetch_assoc()): ?>
                        <div class="order-item">
                            <img src="img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="item-image">
                            <div class="item-details">
                                <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                <p>Quantity: <?php echo $item['quantity']; ?></p>
                                <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                                <p>Subtotal: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <div class="confirmation-actions">
            <a href="account.php" class="button secondary">View My Orders</a>
            <a href="index.php" class="button primary">Continue Shopping</a>
        </div>
    </div>

    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        .confirmation-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .confirmation-header h1 {
            color: #28a745;
            margin-bottom: 0.5rem;
        }

        .order-details {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .order-summary, .shipping-info, .order-items {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .order-summary:last-child, .shipping-info:last-child, .order-items:last-child {
            border-bottom: none;
        }

        .order-info p {
            margin-bottom: 0.5rem;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-processing {
            color: #17a2b8;
            font-weight: bold;
        }

        .status-shipped {
            color: #28a745;
            font-weight: bold;
        }

        .items-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .order-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-details h4 {
            margin-bottom: 0.5rem;
        }

        .item-details p {
            margin-bottom: 0.25rem;
            color: #666;
        }

        .confirmation-actions {
            text-align: center;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .button.primary {
            background-color: #007bff;
            color: white;
        }

        .button.primary:hover {
            background-color: #0056b3;
        }

        .button.secondary {
            background-color: #6c757d;
            color: white;
        }

        .button.secondary:hover {
            background-color: #545b62;
        }

        @media (max-width: 768px) {
            .confirmation-actions {
                flex-direction: column;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <?php include('footer and header/footer.php'); ?>
</body>
</html>
