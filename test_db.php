<?php
// Database connection test and admin user verification
include('server/connection.php');

echo "<h2>Database Connection Test</h2>";

// Test connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "✅ Database connection successful<br><br>";
}

// Check if admin user exists
$admin_check = "SELECT user_id, name, email, is_admin FROM users WHERE is_admin = 1 LIMIT 1";
$result = mysqli_query($conn, $admin_check);

if ($result && mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);
    echo "<h3>Admin User Found:</h3>";
    echo "ID: " . $admin['user_id'] . "<br>";
    echo "Name: " . $admin['name'] . "<br>";
    echo "Email: " . $admin['email'] . "<br>";
    echo "Is Admin: " . ($admin['is_admin'] ? 'Yes' : 'No') . "<br><br>";
} else {
    echo "❌ No admin user found in database<br><br>";
}

// Check products count
$products_check = "SELECT COUNT(*) as total FROM products";
$result = mysqli_query($conn, $products_check);
if ($result) {
    $count = mysqli_fetch_assoc($result);
    echo "<h3>Products in Database:</h3>";
    echo "Total Products: " . $count['total'] . "<br><br>";
}

// Check categories
$categories_check = "SELECT * FROM categories";
$result = mysqli_query($conn, $categories_check);
if ($result) {
    echo "<h3>Categories:</h3>";
    while ($category = mysqli_fetch_assoc($result)) {
        echo "- " . $category['name'] . " (ID: " . $category['category_id'] . ")<br>";
    }
}

echo "<br><hr><br>";
echo "<a href='login.php'>Go to Login</a> | ";
echo "<a href='dashboard/dashboard.php'>Go to Dashboard (Admin Only)</a>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Test - Velvet Vogue</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 40px; 
            background: #f5f5f5; 
        }
        h2, h3 { 
            color: #FF1493; 
        }
        a { 
            color: #FF1493; 
            text-decoration: none; 
            padding: 10px 15px; 
            background: white; 
            border-radius: 5px; 
            margin-right: 10px;
        }
        a:hover { 
            background: #FF1493; 
            color: white; 
        }
    </style>
</head>
<body>
</body>
</html>
