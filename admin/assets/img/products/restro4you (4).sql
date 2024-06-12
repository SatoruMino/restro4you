-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 01:51 AM
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
-- Database: `restro4you`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addEmployee` (`in_code` VARCHAR(10), `in_name` VARCHAR(25), `in_gender` VARCHAR(10), `in_position` VARCHAR(10), `in_dob` DATE, `in_phone` VARCHAR(25), `in_email` VARCHAR(50), `in_password` TEXT)   BEGIN 
	DECLARE new_user_id varchar(10);
    START TRANSACTION;
    INSERT INTO users(email, password, role) VALUE (in_email, in_password, 'employee');
    SET new_user_id = LAST_INSERT_ID();
    
    INSERT INTO employees(id, name, gender,pos_id, dob, phone, u_id) VALUES (in_code, in_name, in_gender, in_position, in_dob, in_phone, new_user_id);
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEmployeeDetailWhere` (`in_code` VARCHAR(10))   BEGIN
  SELECT e.*, u.id AS u_id, u.email AS email, u.password AS password  -- Use standard alias within SELECT
  FROM employees e
  INNER JOIN users u ON e.u_id = u.id  -- Assuming user_id (check your schema)
  WHERE e.id = in_code;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCustomerDetail` (`in_uid` VARCHAR(10), `in_name` VARCHAR(25), `in_phone` VARCHAR(25), `in_address` TEXT, `in_photo` TEXT, `in_email` VARCHAR(50), `in_password` TEXT, `in_code` VARCHAR(10))   BEGIN
  UPDATE customers c
  INNER JOIN users u ON c.u_id = u.id
  SET c.name = in_name,
      c.phone = in_phone,
      c.address = in_address,
      c.photo = in_photo,
      u.email = in_email,
      u.password = in_password
  WHERE c.id = in_code;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL,
  `u_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `u_id`) VALUES
('50ce771e-2', 'MinomT', 'A0M1N-R3T4');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
('AXIJ-0319', 'LUNCH'),
('AYCN-7345', 'BREAKFAST'),
('EHZW-5246', 'DESSERT'),
('FWPD-8675', 'STARTER');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `u_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `photo`, `created_at`, `u_id`) VALUES
('068967b771', 'Heng Lay', '0124382372', 'St.5 Poipet Cambodia', '', '2024-06-11 18:43:59', 'e465a713-2');

--
-- Triggers `customers`
--
DELIMITER $$
CREATE TRIGGER `after_delete_customer` AFTER DELETE ON `customers` FOR EACH ROW DELETE FROM users WHERE id = OLD.u_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pos_id` varchar(10) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `u_id` varchar(10) DEFAULT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `gender`, `dob`, `pos_id`, `phone`, `u_id`, `address`) VALUES
('3b603429-2', 'Voeng Bunheap', 'Male', '2003-06-13', 'IRBL-3218', '012992719', 'S7A11-E3P', 'St.5 Battambang, Cambodia');

--
-- Triggers `employees`
--
DELIMITER $$
CREATE TRIGGER `after_delete_employee` AFTER DELETE ON `employees` FOR EACH ROW DELETE FROM users WHERE id = OLD.u_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `getemployeedetail`
-- (See below for the actual view)
--
CREATE TABLE `getemployeedetail` (
`id` varchar(10)
,`name` varchar(25)
,`gender` varchar(10)
,`dob` date
,`pos_id` varchar(10)
,`phone` varchar(25)
,`u_id` varchar(10)
,`emp_email` varchar(50)
,`emp_pos` varchar(25)
);

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `import_date` datetime DEFAULT NULL,
  `sup_id` varchar(10) NOT NULL,
  `total` float DEFAULT NULL,
  `p_id` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_details`
--

CREATE TABLE `import_details` (
  `import_id` varchar(10) NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `qty` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `unit`, `qty`) VALUES
('f1ef1600-2', 'Bread', 'Int', 50);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `order_date` datetime DEFAULT NULL,
  `cust_id` varchar(10) NOT NULL,
  `total` float DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `p_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `paid_date` datetime DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `cust_id` varchar(10) NOT NULL,
  `o_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL,
  `cate_id` varchar(10) NOT NULL,
  `price` float DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `name` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(10) NOT NULL DEFAULT uuid(),
  `email` varchar(50) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `role`, `password`) VALUES
('A0M1N-R3T4', 'minomtdeveloper007@gmail.com', 'admin', '$2y$10$Ts1gOSLIkqEcOVEFjUzureJ8pwvqtesT//ABzaIV1hHlpZyKi/kb.'),
('e465a713-2', 'henglay123@gmail.com', 'customer', '$2y$10$wLblYUgdfjaTp5WzVjCs7.otPnxxhNa1kB4DVL0zrY7Mh4HnzXFyi'),
('S7A11-E3P', 'voengbunheap008@gmail.com', 'employee', '$2y$10$M4vz9k02G/0gux8J.gpMaeN5sHtmcCBO9mTjJpCu0R0rhkuAYyc3G');

-- --------------------------------------------------------

--
-- Structure for view `getemployeedetail`
--
DROP TABLE IF EXISTS `getemployeedetail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getemployeedetail`  AS SELECT `e`.`id` AS `id`, `e`.`name` AS `name`, `e`.`gender` AS `gender`, `e`.`dob` AS `dob`, `e`.`pos_id` AS `pos_id`, `e`.`phone` AS `phone`, `e`.`u_id` AS `u_id`, `u`.`email` AS `emp_email`, `p`.`name` AS `emp_pos` FROM ((`employees` `e` join `users` `u` on(`e`.`u_id` = `u`.`id`)) join `positions` `p` on(`e`.`pos_id` = `p`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_ibfk_1` (`u_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_ibfk_1` (`u_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pos_id` (`pos_id`),
  ADD KEY `employees_ibfk_2` (`u_id`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sup_id` (`sup_id`);

--
-- Indexes for table `import_details`
--
ALTER TABLE `import_details`
  ADD PRIMARY KEY (`import_id`,`p_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `o_id` (`o_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cate_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_ibfk_1` FOREIGN KEY (`sup_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `import_details`
--
ALTER TABLE `import_details`
  ADD CONSTRAINT `import_details_ibfk_1` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`),
  ADD CONSTRAINT `import_details_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`o_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
