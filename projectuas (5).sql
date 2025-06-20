-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2025 at 04:04 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectuas`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_new_product` (IN `p_nama` VARCHAR(100), IN `p_description` TEXT, IN `p_price` BIGINT, IN `p_stok_quantity` INT, IN `p_category_id` BIGINT, IN `p_brand_id` BIGINT, IN `p_gambar` VARCHAR(255))   BEGIN
    INSERT INTO product (nama, description, price, stok_quantity, category_id, brand_id, gambar)
    VALUES (p_nama, p_description, p_price, p_stok_quantity, p_category_id, p_brand_id, p_gambar);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_calculate_total_sales_by_user` (`p_user_id` BIGINT) RETURNS BIGINT DETERMINISTIC BEGIN
    DECLARE total_sales BIGINT;
    
    SELECT COALESCE(SUM(total_amount), 0)
    INTO total_sales
    FROM orders
    WHERE user_id = p_user_id;
    
    RETURN total_sales;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` bigint NOT NULL,
  `brand_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`) VALUES
(1, 'Fujifilm'),
(2, 'Canon');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` bigint NOT NULL,
  `kategori_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_name`) VALUES
(1, 'Kamera Digital'),
(2, 'Kamera Profesional');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `payment_method_id` int DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_amount` bigint DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `payment_method_id`, `order_date`, `total_amount`, `status`) VALUES
(1, 8, 2, '2025-06-11', 4000000, 'Pending'),
(2, 8, 1, '2025-06-11', 2500000, 'Pending'),
(3, 8, 2, '2025-06-11', 4000000, 'Pending'),
(4, 8, 2, '2025-06-11', 500000, 'Pending'),
(5, 8, 3, '2025-06-11', 500000, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  `quantity` int DEFAULT NULL,
  `price` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 3, 1, 1500000),
(1, 4, 1, 2500000),
(2, 1, 10, 250000),
(3, 3, 1, 1500000),
(3, 4, 1, 2500000),
(4, 2, 1, 500000),
(5, 2, 1, 500000);

--
-- Triggers `order_details`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `order_details` FOR EACH ROW BEGIN
  UPDATE product
  SET stok_quantity = stok_quantity - NEW.quantity
  WHERE product_id = NEW.product_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` bigint NOT NULL,
  `order_id` bigint DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `payment_amount` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `is_active`) VALUES
(1, 'COD (Cash On Delivery)', 1),
(2, 'Bank Transfer', 1),
(3, 'GoPay', 1),
(4, 'OVO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` bigint NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `description` text,
  `price` bigint DEFAULT NULL,
  `stok_quantity` int DEFAULT NULL,
  `category_id` bigint DEFAULT NULL,
  `brand_id` bigint DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `nama`, `description`, `price`, `stok_quantity`, `category_id`, `brand_id`, `gambar`) VALUES
(1, 'FUJIFILM FENEPIX A800', '-', 250000, 0, 1, 1, 'fujifilm.jpg'),
(2, 'FUJIFILM GFX100 II', '-', 500000, 7, 1, 1, 'fujifilm.jpg'),
(3, 'FUJIFILM GFX100s\r\n\r\n', '-', 1500000, 1, 1, 1, 'fujifilm.jpg'),
(4, 'FUJIFILM GFX50S II', '-', 2500000, 8, 1, 1, 'fujifilm.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` bigint NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `product_id` bigint DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `review_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `address`, `phone_number`, `profile_picture`) VALUES
(8, 'adel', '$2y$10$7EVLwqRJigpdnmP0XgXNl.jBc0mEZV0KGnupq1FxJZDhz50FM0MjO', 'adel@gmail.com', 'jogja', '123123', 'images/profile_684aebc325f3e2.95365393.jpg'),
(9, 'adel2', '$2y$10$11Q6nN7LnKSI/3eRHJFG2e8chkMLeJc9.nEGkogOHmlMjlu/8VQXi', 'adel2@gmail.com', 'jogja', '0909090909', NULL),
(63, 'zidan', '$2y$10$H1vHeu.iTW9z214Ko4F2sehWfsA2S0Ccl4YacP2R7XWVX8uVS3Iua', 'zidan@ai.ck', '1515', '1241213', ''),
(65, 'asd', '$2y$10$6WHRxa9e/cXlHA3Ahdr4nOahbkmj4QpsWO8zuAP7ABwPhhdneVp1G', 'asd@gmail.cpm', 'jogja', '012931', NULL);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `trg_log_user_data_changes` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    -- Log perubahan alamat
    IF OLD.address <> NEW.address THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_ADDRESS', OLD.address, NEW.address);
    END IF;

    -- Log perubahan nomor telepon
    IF OLD.phone_number <> NEW.phone_number THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_PHONE', OLD.phone_number, NEW.phone_number);
    END IF;

    -- Log perubahan email
    IF OLD.email <> NEW.email THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_EMAIL', OLD.email, NEW.email);
    END IF;

     -- Log perubahan password (hanya mencatat bahwa password diubah, bukan nilainya)
    IF OLD.password <> NEW.password THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_PASSWORD', 'PASSWORD_CHANGED', 'PASSWORD_CHANGED');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_audit_log`
--

CREATE TABLE `user_audit_log` (
  `log_id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `changed_by` varchar(100) DEFAULT 'UNKNOWN',
  `change_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(50) DEFAULT NULL,
  `old_value` text,
  `new_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_order_summary`
-- (See below for the actual view)
--
CREATE TABLE `vw_order_summary` (
`order_id` bigint
,`order_date` date
,`username` varchar(100)
,`email` varchar(100)
,`payment_method` varchar(255)
,`total_amount` bigint
,`status` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_product_details`
-- (See below for the actual view)
--
CREATE TABLE `vw_product_details` (
`product_id` bigint
,`product_name` varchar(100)
,`description` text
,`price` bigint
,`stok_quantity` int
,`kategori_name` varchar(100)
,`brand_name` varchar(100)
,`gambar` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_order_summary`
--
DROP TABLE IF EXISTS `vw_order_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_order_summary`  AS SELECT `o`.`order_id` AS `order_id`, `o`.`order_date` AS `order_date`, `u`.`username` AS `username`, `u`.`email` AS `email`, `pm`.`name` AS `payment_method`, `o`.`total_amount` AS `total_amount`, `o`.`status` AS `status` FROM ((`orders` `o` join `users` `u` on((`o`.`user_id` = `u`.`user_id`))) join `payment_methods` `pm` on((`o`.`payment_method_id` = `pm`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_product_details`
--
DROP TABLE IF EXISTS `vw_product_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_product_details`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`nama` AS `product_name`, `p`.`description` AS `description`, `p`.`price` AS `price`, `p`.`stok_quantity` AS `stok_quantity`, `k`.`kategori_name` AS `kategori_name`, `b`.`brand_name` AS `brand_name`, `p`.`gambar` AS `gambar` FROM ((`product` `p` join `kategori` `k` on((`p`.`category_id` = `k`.`kategori_id`))) join `brand` `b` on((`p`.`brand_id` = `b`.`brand_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payment_ibfk_1` (`order_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `review_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_audit_log`
--
ALTER TABLE `user_audit_log`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `user_audit_log`
--
ALTER TABLE `user_audit_log`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `kategori` (`kategori_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
