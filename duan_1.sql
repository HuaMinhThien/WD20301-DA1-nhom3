SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `address` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `bill` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `voucher_id` INT DEFAULT NULL,
  `order_date` DATETIME NOT NULL, 
  `status` VARCHAR(50) NOT NULL,
  `total_pay` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `voucher_id` (`voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `billdetail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `productVariant_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `current_price` INT NOT NULL, 
  `bill_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`),
  KEY `productVariant_id` (`productVariant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `cart` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `date_create` DATETIME NOT NULL, 
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `cartdetail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `productVariant_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `productVariant_id` (`productVariant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `category` (`id`, `name`) VALUES
(1, 'áo'),
(2, 'quần'),
(3, 'đồ bộ'),
(4, 'bộ đồ'),
(5, 'đồ đồ');


CREATE TABLE `color` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `code` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `color` (`id`, `name`, `code`) VALUES
(1, 'Đỏ', '#FF0000'),
(2, 'Xanh dương', '#0000FF'),
(3, 'Xanh lá', '#00FF00'),
(4, 'Đen', '#000000'),
(5, 'Trắng', '#FFFFFF'),
(6, 'Xám', '#808080'),
(7, 'Vàng', '#FFFF00'),
(8, 'Cam', '#FFA500'),
(9, 'Hồng', '#FFC0CB'),
(10, 'Tím', '#800080');


CREATE TABLE `comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `content` TEXT NOT NULL,
  `date` DATETIME NOT NULL, 
  `star` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `gender` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'Nam'),
(2, 'Nữ'),
(3, 'Unisex');


CREATE TABLE `payment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `bill_id` INT NOT NULL,
  `method` VARCHAR(20) NOT NULL,
  `date` DATETIME NOT NULL, 
  `price` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `price` INT NOT NULL,
  `description` TEXT NOT NULL,
  `img` VARCHAR(255) NOT NULL,
  `img_child` VARCHAR(255) NOT NULL, 
  `category_id` INT NOT NULL,
  `id_gender` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `id_gender` (`id_gender`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `products` (`id`, `name`, `price`, `description`, `img`, `img_child`, `category_id`, `id_gender`) VALUES
(1, 'Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C', 350000, 'Mẫu áo Polo nam với chất liệu vải thoáng mát, thấm hút mồ hôi tốt, thích hợp cho cả đi làm và dạo phố. Thiết kế form vừa vặn giúp tôn dáng và mang lại vẻ ngoài lịch lãm.', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 1, 1),
(2, 'Áo Polo Nam Phối Viền Cổ', 390000, 'Thiết kế phối viền trẻ trung, năng động. Màu đen nam tính dễ dàng phối với quần Jeans hoặc Kaki.', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 1, 1),
(3, 'Áo Polo Luxury Basic', 550000, 'Dòng sản phẩm cao cấp với chất liệu lụa băng siêu mát. Logo thêu nổi tinh tế khẳng định đẳng cấp.', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 1, 1),
(4, 'Áo Sơ Mi Nam Oxford', 450000, 'Vải Oxford dày dặn, đứng form, ít nhăn. Phù hợp cho môi trường công sở.', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form V25FH40C-SCHE-hình10.jpg', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 1, 1),
(5, 'Quần Jeans Nam Slimfit', 550000, 'Chất Jeans co giãn nhẹ, form ôm vừa vặn tôn dáng. Màu wash bền đẹp theo thời gian.', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 'assets/images/áo nam/ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 2, 1);


CREATE TABLE `product_variant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `color_id` INT NOT NULL,
  `size_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `color_id` (`color_id`),
  KEY `size_id` (`size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `product_variant` (`id`, `product_id`, `color_id`, `size_id`, `quantity`) VALUES
(1, 1, 4, 1, 50),
(2, 1, 5, 2, 45),
(3, 1, 6, 3, 30),
(4, 2, 4, 2, 55),
(5, 2, 2, 3, 40),
(6, 3, 5, 3, 15),
(7, 3, 6, 4, 10);


CREATE TABLE `size` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `size` (`id`, `name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL');


CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL, 
  `phone` VARCHAR(15) NOT NULL,
  `login_day` DATETIME NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `login_day`) VALUES
(1, 'Admin User', 'admin@example.com', '123456', '0123456789', '2025-11-26 00:00:00'),
(2, 'Test User', 'test@example.com', '123456', '0987654321', '2025-11-25 00:00:00');


CREATE TABLE `voucher` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(20) NOT NULL,
  `start` DATETIME NOT NULL, 
  `end` DATETIME NOT NULL, 
  `type` FLOAT NOT NULL,
  `min` INT NOT NULL,
  `quantity` INT NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `voucher` (`id`, `code`, `start`, `end`, `type`, `min`, `quantity`, `status`) VALUES
(1, 'WELCOME10', '2025-11-01 00:00:00', '2025-12-01 23:59:59', 10, 500000, 100, 'active'),
(2, 'SALE20', '2025-11-15 00:00:00', '2025-11-30 23:59:59', 20, 1000000, 50, 'active');


ALTER TABLE `address`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;


ALTER TABLE `bill`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;


ALTER TABLE `billdetail`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;


ALTER TABLE `cart`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;


ALTER TABLE `cartdetail`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;


ALTER TABLE `category`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `color`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `comments`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;


ALTER TABLE `gender`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `payment`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `products`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `product_variant`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `size`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `user`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `voucher`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `bill`
  ADD CONSTRAINT `fk_bill_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bill_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE `billdetail`
  ADD CONSTRAINT `fk_billdetail_bill` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_billdetail_variant` FOREIGN KEY (`productVariant_id`) REFERENCES `product_variant` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;


ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `cartdetail`
  ADD CONSTRAINT `fk_cartdetail_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cartdetail_variant` FOREIGN KEY (`productVariant_id`) REFERENCES `product_variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_bill` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_products_gender` FOREIGN KEY (`id_gender`) REFERENCES `gender` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE; 


ALTER TABLE `product_variant`
  ADD CONSTRAINT `fk_variant_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;