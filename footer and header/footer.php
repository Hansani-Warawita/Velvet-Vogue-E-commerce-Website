<footer class="modern-footer">
    <div class="footer-wave">
        <svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,64L48,58.7C96,53,192,43,288,53.3C384,64,480,96,576,101.3C672,107,768,85,864,80C960,75,1056,85,1152,85.3L1200,85.3L1200,120L1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="url(#gradient)"></path>
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#EEA39D;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#FFD7C0;stop-opacity:1" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <div class="footer-main">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- Brand Section -->
                <div class="footer-brand">
                    <div class="brand-logo">
                        <h3>✨ Velvet Vogue</h3>
                        <span class="brand-tagline">Luxury Fashion Redefined</span>
                    </div>
                    <p class="brand-description">
                        Your premier destination for elegant and fashionable clothing. 
                        Discover the latest trends in premium fashion with unmatched quality and style.
                    </p>
                    <div class="social-section">
                        <h5>Follow Us</h5>
                        <div class="social-links">
                            <a href="#" class="social-link facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link twitter" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link pinterest" aria-label="Pinterest">
                                <i class="fab fa-pinterest"></i>
                            </a>
                            <a href="#" class="social-link youtube" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="footer-column">
                    <h4 class="footer-title">
                        <i class="fas fa-shopping-bag"></i>
                        Shop Collections
                    </h4>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="women.php"><i class="fas fa-female"></i> Women's Fashion</a></li>
                        <li><a href="men.php"><i class="fas fa-male"></i> Men's Fashion</a></li>
                        <li><a href="kids.php"><i class="fas fa-child"></i> Kids Collection</a></li>
                        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Shopping Cart</a></li>
                    </ul>
                </div>
                
                <!-- Customer Service -->
                <div class="footer-column">
                    <h4 class="footer-title">
                        <i class="fas fa-headset"></i>
                        Customer Care
                    </h4>
                    <ul class="footer-links">
                        <li><a href="#" onclick="showModal('Contact us at: support@velvetvogue.com')">
                            <i class="fas fa-envelope"></i> Contact Support
                        </a></li>
                        <li><a href="#" onclick="showModal('Fast & Free shipping on orders over $50')">
                            <i class="fas fa-truck"></i> Shipping Info
                        </a></li>
                        <li><a href="#" onclick="showModal('Easy 30-day returns & exchanges')">
                            <i class="fas fa-undo"></i> Returns & Exchanges
                        </a></li>
                        <li><a href="#" onclick="showModal('Complete size guide available')">
                            <i class="fas fa-ruler"></i> Size Guide
                        </a></li>
                        <li><a href="#" onclick="showModal('Frequently asked questions')">
                            <i class="fas fa-question-circle"></i> FAQ
                        </a></li>
                    </ul>
                </div>
                
                <!-- Newsletter & Contact -->
                <div class="footer-column newsletter-section">
                    <h4 class="footer-title">
                        <i class="fas fa-bell"></i>
                        Stay Updated
                    </h4>
                    <p class="newsletter-description">
                        Subscribe to our newsletter for exclusive offers, new arrivals, and fashion tips!
                    </p>
                    <form class="newsletter-form" onsubmit="return subscribeNewsletter(event)">
                        <div class="input-group">
                            <input type="email" placeholder="Enter your email address" class="newsletter-input" required>
                            <button type="submit" class="newsletter-btn">
                                <i class="fas fa-paper-plane"></i>
                                Subscribe
                            </button>
                        </div>
                    </form>
                    
                    <div class="contact-info">
                        <h5>Contact Info</h5>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>support@velvetvogue.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>Mon-Fri: 9AM-6PM EST</span>
                        </div>
                    </div>
                    
                    <div class="payment-section">
                        <h5>Secure Payments</h5>
                        <div class="payment-methods">
                            <img src="img/visa.png" alt="Visa" class="payment-icon">
                            <img src="img/master.png" alt="Mastercard" class="payment-icon">
                            <img src="img/unionpay.png" alt="UnionPay" class="payment-icon">
                            <img src="img/mintpay.png" alt="MintPay" class="payment-icon">
                        </div>
                        <div class="security-badges">
                            <span class="badge">🔒 SSL Secured</span>
                            <span class="badge">✅ Trusted Store</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-container">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> Velvet Vogue. All rights reserved.</p>
                    <p class="tagline">Crafted with 💜 for fashion lovers worldwide</p>
                </div>
                <div class="footer-bottom-links">
                    <a href="#" onclick="showModal('Privacy Policy - We respect your privacy and protect your data.')">Privacy Policy</a>
                    <a href="#" onclick="showModal('Terms of Service - Please read our terms and conditions.')">Terms of Service</a>
                    <a href="#" onclick="showModal('Cookie Policy - We use cookies to enhance your experience.')">Cookie Policy</a>
                    <a href="#" onclick="showModal('Accessibility - We are committed to digital accessibility.')">Accessibility</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>
</footer>

<!-- Modal for displaying information -->
<div id="infoModal" class="modal" onclick="closeModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <p id="modalText"></p>
    </div>
</div>

<style>
/* Modern Footer Styles */
.modern-footer {
    position: relative;
    margin-top: 4rem;
    background: linear-gradient(135deg, #3C1919 0%, #2a1212 50%, #1a0a0a 100%);
    color: #ffffff;
    overflow: hidden;
}

.footer-wave {
    position: absolute;
    top: -1px;
    left: 0;
    width: 100%;
    height: 60px;
    z-index: 1;
}

.footer-wave svg {
    width: 100%;
    height: 100%;
    display: block;
}

.footer-main {
    position: relative;
    z-index: 2;
    padding: 4rem 0 2rem;
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

/* Brand Section */
.footer-brand {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.brand-logo h3 {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #FFD7C0 0%, #EEA39D 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.brand-tagline {
    font-size: 0.9rem;
    color: #FFD7C0;
    font-style: italic;
    margin-left: 1rem;
}

.brand-description {
    color: #FFD7C0;
    line-height: 1.7;
    font-size: 0.95rem;
}

.social-section h5 {
    font-size: 1rem;
    margin-bottom: 1rem;
    color: #ffffff;
    font-weight: 600;
}

.social-links {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    text-decoration: none;
    color: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.social-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    transform: scale(0);
    transition: transform 0.3s ease;
}

.social-link.facebook::before { background: #1877F2; }
.social-link.instagram::before { background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D); }
.social-link.twitter::before { background: #1DA1F2; }
.social-link.pinterest::before { background: #BD081C; }
.social-link.youtube::before { background: #FF0000; }

.social-link {
    border: 2px solid rgba(238, 163, 157, 0.3);
}

.social-link:hover::before {
    transform: scale(1);
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
}

/* Footer Columns */
.footer-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.footer-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.footer-title i {
    color: #EEA39D;
    font-size: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.footer-links a {
    color: #FFD7C0;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.3rem 0;
}

.footer-links a i {
    color: #EEA39D;
    font-size: 0.8rem;
    width: 16px;
}

.footer-links a:hover {
    color: #EEA39D;
    transform: translateX(5px);
}

/* Newsletter Section */
.newsletter-section {
    background: rgba(255, 215, 192, 0.1);
    padding: 2rem;
    border-radius: 20px;
    border: 1px solid rgba(238, 163, 157, 0.3);
    backdrop-filter: blur(10px);
}

.newsletter-description {
    color: #FFD7C0;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.newsletter-form {
    margin-bottom: 2rem;
}

.input-group {
    display: flex;
    gap: 0.5rem;
    flex-direction: column;
}

.newsletter-input {
    flex: 1;
    padding: 1rem;
    border: 2px solid rgba(238, 163, 157, 0.3);
    border-radius: 12px;
    background: rgba(255, 215, 192, 0.1);
    color: #ffffff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.newsletter-input::placeholder {
    color: #FFD7C0;
}

.newsletter-input:focus {
    outline: none;
    border-color: #EEA39D;
    box-shadow: 0 0 0 3px rgba(238, 163, 157, 0.2);
}

.newsletter-btn {
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #EEA39D 0%, #3C1919 100%);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238, 163, 157, 0.3);
}

/* Contact Info */
.contact-info h5,
.payment-section h5 {
    font-size: 0.9rem;
    margin-bottom: 1rem;
    color: #ffffff;
    font-weight: 600;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 0.8rem;
    color: #FFD7C0;
    font-size: 0.85rem;
}

.contact-item i {
    color: #EEA39D;
    width: 16px;
    text-align: center;
}

/* Payment Section */
.payment-methods {
    display: flex;
    gap: 0.8rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.payment-icon {
    height: 32px;
    width: auto;
    padding: 0.3rem;
    background: rgba(255, 215, 192, 0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.payment-icon:hover {
    background: rgba(238, 163, 157, 0.2);
    transform: translateY(-2px);
}

.security-badges {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.badge {
    font-size: 0.8rem;
    color: #FFD7C0;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

/* Footer Bottom */
.footer-bottom {
    background: rgba(60, 25, 25, 0.3);
    padding: 1.5rem 0;
    border-top: 1px solid rgba(238, 163, 157, 0.3);
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.copyright p {
    margin: 0;
    color: #FFD7C0;
    font-size: 0.9rem;
}

.tagline {
    font-size: 0.8rem !important;
    color: #EEA39D !important;
}

.footer-bottom-links {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.footer-bottom-links a {
    color: #FFD7C0;
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.3s ease;
}

.footer-bottom-links a:hover {
    color: #EEA39D;
}

/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #EEA39D 0%, #3C1919 100%);
    color: #ffffff;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    opacity: 0;
    visibility: hidden;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(238, 163, 157, 0.3);
}

.back-to-top.visible {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(238, 163, 157, 0.4);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
}

.modal-content {
    background: #ffffff;
    margin: 15% auto;
    padding: 2rem;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1.5rem;
    font-size: 2rem;
    font-weight: bold;
    cursor: pointer;
    color: #999;
    transition: color 0.3s ease;
}

.modal-close:hover {
    color: #333;
}

#modalText {
    color: #333;
    font-size: 1rem;
    line-height: 1.6;
    margin-top: 1rem;
}



</style>

<script>
// Newsletter subscription
function subscribeNewsletter(event) {
    event.preventDefault();
    const email = event.target.querySelector('.newsletter-input').value;
    showModal(`Thank you for subscribing with ${email}! You'll receive our latest updates and exclusive offers.`);
    event.target.reset();
    return false;
}

// Modal functions
function showModal(message) {
    document.getElementById('modalText').textContent = message;
    document.getElementById('infoModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('infoModal').style.display = 'none';
}

// Back to top functionality
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/hide back to top button
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.classList.add('visible');
    } else {
        backToTop.classList.remove('visible');
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>
