-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 08:22 AM
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
-- Database: `canteen_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Breakfast'),
(2, 'Lunch'),
(3, 'Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_satisfaction` int(11) NOT NULL,
  `service_satisfaction` int(11) NOT NULL,
  `team_satisfaction` int(11) NOT NULL,
  `improvement_suggestions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `user_id`, `product_satisfaction`, `service_satisfaction`, `team_satisfaction`, `improvement_suggestions`) VALUES
(1, 1, 4, 3, 4, '-'),
(2, 6, 4, 3, 4, '-');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `price`, `description`, `image`, `category_id`, `isActive`) VALUES
(3, 'malahotpot', 8.00, 'admin123 wants to eat', '/public/1717478310-malahotpot.jpg', 3, 1),
(7, 'fried rice', 3.00, 'fried with one day old rice', '/public/1718204752-egg fried rice.jpg', 2, 1),
(8, 'pizza', 5.00, 'hawaiian chicken', '/public/1718207523-pizza.jpg', 2, 1),
(9, 'nasi briyani', 4.00, 'tasty', '/public/1718207563-nasi briyani.jpg', 2, 1),
(10, 'tom yam beehoon soup', 6.00, 'seafood', '/public/1718207591-tom yam.jpg', 2, 1),
(11, 'fried noodles', 3.00, 'xxxxxx', '/public/1718207661-fried noodles.jpg', 1, 1),
(12, 'Rendang chicken', 5.00, 'kampung chicken', '/public/1718207817-chicken rendang.jpg', 3, 1),
(13, 'Asam Laksa', 5.00, 'sweet and sour', '/public/1718207990-asam laksa.jpg', 3, 1),
(14, 'Cereals', 3.00, 'cornflakes ', '/public/1718208163-corn flakes.jpg', 1, 1),
(15, 'Roti canai', 3.00, 'with dhal curry', '/public/1718208282-roti canai.jpg', 1, 1),
(16, 'Chicken chop', 8.00, 'with blackpepper sauce', '/public/1718208429-chicken chop.jpg', 3, 1),
(17, 'Char Kuey Teow', 3.00, 'nice', '/public/1718208844-char kuey teow.jpg', 3, 1),
(20, 'chicken rice', 5.00, 'delicious', '/public/1718210464-chicken rice.jpg', 1, 0),
(22, 'Spaghetti', 5.00, 'lemon spinach sauce', '/public/1718237965-green spaghetti.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu_date` date NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL,
  `food_id_1` int(11) NOT NULL,
  `food_id_2` int(11) DEFAULT NULL,
  `food_id_3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_date`, `isActive`, `category_id`, `food_id_1`, `food_id_2`, `food_id_3`) VALUES
(4, '2024-06-13', 1, 1, 11, 14, 15),
(5, '2024-06-13', 1, 2, 22, 7, 8),
(6, '2024-06-13', 1, 3, 3, 16, 12);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` float NOT NULL,
  `purchase_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `purchase_date`) VALUES
(1, 1, 8, '2024-06-04'),
(4, 3, 10, '2024-06-05'),
(5, 3, 5, '2024-06-10'),
(9, 3, 16, '2024-06-12'),
(17, 6, 3, '2024-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `menu_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `food_id`, `order_id`, `quantity`, `menu_date`) VALUES
(1, 3, 1, 1, '2024-06-04'),
(30, 11, 17, 1, '2024-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `isAdmin`) VALUES
(1, 'student1', 'student1@gmail.com', '$2y$10$1.sRejEPd9yNbNtomL9btOTqc5O2kKejJriwfisQMWbLsfa4mc9EW', 0),
(2, 'admin123', 'admin123@gmail.com', '$2y$10$66P0kbjhjfKQ7Pvbp0Vqley1SPYPtWb4bLre0CGvHhTpekzzTeWnS', 1),
(3, 'student2', 'student2@gmail.com', '$2y$10$uCyeaZt2AjuVZcqtBw2zMO9n7ILjPITnMQwaF2wb6QBOxnYm0N3w.', 0),
(4, 'student3', 'student3@gmail.com', '$2y$10$Y5rPn8i/tqfiLC5HCmdiZOMiqrh2hbXb0Lpna6WwUmvIOEkpXGujK', 0),
(5, 'student4', 'student4@gmail.com', '$2y$10$WrZigbBlzVGMthHCEq8PH.4nwl34z6afiBFQwTGI.VNz1HjBC7npe', 0),
(6, 'student5', 'student5@gmail.com', '$2y$10$bLaumSJQVjQNWgkfESxqSe0fSC2pN22Cirjk75rheJM0DoSfzNNNm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `vote_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `category_id`, `food_id`, `vote_date`) VALUES
(2, 1, 3, 3, '2024-06-04'),
(6, 1, 3, 3, '2024-06-05'),
(9, 1, 3, 3, '2024-06-10'),
(12, 4, 3, 3, '2024-06-10'),
(30, 6, 1, 11, '2024-06-13'),
(31, 6, 2, 22, '2024-06-13'),
(32, 6, 3, 16, '2024-06-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `menus_fk3` (`food_id_1`),
  ADD KEY `menus_fk4` (`food_id_2`),
  ADD KEY `menus_fk5` (`food_id_3`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `orders_fk1` (`user_id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `product_orders_fk1` (`order_id`),
  ADD KEY `product_orders_ibfk_1` (`food_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `votes_fk1` (`user_id`),
  ADD KEY `votes_ibfk_1` (`category_id`),
  ADD KEY `votes_fk2` (`food_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_fk3` FOREIGN KEY (`food_id_1`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_fk4` FOREIGN KEY (`food_id_2`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_fk5` FOREIGN KEY (`food_id_3`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `product_orders_fk1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_orders_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_fk2` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
