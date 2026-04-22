<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle cart actions (add, remove, update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_from_cart'])) {
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    } else if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = max(1, min(10, (int)$_POST['quantity'])); // Limit quantity between 1 and 10
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        }
    }
}

// Calculate cart total
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <div class="cart-container">
        <div class="section-header">
            <h2 class="section-title">Shopping Cart</h2>
            <div class="section-divider"></div>
        </div>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart fa-3x" style="color: #ddd; margin-bottom: 1rem;"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="index.php" class="continue-shopping">Continue Shopping</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include('server/connection.php');
                    foreach ($_SESSION['cart'] as $product_id => $item): 
                        $stmt = $conn->prepare("SELECT product_id, name, price, image FROM products WHERE product_id = ?");
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $product = $stmt->get_result()->fetch_assoc();
                        
                        if ($product):
                            $subtotal = $product['price'] * $item['quantity'];
                            $total += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <img src="img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="cart-product-image">
                            </td>
                            <td><?php echo $product['name']; ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10" class="quantity-input" onchange="this.form.submit()" style="width: 60px;">
                                    <input type="hidden" name="update_quantity" value="1">
                                </form>
                            </td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <button type="submit" name="remove_from_cart" class="remove-button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="cart-total">
                    Total: $<?php echo number_format($total, 2); ?>
                </div>
                <a href="checkout.php" class="checkout-button">
                    Proceed to Checkout
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php include('footer and header/footer.php'); ?>

    <script>
        // This script is now handled in header.php
    </script>
</body>
</html>
