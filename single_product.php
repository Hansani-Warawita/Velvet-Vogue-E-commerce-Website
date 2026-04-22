<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = max(1, min(10, (int)$_POST['quantity'])); // Limit quantity between 1 and 10
    
    // Get product price from database
    include('server/connection.php');
    $stmt = $conn->prepare("SELECT price FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if ($product) {
        // Add or update cart item with price
        $_SESSION['cart'][$product_id] = [
            'quantity' => $quantity,
            'price' => $product['price']
        ];
    }
    
    // Redirect to prevent form resubmission
    header("Location: single_product.php?product_id=" . $product_id . "&added=1");
    exit();
}

include('server/connection.php');

if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    // Get all product images ordered by display_order
    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order ASC");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product_images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Get the main image
    $main_image = array_filter($product_images, function($img) {
        return $img['is_main'] == 1;
    });
    $main_image = reset($main_image) ?: $product_images[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <div class="single-product">
        <div class="product-gallery">
            <div class="main-image">
                <img src="img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" id="mainImage">
            </div>
            <?php if (!empty($product_images)): ?>
            <div class="thumbnail-images">
                <?php foreach($product_images as $image): ?>
                    <img 
                        src="img/<?php echo $image['image_path']; ?>" 
                        alt="<?php echo $product['name']; ?>" 
                        class="thumbnail <?php echo ($image['is_main'] ? 'active' : ''); ?>" 
                        onclick="changeImage(this.src)"
                    >
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="product-details">
            <?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Product added to cart successfully!
                </div>
            <?php endif; ?>

            <h1 class="product-title"><?php echo $product['name']; ?></h1>
            <div class="product-price"><?php echo number_format($product['price'], 2); ?></div>
            
            <div class="product-description">
                <?php echo $product['description']; ?>
            </div>

            <div class="product-stock">
                <?php if ($product['stock'] > 0): ?>
                    <span class="in-stock"><i class="fas fa-check"></i> In Stock (<?php echo $product['stock']; ?> available)</span>
                <?php else: ?>
                    <span class="out-of-stock"><i class="fas fa-times"></i> Out of Stock</span>
                <?php endif; ?>
            </div>

            <form method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                
                <div class="quantity-selector">
                    <button type="button" onclick="updateQuantity(-1)" class="quantity-btn">-</button>
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo min(10, $product['stock']); ?>" class="quantity-input" id="quantity">
                    <button type="button" onclick="updateQuantity(1)" class="quantity-btn">+</button>
                </div>

                <button type="submit" name="add_to_cart" class="add-to-cart-btn" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                    <i class="fas fa-shopping-cart"></i>
                    Add to Cart
                </button>
            </form>

            <div class="product-meta">
                <div class="delivery-info">
                    <i class="fas fa-truck"></i>
                    Free shipping on orders over $50
                </div>
                <div class="return-info">
                    <i class="fas fa-undo"></i>
                    30-day return policy
                </div>
            </div>
        </div>
    </div>

    <?php include('footer and header/footer.php'); ?>

    <script>
        function updateQuantity(change) {
            const input = document.getElementById('quantity');
            const newValue = Math.max(1, Math.min(<?php echo min(10, $product['stock']); ?>, parseInt(input.value) + change));
            input.value = newValue;
        }

        function changeImage(src) {
            const mainImage = document.getElementById('mainImage');
            const img = new Image();
            img.src = src;
            
            mainImage.classList.add('loading');
            
            img.onload = function() {
                mainImage.src = src;
                mainImage.classList.remove('loading');
                
                document.querySelectorAll('.thumbnail').forEach(thumb => {
                    thumb.classList.remove('active');
                    if(thumb.src === src) {
                        thumb.classList.add('active');
                    }
                });
            };
        }

        // Add page load animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on page load
            const animateElements = document.querySelectorAll('.product-gallery, .product-details');
            animateElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Add click animation to add to cart button
            const addToCartBtn = document.querySelector('.add-to-cart-btn');
            if (addToCartBtn && !addToCartBtn.disabled) {
                addToCartBtn.addEventListener('click', function(e) {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            }

            // Auto-hide success messages
            const successMessages = document.querySelectorAll('.success-message');
            successMessages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        message.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>

    
</body>
</html>
