<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit();
}

include('../server/connection.php');

// Handle form submissions
$message = '';
$error = '';

// Add Product
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $stock = intval($_POST['stock']);
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO products (category_id, name, description, price, image, stock) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issdsi", $category_id, $name, $description, $price, $image, $stock);
            
            if ($stmt->execute()) {
                $message = "Product added successfully!";
            } else {
                $error = "Error adding product: " . $conn->error;
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "Please select an image file.";
    }
}

// Update Product
if (isset($_POST['update_product'])) {
    $product_id = intval($_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $stock = intval($_POST['stock']);
    
    // Check if new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE products SET category_id=?, name=?, description=?, price=?, image=?, stock=? WHERE product_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issdsii", $category_id, $name, $description, $price, $image, $stock, $product_id);
        } else {
            $error = "Error uploading image.";
        }
    } else {
        $sql = "UPDATE products SET category_id=?, name=?, description=?, price=?, stock=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issdii", $category_id, $name, $description, $price, $stock, $product_id);
    }
    
    if (isset($stmt) && $stmt->execute()) {
        $message = "Product updated successfully!";
    } else {
        $error = "Error updating product: " . $conn->error;
    }
}

// Delete Product
if (isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);
    
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $error = "Error deleting product: " . $conn->error;
    }
}

// Get all products
$products_query = "SELECT p.*, c.name as category_name FROM products p 
                   LEFT JOIN categories c ON p.category_id = c.category_id 
                   ORDER BY p.created_at DESC";
$products_result = mysqli_query($conn, $products_query);

// Get categories for dropdown
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories_result = mysqli_query($conn, $categories_query);
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../sytle/style.css">
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-crown"></i> Admin Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#overview" class="nav-item active"><i class="fas fa-tachometer-alt"></i> Overview</a></li>
                    <li><a href="#products" class="nav-item"><i class="fas fa-box"></i> Products</a></li>
                    <li><a href="#add-product" class="nav-item"><i class="fas fa-plus"></i> Add Product</a></li>
                    <li><a href="../index.php" class="nav-item"><i class="fas fa-home"></i> Back to Site</a></li>
                    <li><a href="../logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="dashboard-header">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
                <div class="header-actions">
                    <span class="date"><?php echo date('F j, Y'); ?></span>
                </div>
            </header>

            <!-- Messages -->
            <?php if ($message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Overview Section -->
            <section id="overview" class="content-section active">
                <h2>Dashboard Overview</h2>
                <div class="stats-grid">
                    <?php
                    // Get statistics
                    $total_products = mysqli_num_rows($products_result);
                    mysqli_data_seek($products_result, 0);
                    
                    $total_stock = 0;
                    $total_value = 0;
                    while ($row = mysqli_fetch_assoc($products_result)) {
                        $total_stock += $row['stock'];
                        $total_value += $row['price'] * $row['stock'];
                    }
                    mysqli_data_seek($products_result, 0);
                    
                    $users_query = "SELECT COUNT(*) as total_users FROM users WHERE is_admin = 0";
                    $users_result = mysqli_query($conn, $users_query);
                    $users_data = mysqli_fetch_assoc($users_result);
                    ?>
                    
                    <div class="stat-card">
                        <i class="fas fa-box stat-icon"></i>
                        <div class="stat-info">
                            <h3><?php echo $total_products; ?></h3>
                            <p>Total Products</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-warehouse stat-icon"></i>
                        <div class="stat-info">
                            <h3><?php echo $total_stock; ?></h3>
                            <p>Total Stock</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-dollar-sign stat-icon"></i>
                        <div class="stat-info">
                            <h3>$<?php echo number_format($total_value, 2); ?></h3>
                            <p>Inventory Value</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-users stat-icon"></i>
                        <div class="stat-info">
                            <h3><?php echo $users_data['total_users']; ?></h3>
                            <p>Total Users</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Products Section -->
            <section id="products" class="content-section">
                <h2>Product Management</h2>
                <div class="products-table-container">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                            <tr>
                                <td>
                                    <img src="../img/<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                         class="product-thumbnail">
                                </td>
                                <td>
                                    <div class="product-name">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                        <small><?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...</small>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <span class="stock-badge <?php echo $product['stock'] < 10 ? 'low-stock' : ''; ?>">
                                        <?php echo $product['stock']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-edit" onclick="editProduct(<?php echo $product['product_id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-delete" onclick="deleteProduct(<?php echo $product['product_id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Add Product Section -->
            <section id="add-product" class="content-section">
                <h2>Add New Product</h2>
                <form class="product-form" method="POST" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Price ($)</label>
                            <input type="number" id="price" name="price" step="0.01" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="stock">Stock Quantity</label>
                            <input type="number" id="stock" name="stock" min="0" required>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="image">Product Image</label>
                            <input type="file" id="image" name="image" accept="image/*" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="add_product" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Product
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit_product_id" name="product_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_name">Product Name</label>
                        <input type="text" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_category_id">Category</label>
                        <select id="edit_category_id" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_price">Price ($)</label>
                        <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_stock">Stock Quantity</label>
                        <input type="number" id="edit_stock" name="stock" min="0" required>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="edit_description">Description</label>
                        <textarea id="edit_description" name="description" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="edit_image">Product Image (leave empty to keep current)</label>
                        <input type="file" id="edit_image" name="image" accept="image/*">
                        <div id="current_image_preview"></div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="update_product" class="btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this product? This action cannot be undone.</p>
            <form id="deleteForm" method="POST">
                <input type="hidden" id="delete_product_id" name="product_id">
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" name="delete_product" class="btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="script/dashboard.js"></script>
</body>
</html>
