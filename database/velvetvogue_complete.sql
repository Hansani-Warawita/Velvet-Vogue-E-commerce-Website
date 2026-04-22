-- phpMyAdmin SQL Dump
-- Velvet Vogue Complete Database Structure
-- Generated on: July 12, 2025

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Create Database
--
CREATE DATABASE IF NOT EXISTS `velvetvogue` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `velvetvogue`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Women', 'Fashion collection for women'),
(2, 'Men', 'Fashion collection for men'),
(3, 'Children', 'Fashion collection for kids');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'Admin', 'admin@velvetvogue.com', '$2y$10$8jnmMLPBI4ysYUw.m9TZLOdDpOPiiVkRRQz4Zh9qD9oSYTvZ9RrIu', 1, '2025-07-12 12:02:21'),
(2, 'test', 'test@test.com', '$2y$10$rEchjBjhxmnJlCGO1llMcutkOg8NQwRBSqZLr4UMFyUtLerC/f72K', 0, '2025-07-12 15:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `price`, `image`, `stock`, `created_at`) VALUES
(1, 1, 'Elegant Summer Dress', 'Beautiful floral print summer dress', 89.99, 'wa1.png', 50, '2025-07-12 12:02:21'),
(2, 1, 'Classic White Blouse', 'Versatile white blouse for any occasion', 49.99, 'wa2.png', 75, '2025-07-12 12:02:21'),
(3, 1, 'Designer Jeans', 'Premium quality designer jeans', 129.99, 'wa3.png', 40, '2025-07-12 12:02:21'),
(4, 1, 'Evening Gown', 'Stunning evening gown for special occasions', 199.99, 'wa4.png', 25, '2025-07-12 12:02:21'),
(5, 1, 'Casual T-Shirt', 'Comfortable casual t-shirt', 29.99, 'wa5.png', 100, '2025-07-12 12:02:21'),
(6, 1, 'Women Formal Wear', 'Professional women formal outfit', 159.99, 'wa6.png', 35, '2025-07-12 12:02:21'),
(7, 1, 'Women Casual Wear', 'Stylish casual wear for women', 79.99, 'wa7.png', 60, '2025-07-12 12:02:21'),
(8, 2, 'Business Suit', 'Professional business suit', 299.99, 'ma1.jpg', 30, '2025-07-12 12:02:21'),
(9, 2, 'Casual Polo Shirt', 'Classic polo shirt for casual wear', 39.99, 'ma2.jpg', 80, '2025-07-12 12:02:21'),
(10, 2, 'Denim Jacket', 'Stylish denim jacket', 89.99, 'ma3.jpg', 45, '2025-07-12 12:02:21'),
(11, 2, 'Formal Shoes', 'Premium leather formal shoes', 149.99, 'ma4.jpg', 35, '2025-07-12 12:02:21'),
(12, 2, 'Cotton T-Shirt', 'Comfortable cotton t-shirt', 24.99, 'ma5.jpg', 120, '2025-07-12 12:02:21'),
(13, 2, 'Men Casual Wear', 'Stylish casual outfit for men', 69.99, 'ma6.jpg', 55, '2025-07-12 12:02:21'),
(14, 2, 'Men Formal Shirt', 'Professional formal shirt', 59.99, 'ma7.jpg', 70, '2025-07-12 12:02:21'),
(15, 2, 'Men Sports Wear', 'Comfortable sports outfit', 79.99, 'ma8.jpg', 65, '2025-07-12 12:02:21'),
(16, 3, 'Kids Party Dress', 'Adorable party dress for girls', 49.99, 'kg1.jpg', 40, '2025-07-12 12:02:21'),
(17, 3, 'Boys Casual Set', 'Comfortable casual wear set for boys', 39.99, 'kb1.jpg', 60, '2025-07-12 12:02:21'),
(18, 3, 'Children Sports Outfit', 'Active wear for kids', 34.99, 'kt1.jpg', 70, '2025-07-12 12:02:21'),
(19, 3, 'Kids Winter Jacket', 'Warm winter jacket for children', 59.99, 'kg2.jpg', 45, '2025-07-12 12:02:21'),
(20, 3, 'School Uniform Set', 'Complete school uniform set', 44.99, 'kb2.jpg', 80, '2025-07-12 12:02:21'),
(21, 3, 'Kids Summer Dress', 'Light and comfortable summer dress for girls', 35.99, 'kg3.jpg', 50, '2025-07-12 12:02:21'),
(22, 3, 'Boys T-Shirt Set', 'Colorful t-shirt set for boys', 29.99, 'kb3.jpg', 85, '2025-07-12 12:02:21'),
(23, 3, 'Kids Formal Wear', 'Special occasion outfit for children', 54.99, 'kg4.jpg', 30, '2025-07-12 12:02:21'),
(24, 3, 'Children Sleepwear', 'Comfortable pajama set for kids', 24.99, 'kt2.jpg', 90, '2025-07-12 12:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_path`, `is_main`, `display_order`, `created_at`) VALUES
-- Women's Products Images
(1, 1, 'wa1.png', 1, 1, '2025-07-12 12:18:55'),
(2, 1, 'women1.jpg', 0, 2, '2025-07-12 12:18:55'),
(3, 1, 'women11.jpg', 0, 3, '2025-07-12 12:18:55'),
(4, 2, 'wa2.png', 1, 1, '2025-07-12 12:18:55'),
(5, 2, 'women2.jpg', 0, 2, '2025-07-12 12:18:55'),
(6, 2, 'women12.jpg', 0, 3, '2025-07-12 12:18:55'),
(7, 3, 'wa3.png', 1, 1, '2025-07-12 12:18:55'),
(8, 3, 'women3.jpg', 0, 2, '2025-07-12 12:18:55'),
(9, 3, 'women13.jpg', 0, 3, '2025-07-12 12:18:55'),
(10, 4, 'wa4.png', 1, 1, '2025-07-12 12:18:55'),
(11, 4, 'women21.jpg', 0, 2, '2025-07-12 12:18:55'),
(12, 4, 'women22.jpg', 0, 3, '2025-07-12 12:18:55'),
(13, 5, 'wa5.png', 1, 1, '2025-07-12 12:18:55'),
(14, 5, 'women23.jpg', 0, 2, '2025-07-12 12:18:55'),
(15, 5, 'women24.jpg', 0, 3, '2025-07-12 12:18:55'),
(16, 6, 'wa6.png', 1, 1, '2025-07-12 12:18:55'),
(17, 6, 'women31.jpg', 0, 2, '2025-07-12 12:18:55'),
(18, 6, 'women32.jpg', 0, 3, '2025-07-12 12:18:55'),
(19, 7, 'wa7.png', 1, 1, '2025-07-12 12:18:55'),
(20, 7, 'women33.jpg', 0, 2, '2025-07-12 12:18:55'),
(21, 7, 'women34.jpg', 0, 3, '2025-07-12 12:18:55'),

-- Men's Products Images
(22, 8, 'ma1.jpg', 1, 1, '2025-07-12 12:18:55'),
(23, 8, 'men1.jpg', 0, 2, '2025-07-12 12:18:55'),
(24, 8, 'men11.jpg', 0, 3, '2025-07-12 12:18:55'),
(25, 9, 'ma2.jpg', 1, 1, '2025-07-12 12:18:55'),
(26, 9, 'men2.jpg', 0, 2, '2025-07-12 12:18:55'),
(27, 9, 'men12.jpg', 0, 3, '2025-07-12 12:18:55'),
(28, 10, 'ma3.jpg', 1, 1, '2025-07-12 12:18:55'),
(29, 10, 'men3.jpg', 0, 2, '2025-07-12 12:18:55'),
(30, 10, 'men13.jpg', 0, 3, '2025-07-12 12:18:55'),
(31, 11, 'ma4.jpg', 1, 1, '2025-07-12 12:18:55'),
(32, 11, 'men4.jpg', 0, 2, '2025-07-12 12:18:55'),
(33, 11, 'men14.jpg', 0, 3, '2025-07-12 12:18:55'),
(34, 12, 'ma5.jpg', 1, 1, '2025-07-12 12:18:55'),
(35, 12, 'men21.jpg', 0, 2, '2025-07-12 12:18:55'),
(36, 12, 'men22.jpg', 0, 3, '2025-07-12 12:18:55'),
(37, 13, 'ma6.jpg', 1, 1, '2025-07-12 12:18:55'),
(38, 13, 'men23.jpg', 0, 2, '2025-07-12 12:18:55'),
(39, 13, 'men24.jpg', 0, 3, '2025-07-12 12:18:55'),
(40, 14, 'ma7.jpg', 1, 1, '2025-07-12 12:18:55'),
(41, 14, 'men31.jpg', 0, 2, '2025-07-12 12:18:55'),
(42, 14, 'men32.jpg', 0, 3, '2025-07-12 12:18:55'),
(43, 15, 'ma8.jpg', 1, 1, '2025-07-12 12:18:55'),
(44, 15, 'men33.jpg', 0, 2, '2025-07-12 12:18:55'),
(45, 15, 'men34.jpg', 0, 3, '2025-07-12 12:18:55'),

-- Children's Products Images
(46, 16, 'kg1.jpg', 1, 1, '2025-07-12 12:18:55'),
(47, 16, 'kids1.jpg', 0, 2, '2025-07-12 12:18:55'),
(48, 16, 'kids11.jpg', 0, 3, '2025-07-12 12:18:55'),
(49, 17, 'kb1.jpg', 1, 1, '2025-07-12 12:18:55'),
(50, 17, 'kids2.jpg', 0, 2, '2025-07-12 12:18:55'),
(51, 17, 'kids12.jpg', 0, 3, '2025-07-12 12:18:55'),
(52, 18, 'kt1.jpg', 1, 1, '2025-07-12 12:18:55'),
(53, 18, 'kids3.jpg', 0, 2, '2025-07-12 12:18:55'),
(54, 18, 'kids13.jpg', 0, 3, '2025-07-12 12:18:55'),
(55, 19, 'kg2.jpg', 1, 1, '2025-07-12 12:18:55'),
(56, 19, 'kids4.jpg', 0, 2, '2025-07-12 12:18:55'),
(57, 19, 'kids14.jpg', 0, 3, '2025-07-12 12:18:55'),
(58, 20, 'kb2.jpg', 1, 1, '2025-07-12 12:18:55'),
(59, 20, 'kids21.jpg', 0, 2, '2025-07-12 12:18:55'),
(60, 20, 'kids22.jpg', 0, 3, '2025-07-12 12:18:55'),
(61, 21, 'kg3.jpg', 1, 1, '2025-07-12 12:18:55'),
(62, 21, 'kg4.jpg', 0, 2, '2025-07-12 12:18:55'),
(63, 21, 'kg5.jpg', 0, 3, '2025-07-12 12:18:55'),
(64, 22, 'kb3.jpg', 1, 1, '2025-07-12 12:18:55'),
(65, 22, 'kb4.jpg', 0, 2, '2025-07-12 12:18:55'),
(66, 22, 'kb5.jpg', 0, 3, '2025-07-12 12:18:55'),
(67, 23, 'kg4.jpg', 1, 1, '2025-07-12 12:18:55'),
(68, 23, 'kg6.jpg', 0, 2, '2025-07-12 12:18:55'),
(69, 23, 'kg7.jpg', 0, 3, '2025-07-12 12:18:55'),
(70, 24, 'kt2.jpg', 1, 1, '2025-07-12 12:18:55'),
(71, 24, 'kt3.jpg', 0, 2, '2025-07-12 12:18:55'),
(72, 24, 'kt4.jpg', 0, 3, '2025-07-12 12:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
