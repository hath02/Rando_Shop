-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 01:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','client') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `email`, `password`, `username`, `phone`, `address`, `role`, `status`, `created_at`, `reset_token`, `token_expire`, `avatar`) VALUES
(16, 'user01@gmail.com', '$2y$10$xdpKPP3xc4G//7MxDB/8C.QLYgbVW59xB5scp9neKus9n1Uj5B8QK', 'user01', NULL, '85 ADSF', 'client', 'active', '2026-04-14 03:08:27', NULL, NULL, 'avatar_16.1780107187.jpg'),
(19, 'admin02@gmail.com', '$2y$10$2lf6/iedkNTwwgMTp8yjlOmDcYBfPt0pgd268de9DrZXnpxY0WM8S', 'admin02', NULL, '214 gdgas', 'admin', 'active', '2026-04-14 03:26:45', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `account_id`, `product_id`, `quantity`) VALUES
(41, 16, 6, 1),
(42, 16, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Living Room', 'living', '2026-03-20 08:22:19'),
(5, 'Kitchen', 'kitchen', '2026-03-21 00:07:14'),
(7, 'Bedding', 'bedroom', '2026-03-21 00:07:45'),
(9, 'Bath', 'bathroom', '2026-03-21 00:13:32'),
(11, 'Decor', 'decoration', '2026-04-09 06:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `shipping_address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `account_id`, `total_price`, `status`, `shipping_address`, `created_at`, `name`, `phone`, `address`) VALUES
(7, 16, 280.00, 'cancelled', NULL, '2026-05-17 17:38:24', 'ABC', '0912345678', '123 ABC'),
(9, 16, 850.00, 'processing', NULL, '2026-05-17 19:24:28', 'ABC', '0912345678', '123 ABC'),
(10, 16, 200.00, 'completed', NULL, '2026-05-19 08:47:17', 'ABC', '0912345678', '123 ABC'),
(11, 16, 380.00, 'pending', NULL, '2026-05-21 06:48:25', 'ABC', '0912345678', '123 ABC');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(8, 7, 11, 200.00, 1),
(9, 7, 10, 80.00, 1),
(12, 9, 8, 100.00, 1),
(13, 9, 6, 500.00, 1),
(14, 9, 7, 250.00, 1),
(15, 10, 2, 200.00, 1),
(16, 11, 2, 200.00, 1),
(17, 11, 8, 100.00, 1),
(19, 11, 10, 80.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `amount`, `payment_status`, `created_at`) VALUES
(1, 11, 'COD', 380.00, 'Pending', '2026-05-27 07:02:43'),
(2, 9, 'COD', 850.00, 'Paid', '2026-05-30 02:34:32'),
(3, 10, 'COD', 200.00, 'Paid', '2026-05-30 02:35:04'),
(4, 7, 'COD', 280.00, 'Failed', '2026-05-30 02:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `on_sale` tinyint(1) NOT NULL DEFAULT 0,
  `sale_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `price`, `stock`, `description`, `category_id`, `status`, `created_at`, `on_sale`, `sale_price`) VALUES
(2, 'Rando Coffee Table CT-03', '1774100871_Table.H03.2k-2.jpg', 200.00, 100, 'W: 50 L: 120 H: 50. \r\nMade with carbon steel 1901 and hand-crafted walnut.', 1, 'active', '2026-03-20 23:54:04', 1, 150.00),
(4, 'Rando Chair HC-03', '1774664659_Black-Chair.H03.2k.jpg', 85.00, 2000, 'Caron steel 1806 frame.', 5, 'active', '2026-03-28 02:24:19', 0, 0.00),
(6, 'Rando Hanging Chair', '1775202697_Hanging-Chair.H03.2k.jpg', 400.00, 500, 'Carbon steel 1806 frame.', 1, 'active', '2026-04-03 07:51:37', 1, 352.00),
(7, 'Rando Coffee Table CT-02', '1775202741_Table.H03.2k.jpg', 250.00, 511, 'W: 80cm, L: 160cm, H: 50cm.\r\nGlass table top. Stainless steel frame.', 1, 'active', '2026-04-03 07:52:21', 1, 200.00),
(8, 'Rando Chair HC-01', '1775268663_Chair.H03.2k.jpg', 75.00, 6001, 'Carbon steel 1806', 5, 'active', '2026-04-04 02:11:03', 0, 0.00),
(9, 'Rando Stool FL15', '1775268741_Modern-Stool.H03.2k-1.jpg', 100.00, 3499, 'Stainless steel.', 5, 'active', '2026-04-04 02:12:21', 0, 0.00),
(10, 'Rando Wall Clock', '1775716081_cropped-Modern-Wall-Clock.H03.2k.jpg', 90.00, 499, 'Carbon-steel 1806', 11, 'active', '2026-04-09 06:28:01', 0, 0.00),
(11, 'Rando Terrarium', '1775716121_Hanging-Terrarium.H03.2k.jpg', 150.00, 30, 'Fern', 11, 'active', '2026-04-09 06:28:41', 0, 0.00),
(12, 'Rando Chandelier', '1775716244_Pendant-Light-Mobile-Chandelier.H03.2k.jpg', 500.00, 1259, 'asodi', 11, 'active', '2026-04-09 06:30:44', 1, 350.00),
(13, 'Rando Light Pendant', '1775806211_Light-Pendant-Bronze.H03.2k.jpg', 35.00, 2000, 'Stainless steel. ', 11, 'active', '2026-04-10 07:30:11', 0, 0.00),
(14, 'Rando Coffe Table CT-05', '1775806286_Table.H03.2k-1.jpg', 250.00, 297, 'W: 80cm, L: 160cm, H: 40cm.\r\nGlass table top. Stainless steel frame. ', 1, 'active', '2026-04-10 07:31:26', 1, 245.00),
(15, 'Rando Mirror MR-1', '1775806348_Tall-Mirror.H03.2k.jpg', 100.00, 400, 'L: 60cm, H: 200 cm.', 11, 'active', '2026-04-10 07:32:28', 1, 89.00),
(16, 'Rando Vase H03', '1780102945_Vase.H03.2k.jpg', 50.00, 40, 'Ceramic', 11, 'active', '2026-05-30 01:02:25', 0, NULL),
(17, 'Rando Vase H01', '1780102994_Vase.H03.2k-1.jpg', 50.00, 10, 'Ceramic', 11, 'active', '2026-05-30 01:03:14', 1, 49.00),
(18, 'Rando Sculpture', '1780103045_Vase-Black.H03.2k.jpg', 100.00, 29, 'Ceramic', 11, 'active', '2026-05-30 01:04:05', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `cart_ibfk_2` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
