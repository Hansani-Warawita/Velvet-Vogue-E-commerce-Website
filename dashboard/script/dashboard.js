// Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Navigation handling
    const navItems = document.querySelectorAll('.nav-item');
    const contentSections = document.querySelectorAll('.content-section');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                
                // Remove active class from all nav items and sections
                navItems.forEach(nav => nav.classList.remove('active'));
                contentSections.forEach(section => section.classList.remove('active'));
                
                // Add active class to clicked nav item
                this.classList.add('active');
                
                // Show corresponding content section
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            }
        });
    });
    
    // Modal handling
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    const closeButtons = document.querySelectorAll('.close');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            editModal.style.display = 'none';
            deleteModal.style.display = 'none';
        });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === editModal) {
            editModal.style.display = 'none';
        }
        if (e.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});

// Edit Product Function
function editProduct(productId) {
    // Fetch product data
    fetch(`get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                
                // Fill the edit form
                document.getElementById('edit_product_id').value = product.product_id;
                document.getElementById('edit_name').value = product.name;
                document.getElementById('edit_description').value = product.description;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_category_id').value = product.category_id;
                document.getElementById('edit_stock').value = product.stock;
                
                // Show current image
                const imagePreview = document.getElementById('current_image_preview');
                if (product.image) {
                    imagePreview.innerHTML = `
                        <p>Current image:</p>
                        <img src="../img/${product.image}" alt="Current product image">
                    `;
                } else {
                    imagePreview.innerHTML = '<p>No current image</p>';
                }
                
                // Show modal
                document.getElementById('editModal').style.display = 'block';
            } else {
                alert('Error loading product data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading product data');
        });
}

// Delete Product Function
function deleteProduct(productId) {
    document.getElementById('delete_product_id').value = productId;
    document.getElementById('deleteModal').style.display = 'block';
}

// Close Delete Modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Form validation
function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            field.style.borderColor = '#e0e0e0';
        }
    });
    
    return isValid;
}

// File upload preview
document.addEventListener('change', function(e) {
    if (e.target.type === 'file' && e.target.accept.includes('image')) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = e.target.closest('.form-group').querySelector('.image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.style.marginTop = '1rem';
                    e.target.closest('.form-group').appendChild(preview);
                }
                preview.innerHTML = `
                    <p>Preview:</p>
                    <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                `;
            };
            reader.readAsDataURL(file);
        }
    }
});

// Search functionality for products table
function addSearchFunctionality() {
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search products...';
    searchInput.style.cssText = `
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        margin-bottom: 1rem;
        width: 300px;
    `;
    
    const productsSection = document.getElementById('products');
    const tableContainer = productsSection.querySelector('.products-table-container');
    tableContainer.parentNode.insertBefore(searchInput, tableContainer);
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('.products-table tbody tr');
        
        tableRows.forEach(row => {
            const productName = row.querySelector('.product-name').textContent.toLowerCase();
            const category = row.cells[2].textContent.toLowerCase();
            
            if (productName.includes(searchTerm) || category.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// Initialize search functionality when products section is shown
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(addSearchFunctionality, 100);
});

// Smooth animations
function addSmoothAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        .content-section {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .content-section.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .stat-card {
            animation: slideInUp 0.6s ease forwards;
        }
        
        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }
        
        .stat-card:nth-child(3) {
            animation-delay: 0.2s;
        }
        
        .stat-card:nth-child(4) {
            animation-delay: 0.3s;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
}

// Initialize animations
document.addEventListener('DOMContentLoaded', addSmoothAnimations);
