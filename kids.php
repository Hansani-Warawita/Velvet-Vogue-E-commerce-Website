<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Collection - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <section class="section kids-section">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-child"></i>
                <span>Little Stars</span>
            </div>
            <h2 class="section-title">Kids Collection</h2>
            <div class="section-divider">
                <span class="divider-decoration">✨</span>
            </div>
            <p class="section-description">Browse our complete collection of fun, comfortable, and stylish clothing for your little ones</p>
        </div>
        <div class="product-grid">
            <?php 
            include('server/connection.php');
            
            $stmt = $conn->prepare("SELECT product_id, name, description, price, image, stock FROM products WHERE category_id = 3");
            $stmt->execute();
            $products = $stmt->get_result();
            
            while($row = $products->fetch_assoc()) {
            ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img class="product-image" src="img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                        <div class="product-overlay"></div>
                    </div>
                    <div class="product-details">
                        <h3 class="product-name"><?php echo $row['name']; ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars(substr($row['description'], 0, 80)); ?>...</p>
                        <p class="product-price">$<?php echo number_format($row['price'], 2); ?></p>
                        <div class="product-actions">
                            <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>" class="btn-primary">
                                <i class="fas fa-shopping-bag"></i>
                                Buy Now
                            </a>
                            <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>" class="btn-secondary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php include('footer and header/footer.php'); ?>

    <script>
        // Add scroll animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.product-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Section header animation
            const sectionHeader = document.querySelector('.section-header');
            const headerObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const badge = entry.target.querySelector('.section-badge');
                        const title = entry.target.querySelector('.section-title');
                        const divider = entry.target.querySelector('.section-divider');
                        const description = entry.target.querySelector('.section-description');
                        
                        if (badge) {
                            badge.style.animation = 'slideInDown 0.8s ease-out';
                        }
                        if (title) {
                            title.style.animation = 'fadeInUp 1s ease-out 0.2s both';
                        }
                        if (divider) {
                            divider.style.animation = 'scaleIn 0.6s ease-out 0.4s both';
                        }
                        if (description) {
                            description.style.animation = 'fadeInUp 0.8s ease-out 0.6s both';
                        }
                    }
                });
            }, { threshold: 0.3 });

            if (sectionHeader) {
                headerObserver.observe(sectionHeader);
            }

            // Add loading state for images
            const productImages = document.querySelectorAll('.product-image');
            productImages.forEach(img => {
                // Don't set opacity to 0 initially, images should be visible
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                    this.classList.remove('loading');
                });
                
                img.addEventListener('error', function() {
                    this.src = 'img/home2.jpg'; // Use an existing fallback image
                    this.alt = 'Product image not available';
                    console.log('Image failed to load:', this.getAttribute('src'));
                });
                
                // If image is already loaded
                if (img.complete) {
                    img.classList.add('loaded');
                } else {
                    img.classList.add('loading');
                }
            });
        });
    </script>
</body>
</html>
