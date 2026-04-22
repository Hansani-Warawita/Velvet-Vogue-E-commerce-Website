<?php
include('server/connection.php');

echo "<h2>Product Images in Database:</h2>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Product ID</th><th>Category</th><th>Product Name</th><th>Image File</th><th>File Exists</th></tr>";

$stmt = $conn->prepare("SELECT product_id, name, image, category_id FROM products ORDER BY category_id, product_id");
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    $image_path = "img/" . $row['image'];
    $file_exists = file_exists($image_path) ? "✅ YES" : "❌ NO";
    
    echo "<tr>";
    echo "<td>" . $row['product_id'] . "</td>";
    echo "<td>" . $row['category_id'] . "</td>";
    echo "<td>" . substr($row['name'], 0, 30) . "</td>";
    echo "<td>" . $row['image'] . "</td>";
    echo "<td>" . $file_exists . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<br><h2>Available Image Files in img/ folder:</h2>";
$image_files = scandir('img/');
foreach($image_files as $file) {
    if($file != '.' && $file != '..') {
        echo $file . "<br>";
    }
}
?>
