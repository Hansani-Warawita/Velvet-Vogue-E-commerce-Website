# Velvet Vogue Admin Dashboard

## Overview
A comprehensive admin dashboard for managing products in the Velvet Vogue e-commerce website.

## Features
- **Product Management**: Add, edit, and delete products
- **Dashboard Overview**: View statistics including total products, stock, inventory value, and users
- **Category Management**: Products are organized by categories (Women, Men, Children)
- **Image Upload**: Support for product image uploads
- **Search Functionality**: Search products by name or category
- **Responsive Design**: Works on desktop and mobile devices

## Access Instructions

### Admin Login
1. Navigate to `http://localhost/velvet_vogue2/login.php`
2. Use admin credentials:
   - **Email**: admin@velvetvogue.com
   - **Password**: admin123 (default password hash in database)

### Dashboard Navigation
After logging in as admin, you'll be redirected to the dashboard at:
`http://localhost/velvet_vogue2/dashboard/dashboard.php`

## Dashboard Sections

### 1. Overview
- Displays key statistics
- Total products count
- Total stock quantity
- Inventory value
- Number of registered users

### 2. Products
- View all products in a table format
- Product thumbnail, name, category, price, and stock
- Edit and delete actions for each product
- Search functionality to filter products

### 3. Add Product
- Form to add new products
- Required fields:
  - Product name
  - Category selection
  - Price
  - Stock quantity
  - Description
  - Product image

## File Structure
```
dashboard/
├── dashboard.php          # Main dashboard file
├── get_product.php       # API endpoint for fetching product data
├── style/
│   └── dashboard.css     # Dashboard styling
└── script/
    └── dashboard.js      # Dashboard JavaScript functionality
```

## Database Requirements
The dashboard works with the following database tables:
- `users` - User accounts and admin status
- `products` - Product information
- `categories` - Product categories
- `product_images` - Additional product images (optional)

## Security Features
- Admin authentication required
- Session-based access control
- SQL injection protection with prepared statements
- File upload validation for images
- XSS protection with htmlspecialchars()

## Key Functions

### Add Product
1. Fill out the product form
2. Upload a product image
3. Submit to add to database

### Edit Product
1. Click edit button on any product
2. Modal opens with current product data
3. Modify fields as needed
4. Submit to update

### Delete Product
1. Click delete button on any product
2. Confirmation modal appears
3. Confirm to permanently delete

## Browser Compatibility
- Chrome (recommended)
- Firefox
- Safari
- Edge

## Responsive Design
The dashboard is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

## Admin Navigation
When logged in as admin, the main site header includes an "Admin" link with a crown icon that provides quick access to the dashboard from anywhere on the site.

## Troubleshooting

### Common Issues
1. **403 Forbidden**: Ensure you're logged in as admin
2. **Image Upload Failed**: Check file permissions on img/ folder
3. **Database Connection Error**: Verify XAMPP MySQL is running
4. **Session Issues**: Clear browser cookies and cache

### Technical Requirements
- PHP 7.0 or higher
- MySQL/MariaDB
- Web server (Apache recommended)
- Modern web browser with JavaScript enabled
