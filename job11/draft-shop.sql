-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2024 at 04:31 PM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `draft-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `createdAt`, `updatedAt`) VALUES
(1, 'fruits', 'fruits', '2024-01-09 10:41:38', '2024-01-09 10:41:38'),
(2, 'légumes', 'légumes', '2024-01-09 10:41:38', '2024-01-09 10:41:38'),
(3, 'vêtements', 'vêtements', '2024-01-12 16:17:51', '2024-01-12 16:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `product_id` int NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `material_fee` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electronic`
--

CREATE TABLE `electronic` (
  `product_id` int NOT NULL,
  `brand` varchar(255) NOT NULL,
  `waranty_fee` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `photos` json DEFAULT NULL,
  `price` int DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `photos`, `price`, `description`, `quantity`, `createdAt`, `updatedAt`, `category_id`) VALUES
(1, 'tomates', '{\"photo1\": \"https://mapetiteassiette.com/tous/la-tomate/\"}', 1, 'tomates', 1, '2024-01-09 10:37:21', NULL, 1),
(2, 'oignons', '{\"photo1\": \"https://www.fondation-louisbonduelle.org/legume/oignon/\"}', 2, 'oignons', 1, '2024-01-09 10:37:21', NULL, 1),
(3, 'courges', '{\"photo1\": \"https://www.gemuese.ch/fr/especes-de-legumes/courge\"}', 4, 'courges', 1, '2024-01-09 10:44:30', NULL, 1),
(4, 'brocolis', '{\"photo1\": \"https://www.academiedugout.fr/ingredients/brocoli_833\"}', 1, 'brocolis', 1, '2024-01-09 10:44:30', NULL, 1),
(5, 'pommes', '{\"photo1\": \"https://mapetiteassiette.com/tous/la-pomme/\"}', 1, 'pommes', 1, '2024-01-09 10:47:10', NULL, 2),
(6, 'pêches', '{\"photo1\": \"https://chefsimon.com/recettes/tag/p%C3%AAches\"}', 1, 'pêches', 1, '2024-01-09 10:47:10', NULL, 2),
(7, 'poires', '{\"photo1\": \"https://www.fruit-style.com/conservation-des-poires/\"}', 3, 'poires', 1, '2024-01-09 10:50:19', NULL, 2),
(183, 't-shirt 252', '[\"https://picsum.photos/200/300\"]', 10, 't-shirt', 24, '2024-01-12 15:58:36', '2024-01-12 15:58:36', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `electronic`
--
ALTER TABLE `electronic`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clothing`
--
ALTER TABLE `clothing`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electronic`
--
ALTER TABLE `electronic`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
