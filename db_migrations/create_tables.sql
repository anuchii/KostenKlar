USE kostenklar;

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `gebdatum` date NOT NULL,
  `geschlecht` enum ('weiblich', 'maennlich', 'divers', '') COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `avatar_path` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categories` (
  `category_id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transactions` (
  `transaction_id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `transaction_title` varchar(255) NOT NULL,
  `transaction_amount` decimal(12,2) NOT NULL,
  `transaction_type` enum('expense','revenue') NOT NULL,
  `transaction_category_id` int(10) UNSIGNED NOT NULL,
  `transaction_note` text NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  CONSTRAINT fk_transactions_users
    FOREIGN KEY (`user_id`)
    REFERENCES	`users` (`user_id`),
  CONSTRAINT fk_transactions_categories
    FOREIGN KEY (`transaction_category_id`)
    REFERENCES	`categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Lebensmittel'),
(2, 'Mobilität'),
(3, 'Mode'),
(4, 'Haushalt'),
(5, 'Gehalt')