<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('server/connection.php');

// Get user information
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get user orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <div class="account-container">
        <div class="section-header">
            <h2 class="section-title">My Account</h2>
            <div class="section-divider"></div>
        </div>

        <div class="account-content">
            <div class="account-sidebar">
                <div class="user-info">
                    <h3>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <ul class="account-menu">
                    <li><a href="#profile" class="account-link active">Profile</a></li>
                    <li><a href="#orders" class="account-link">Orders</a></li>
                    <li><a href="logout.php" class="account-link">Logout</a></li>
                </ul>
            </div>

            <div class="account-main">
                <div class="account-section" id="profile">
                    <h3>Profile Information</h3>
                    <div class="profile-info">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                    </div>
                    <div class="profile-actions">
                        <a href="account_information.php" class="btn-edit-profile">
                            <i class="fas fa-edit"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>

                <div class="account-section" id="orders">
                    <h3>Order History</h3>
                    <?php if ($orders->num_rows > 0): ?>
                        <div class="orders-list">
                            <?php while ($order = $orders->fetch_assoc()): ?>
                                <div class="order-item">
                                    <div class="order-header">
                                        <h4>Order #<?php echo $order['order_id']; ?></h4>
                                        <span class="order-status status-<?php echo $order['status']; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                                        <p><strong>Total:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
                                        <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['address'] . ', ' . $order['city'] . ', ' . $order['state'] . ' ' . $order['zip_code']); ?></p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p>No orders found. <a href="index.php">Start shopping!</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer and header/footer.php'); ?>
</body>
</html>
