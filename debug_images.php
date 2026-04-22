<!DOCTYPE html>
<html>
<head>
    <title>Debug Women's Images</title>
</head>
<body>
    <h2>Debug: Women's Product Images</h2>
    <?php
    include('server/connection.php');
    
    $stmt = $conn->prepare("SELECT product_id, name, image FROM products WHERE category_id = 1");
    $stmt->execute();
    $products = $stmt->get_result();
    
    echo "<table border='1'>";
    echo "<tr><th>Product ID</th><th>Name</th><th>Image Filename</th><th>File Exists?</th><th>Image Preview</th></tr>";
    
    while($row = $products->fetch_assoc()) {
        $image_path = "img/" . $row['image'];
        $file_exists = file_exists($image_path) ? "YES" : "NO";
        
        echo "<tr>";
        echo "<td>" . $row['product_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['image'] . "</td>";
        echo "<td style='color: " . ($file_exists == "YES" ? "green" : "red") . "'>" . $file_exists . "</td>";
        echo "<td>";
        if ($file_exists == "YES") {
            echo "<img src='" . $image_path . "' style='width: 100px; height: 100px; object-fit: cover;'>";
        } else {
            echo "File not found";
        }
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<h3>Files in img/ directory starting with 'wa':</h3>";
    $files = glob("img/wa*");
    foreach($files as $file) {
        echo basename($file) . "<br>";
    }
    ?>
</body>
</html>
