-- SQL script to fix image extensions in the database
USE velvetvogue;

-- Fix products table image extensions
UPDATE products SET image = 'wa2.jpg' WHERE image = 'wa2.png';
UPDATE products SET image = 'wa3.jpg' WHERE image = 'wa3.png';
UPDATE products SET image = 'wa4.jpg' WHERE image = 'wa4.png';
UPDATE products SET image = 'wa5.jpg' WHERE image = 'wa5.png';
UPDATE products SET image = 'wa6.jpg' WHERE image = 'wa6.png';

-- Fix product_images table image extensions
UPDATE product_images SET image_path = 'wa2.jpg' WHERE image_path = 'wa2.png';
UPDATE product_images SET image_path = 'wa3.jpg' WHERE image_path = 'wa3.png';
UPDATE product_images SET image_path = 'wa4.jpg' WHERE image_path = 'wa4.png';
UPDATE product_images SET image_path = 'wa5.jpg' WHERE image_path = 'wa5.png';
UPDATE product_images SET image_path = 'wa6.jpg' WHERE image_path = 'wa6.png';

-- Verify the changes
SELECT name, image FROM products WHERE category_id = 1;
SELECT product_id, image_path, is_main FROM product_images WHERE product_id IN (1,2,3,4,5,6,7);
