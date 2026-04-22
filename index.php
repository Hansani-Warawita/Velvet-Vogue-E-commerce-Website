<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velvet Vogue - Luxury Fashion Redefined</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <!-- Modern Hero Cover Section -->
    <section class="hero-cover">
        <div class="hero-background">
            <img src="img/home2.jpg" alt="Velvet Vogue Luxury Fashion" class="hero-image">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <span class="hero-accent">✨</span>
                    Luxury Fashion Redefined
                    <span class="hero-accent">✨</span>
                </h1>
                <p class="hero-subtitle">Discover the latest trends in premium fashion with unmatched quality and style.</p>
                <div class="hero-buttons">
                    <a href="#women" class="hero-btn primary">
                        <i class="fas fa-shopping-bag"></i>
                        Shop Now
                    </a>
                    <a href="#about" class="hero-btn secondary">
                        <i class="fas fa-play"></i>
                        Discover More
                    </a>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Women's Section -->
    <section id="women" class="section">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-female"></i>
                <span>Premium Collection</span>
            </div>
            <h2 class="section-title">Women's Collection</h2>
            <div class="section-divider">
                <span class="divider-decoration">✨</span>
            </div>
            <p class="section-description">Elegant and fashionable clothing designed for the confident, modern woman</p>
        </div>
        <div class="product-grid">
            <?php include('server/get_women.php') ?>
            <?php while($row= $women_products->fetch_assoc()){?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img class="product-image" src="img/<?php echo $row['image'];?>" alt="<?php echo $row['name'];?>">
                        
                    </div>
                    <div class="product-details">
                        
                        <h3 class="product-name"><?php echo $row['name'];?></h3>
                        <p class="product-price">$<?php echo $row['price'];?></p>
                        <a href="<?php echo "single_product.php?product_id=". $row['product_id'];?>">
                            <button class="buy-button">
                                <i class="fas fa-shopping-bag"></i>
                                Add to Cart
                            </button>
                        </a>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="text-center">
            <a href="women.php" class="view-all-button">
                <i class="fas fa-arrow-right"></i>
                Explore All Women's Products
            </a>
        </div>
    </section>

    <!-- Men's Section -->
    <section id="men" class="section">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-male"></i>
                <span>Gentleman's Choice</span>
            </div>
            <h2 class="section-title">Men's Collection</h2>
            <div class="section-divider">
                <span class="divider-decoration">✨</span>
            </div>
            <p class="section-description">Professional and casual wear crafted for the sophisticated gentleman</p>
        </div>
        <div class="product-grid">
            <?php include('server/get_men.php') ?>
            <?php while($row= $men_products->fetch_assoc()){?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img class="product-image" src="img/<?php echo $row['image'];?>" alt="<?php echo $row['name'];?>">
                        
                    </div>
                    <div class="product-details">
                        
                        <h3 class="product-name"><?php echo $row['name'];?></h3>
                        <p class="product-price">$<?php echo $row['price'];?></p>
                        <a href="<?php echo "single_product.php?product_id=". $row['product_id'];?>">
                            <button class="buy-button">
                                <i class="fas fa-shopping-bag"></i>
                                Add to Cart
                            </button>
                        </a>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="text-center">
            <a href="men.php" class="view-all-button">
                <i class="fas fa-arrow-right"></i>
                Explore All Men's Products
            </a>
        </div>
    </section>

    <!-- Children's Section -->
    <section id="children" class="section">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-child"></i>
                <span>Little Stars</span>
            </div>
            <h2 class="section-title">Kids Collection</h2>
            <div class="section-divider">
                <span class="divider-decoration">✨</span>
            </div>
            <p class="section-description">Fun, comfortable, and stylish clothing designed for your little ones</p>
        </div>
        <div class="product-grid">
            <?php include('server/get_children.php') ?>
            <?php while($row= $children_products->fetch_assoc()){?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img class="product-image" src="img/<?php echo $row['image'];?>" alt="<?php echo $row['name'];?>">
                        
                    </div>
                    <div class="product-details">
                        
                        <h3 class="product-name"><?php echo $row['name'];?></h3>
                        <p class="product-price">$<?php echo $row['price'];?></p>
                        <a href="<?php echo "single_product.php?product_id=". $row['product_id'];?>">
                            <button class="buy-button">
                                <i class="fas fa-shopping-bag"></i>
                                Add to Cart
                            </button>
                        </a>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="text-center">
            <a href="kids.php" class="view-all-button">
                <i class="fas fa-arrow-right"></i>
                Explore All Kids Products
            </a>
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

            // Smooth scroll for hero buttons
            document.querySelectorAll('.hero-btn[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Hero scroll indicator
            const scrollIndicator = document.querySelector('.scroll-arrow');
            if (scrollIndicator) {
                scrollIndicator.addEventListener('click', function() {
                    const womenSection = document.querySelector('#women');
                    if (womenSection) {
                        womenSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }

            // Parallax effect for hero
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('.hero-background');
                if (hero) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Section header animations
            const sectionHeaders = document.querySelectorAll('.section-header');
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

            sectionHeaders.forEach(header => {
                headerObserver.observe(header);
            });
        });
    </script>
</body>
</html>
               
         