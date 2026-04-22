<header>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="brand">Velvet Vogue</a>
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="women.php" class="nav-link">Women</a></li>
                <li><a href="men.php" class="nav-link">Men</a></li>
                <li><a href="kids.php" class="nav-link">Kids</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="user-welcome">
                        <span class="welcome-text">
                            <i class="fas fa-user"></i>
                            Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!
                        </span>
                    </li>
                    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <li><a href="dashboard/dashboard.php" class="nav-link admin-link">
                            <i class="fas fa-crown"></i> Admin
                        </a></li>
                    <?php endif; ?>
                    <li><a href="account.php" class="nav-link">Account</a></li>
                    <li><a href="logout.php" class="nav-link">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="nav-link">Login</a></li>
                    <li><a href="signup.php" class="nav-link">Sign Up</a></li>
                <?php endif; ?>
                <li>
                    <a href="cart.php" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <?php
                        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                            $count = count($_SESSION['cart']);
                            echo "<span class='cart-count'>$count</span>";
                        }
                        ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
.navbar {
    background: linear-gradient(135deg, #3C1919 0%, #EEA39D 50%, #FFD7C0 100%);
    padding: 1.2rem 0;
    box-shadow: 0 4px 20px rgba(60, 25, 25, 0.2);
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.nav-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.brand {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #ffffff 0%, #FFD7C0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-decoration: none;
    letter-spacing: 1px;
    text-shadow: 0 2px 10px rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.brand:hover {
    transform: translateY(-2px);
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.4));
}

.nav-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
    gap: 1rem;
}

.nav-link {
    color: rgba(255, 255, 255, 0.95);
    text-decoration: none;
    padding: 0.8rem 1.2rem;
    border-radius: 12px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 600;
    font-size: 0.95rem;
    position: relative;
    overflow: hidden;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    transform: scale(0);
    transition: transform 0.3s ease;
}

.nav-link:hover::before, .nav-link.active::before {
    transform: scale(1);
}

.nav-link:hover, .nav-link.active {
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
}

.user-welcome {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    padding: 0.8rem 1.2rem;
    margin: 0 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.welcome-text {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.welcome-text i {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
}

.cart-icon {
    position: relative;
    color: #ffffff;
    font-size: 1.4rem;
    padding: 0.8rem;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.cart-icon:hover {
    transform: scale(1.1) translateY(-2px);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
}

.cart-count {
    position: absolute;
    top: -2px;
    right: -2px;
    background: linear-gradient(135deg, #DC143C 0%, #FF1493 100%);
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    border: 2px solid #ffffff;
    box-shadow: 0 3px 10px rgba(220, 20, 60, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    color: #ffffff;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.menu-toggle:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: scale(1.1);
}

/* Mobile responsive styles */
@media (max-width: 768px) {
    .menu-toggle {
        display: block;
    }
    
    .nav-menu {
        position: fixed;
        top: 100%;
        left: 0;
        width: 100%;
        background: linear-gradient(135deg, #FF1493 0%, #FF69B4 50%, #FFB6C1 100%);
        backdrop-filter: blur(20px);
        flex-direction: column;
        padding: 2rem 0;
        gap: 1rem;
        transform: translateY(-100vh);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 30px rgba(255, 20, 147, 0.3);
    }
    
    .nav-menu.active {
        transform: translateY(0);
    }
    
    .nav-link {
        width: 90%;
        margin: 0 auto;
        text-align: center;
        padding: 1rem;
    }
    
    .user-welcome {
        width: 90%;
        margin: 0 auto;
        text-align: center;
    }
}

.admin-link {
    background: linear-gradient(135deg, #FFD7C0 0%, #EEA39D 100%) !important;
    color: #3C1919 !important;
    font-weight: 700 !important;
}

.admin-link:hover {
    background: linear-gradient(135deg, #EEA39D 0%, #3C1919 100%) !important;
    color: #FFD7C0 !important;
    box-shadow: 0 6px 20px rgba(238, 163, 157, 0.4) !important;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking on a link
        const navLinks = navMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
    }
});
</script>
