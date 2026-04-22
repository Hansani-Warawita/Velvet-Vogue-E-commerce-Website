<?php
include('server/connection.php');

// Function to find a matching image for a product
function findMatchingImage($productName, $categoryId) {
    $imageDir = 'img/';
    $images = scandir($imageDir);
    
    // Define category prefixes
    $categoryPrefixes = [
        1 => ['women', 'w', 'wp', 'ws', 'wc', 'wa'], // Women
        2 => ['men', 'm', 'ma', 'mc', 'ms', 'mf', 'male'], // Men  
        3 => ['kids', 'k', 'kb', 'kg', 'kt'] // Kids
    ];
    
    // Get prefixes for this category
    $prefixes = $categoryPrefixes[$categoryId] ?? [];
    
    // Look for images with category prefix
    foreach ($prefixes as $prefix) {
        foreach ($images as $image) {
            if (strpos(strtolower($image), $prefix) === 0 && 
                (strpos($image, '.jpg') !== false || strpos($image, '.png') !== false)) {
                return $image;
            }
        }
    }
    
    // Fallback to any image in the directory
    foreach ($images as $image) {
        if ($image != '.' && $image != '..' && 
            (strpos($image, '.jpg') !== false || strpos($image, '.png') !== false)) {
            return $image;
        }
    }
    
    return 'home2.jpg'; // Final fallback
}

echo "<h2>Fixing Image References...</h2>";

// Get all products
$stmt = $conn->prepare("SELECT product_id, name, image, category_id FROM products");
$stmt->execute();
$result = $stmt->get_result();

$updated = 0;
$errors = 0;

while($row = $result->fetch_assoc()) {
    $currentImage = $row['image'];
    $imagePath = "img/" . $currentImage;
    
    // Check if current image exists
    if (!file_exists($imagePath) || empty($currentImage)) {
        // Find a replacement image
        $newImage = findMatchingImage($row['name'], $row['category_id']);
        
        // Update database
        $updateStmt = $conn->prepare("UPDATE products SET image = ? WHERE product_id = ?");
        $updateStmt->bind_param("si", $newImage, $row['product_id']);
        
        if ($updateStmt->execute()) {
            echo "✅ Updated Product ID " . $row['product_id'] . ": '" . substr($row['name'], 0, 30) . "' - Changed from '" . $currentImage . "' to '" . $newImage . "'<br>";
            $updated++;
        } else {
            echo "❌ Error updating Product ID " . $row['product_id'] . "<br>";
            $errors++;
        }
    } else {
        echo "✓ Product ID " . $row['product_id'] . ": '" . substr($row['name'], 0, 30) . "' - Image '" . $currentImage . "' exists<br>";
    }
}

echo "<br><strong>Summary:</strong><br>";
echo "Updated: " . $updated . " products<br>";
echo "Errors: " . $errors . " products<br>";

echo "<br><a href='women.php'>Test Women's Page</a> | ";
echo "<a href='men.php'>Test Men's Page</a> | ";
echo "<a href='kids.php'>Test Kids' Page</a>";
?>
