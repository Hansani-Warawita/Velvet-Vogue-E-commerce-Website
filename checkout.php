<?php
session_start();

// Check if cart exists and has items
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Require login for checkout
if (!isset($_SESSION['user_id'])) {
    // Store intended destination in session
    $_SESSION['checkout_redirect'] = true;
    header("Location: login.php?message=login_required");
    exit();
}

include('server/connection.php');

// Calculate order total
$total = 0;
$items = [];
foreach ($_SESSION['cart'] as $product_id => $item) {
    $stmt = $conn->prepare("SELECT product_id, name, price, image FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    
    if ($product) {
        $subtotal = $product['price'] * $item['quantity'];
        $total += $subtotal;
        $items[] = [
            'id' => $product['product_id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $item['quantity'],
            'subtotal' => $subtotal,
            'image' => $product['image']
        ];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['full_name', 'email', 'phone', 'address', 'city', 'state', 'zip_code'];
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " is required";
        }
    }
    
    if (empty($errors)) {
        try {
            // Insert order into database
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, full_name, email, phone, address, city, state, zip_code, status) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
            
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }
                                   
            $user_id = $_SESSION['user_id']; // User is guaranteed to be logged in at this point
            $stmt->bind_param("idsssssss", 
                $user_id, 
                $total,
                $_POST['full_name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['address'],
                $_POST['city'],
                $_POST['state'],
                $_POST['zip_code']
            );
            if (!$stmt->execute()) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
            
            $order_id = $conn->insert_id;
            
            // Insert order items
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            
            if (!$stmt) {
                throw new Exception("Error preparing order items statement: " . $conn->error);
            }
            
            foreach ($items as $item) {
                $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting order item: " . $stmt->error);
                }
                
                // Update product stock
                $update_stock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
                if (!$update_stock) {
                    throw new Exception("Error preparing stock update: " . $conn->error);
                }
                $update_stock->bind_param("ii", $item['quantity'], $item['id']);
                if (!$update_stock->execute()) {
                    throw new Exception("Error updating stock: " . $update_stock->error);
                }
            }
            
            // Clear cart
            unset($_SESSION['cart']);
            
            // Redirect to order confirmation
            header("Location: order_confirmation.php?order_id=" . $order_id);
            exit();
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <div class="checkout-container">
        <div class="section-header">
            <h2 class="section-title">Checkout</h2>
            <div class="section-divider"></div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="checkout-content">
            <div class="shipping-form">
                <h3>Shipping Information</h3>
                <form method="POST" class="checkout-form">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" value="<?php echo isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="zip_code">ZIP Code</label>
                            <input type="text" id="zip_code" name="zip_code" value="<?php echo isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="payment-methods">
                        <h3>Payment Method</h3>
                        <div class="payment-icons">
                            <img src="img/visa.png" alt="Visa">
                            <img src="img/master.png" alt="Mastercard">
                            <img src="img/unionpay.png" alt="UnionPay">
                        </div>
                        <p class="payment-note">Payment will be handled securely upon order completion</p>
                    </div>

                    <button type="submit" class="place-order-btn">Place Order</button>
                </form>
            </div>

            <div class="order-summary">
                <h3>Order Summary</h3>
                <div class="summary-items">
                    <?php foreach ($items as $item): ?>
                    <div class="summary-item">
                        <img src="img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="summary-item-image">
                        <div class="summary-item-details">
                            <h4><?php echo $item['name']; ?></h4>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <p>$<?php echo number_format($item['subtotal'], 2); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-totals">
                    <div class="subtotal">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="shipping">
                        <span>Shipping</span>
                        <span><?php echo $total >= 50 ? 'Free' : '$5.00'; ?></span>
                    </div>
                    <div class="total">
                        <span>Total</span>
                        <span>$<?php echo number_format($total >= 50 ? $total : $total + 5, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer and header/footer.php'); ?>
</body>
</html>
