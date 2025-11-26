-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 26, 2025 lúc 06:17 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan_1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `total_pay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billdetail`
--

CREATE TABLE `billdetail` (
  `id` int(11) NOT NULL,
  `productVariant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `current_price` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cartdetail`
--

CREATE TABLE `cartdetail` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `productVariant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Áo'),
(2, 'Quần'),
(3, 'Phụ kiện'),
(4, 'kính'),
(5, 'túi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `color`
--

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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `star` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gender`
--

INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'Nam'),
(2, 'Nữ'),
(3, 'Unisex');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `method` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `img_child` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL /* <-- Đã Đổi tên cột */
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `img`, `img_child`, `category_id`, `gender_id`) VALUES
(1, 'Áo Polo KS25FH47C-SCWK', 350000, 'Mẫu áo Polo nam với chất liệu vải thoáng mát, thấm hút mồ hôi tốt, thích hợp cho cả đi làm và dạo phố. Thiết kế form vừa vặn giúp tôn dáng và mang lại vẻ ngoài lịch lãm.', 'ao-nam-Áo Polo KS25FH47C-SCWK-hình19.jpg', 'ao-nam-Áo Polo KS25FH47C-SCWK-hình20.jpg', 1, 1),
(2, 'Áo Polo KS25FH50T-SCWK', 390000, 'Thiết kế phối viền trẻ trung, năng động. Màu đen nam tính dễ dàng phối với quần Jeans hoặc Kaki.', 'ao-nam-Áo Polo KS25FH50T-SCWK-hinh22.jpg', 'ao-nam-Áo Polo KS25FH50T-SCWK-hinh23.jpg', 1, 1),
(3, 'Áo Polo KS26SS40-AT', 550000, 'Dòng sản phẩm cao cấp với chất liệu lụa băng siêu mát. Logo thêu nổi tinh tế khẳng định đẳng cấp.', 'ao-nam-Áo Polo KS26SS40-AT-hình13.jpg', 'ao-nam-Áo Polo KS26SS40-AT-hình14.jpg', 1, 1),
(4, 'Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE', 450000, 'Vải Oxford dày dặn, đứng form, ít nhăn. Phù hợp cho môi trường công sở.', 'ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình10.jpg', 'ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE-hình11.jpg', 1, 1),
(5, 'Áo Polo Nam Tay Ngắn Form Vừa KS25FH46T-SCCA', 550000, 'Chất Jeans co giãn nhẹ, form ôm vừa vặn tôn dáng. Màu wash bền đẹp theo thời gian.', 'ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH46T-SCCA-hình28.jpg', 'ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH46T-SCCA-hình29.jpg', 1, 1),
(6, 'Áo Polo Nam Tay Ngắn Form Vừa KS25FH48T-SCWK', 350000, 'Áo nhà AURA mang đến sự kết hợp hoàn hảo giữa phong cách hiện đại và sự thoải mái tối đa. Chất liệu cao cấp, thoáng mát giúp bạn tự tin trong mọi hoạt động. Thiết kế tôn dáng, đa dạng màu sắc, dễ dàng phối đồ để tạo nên phong thái riêng đầy cuốn hút.', 'ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH48T-SCWK-hình16.jpg', 'ao-nam-Áo Polo Nam Tay Ngắn Form Vừa KS25FH48T-SCWK-hình17.jpg', 1, 1),
(8, 'Áo Thun Nữ Basic Cut-Out FWTS25SS14C', 390000, '\r\nÁo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu1.1-Áo Thun Nữ Basic Cut-Out FWTS25SS14C.jpg', 'ao-nu1.2-Áo Thun Nữ Basic Cut-Out FWTS25SS14C.jpg', 1, 2),
(10, 'Áo Polo Cổ Viền Tương Phản FWKS25FH04C', 550000, '\r\n\r\nÁo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu2-Áo Polo Cổ Viền Tương Phản FWKS25FH04C.jpg', 'ao-nu2.2-Áo Polo Cổ Viền Tương Phản FWKS25FH04C.jpg', 1, 2),
(11, 'Áo Thun Polo Nữ – FWKS25SS05G', 400000, '', 'ao-nu3-Áo Thun Polo Nữ – FWKS25SS05G.jpg', 'ao-nu3.1-Áo Thun Polo Nữ – FWKS25SS05G.jpg', 1, 2),
(14, 'Áo Thun Polo Nữ Kẻ Sọc FWKS25SS07C', 390000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu4-Áo Thun Polo Nữ Kẻ Sọc FWKS25SS07C.jpg', 'ao-nu4.2-Áo Thun Polo Nữ Kẻ Sọc FWKS25SS07C.jpg', 1, 2),
(15, 'Áo Thun Trắng Cổ Tròn Xẻ Tà FWTS25SS15C', 300000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu5-Áo Thun Trắng Cổ Tròn Xẻ Tà FWTS25SS15C.jpg', 'ao-nu5.2-Áo Thun Trắng Cổ Tròn Xẻ Tà FWTS25SS15C.jpg', 1, 2),
(16, 'Áo Thun Freelancer In Hình “Nature Beats” FWTS25SS08G', 300000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu6-Áo Thun Freelancer In Hình “Nature Beats” FWTS25SS08G.jpg', 'ao-nu6.2-Áo Thun Freelancer In Hình “Nature Beats” FWTS25SS08G.jpg', 1, 2),
(17, 'Áo Thun Nữ Cá Tính FWTS24FH05G', 600000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu7-Áo Thun Nữ Cá Tính FWTS24FH05G.jpg', 'ao-nu7.1-Áo Thun Nữ Cá Tính FWTS24FH05G.jpg', 1, 2),
(18, 'ao-nu8-Áo Polo Nữ Cổ Lưới FWKS25SS11G.jpg', 770000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu8-Áo Polo Nữ Cổ Lưới FWKS25SS11G.jpg', 'ao-nu8.1-Áo Polo Nữ Cổ Lưới FWKS25SS11G.jpg', 1, 2),
(19, 'Áo Thun Polo Nữ FWKS24FH03G', 440000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu9-Áo Thun Polo Nữ FWKS24FH03G.jpg', 'ao-nu9.2-Áo Thun Polo Nữ FWKS24FH03G.jpg', 1, 2),
(20, 'Áo Polo Nữ Cá Tính FWKS24SS03G', 900000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu10.2-Áo Polo Nữ Cá Tính FWKS24SS03G.jpg', 'ao-nu10.1-Áo Polo Nữ Cá Tính FWKS24SS03G.jpg', 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variant`
--

CREATE TABLE `product_variant` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variant`
--

INSERT INTO `product_variant` (`id`, `product_id`, `color_id`, `size_id`, `quantity`) VALUES
(1, 1, 4, 1, 50),
(2, 1, 5, 2, 45),
(3, 1, 6, 3, 30),
(4, 2, 4, 2, 55),
(5, 2, 2, 3, 40),
(6, 3, 5, 3, 15),
(7, 3, 6, 4, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`id`, `name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `login_day` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `login_day`) VALUES
(1, 'Admin User', 'admin@example.com', '123456', '0123456789', '2025-11-26 00:00:00'),
(2, 'Test User', 'test@example.com', '123456', '0987654321', '2025-11-25 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `type` float NOT NULL,
  `min` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher`
--

INSERT INTO `voucher` (`id`, `code`, `start`, `end`, `type`, `min`, `quantity`, `status`) VALUES
(1, 'WELCOME10', '2025-11-01 00:00:00', '2025-12-01 23:59:59', 10, 500000, 100, 'active'),
(2, 'SALE20', '2025-11-15 00:00:00', '2025-11-30 23:59:59', 20, 1000000, 50, 'active');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- Chỉ mục cho bảng `billdetail`
--
ALTER TABLE `billdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `productVariant_id` (`productVariant_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `productVariant_id` (`productVariant_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `gender_id` (`gender_id`); /* <-- Chỉ mục đã sửa */

--
-- Chỉ mục cho bảng `product_variant`
--
ALTER TABLE `product_variant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `billdetail`
--
ALTER TABLE `billdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cartdetail`
--
ALTER TABLE `cartdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_bill_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bill_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `billdetail`
--
ALTER TABLE `billdetail`
  ADD CONSTRAINT `fk_billdetail_bill` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_billdetail_variant` FOREIGN KEY (`productVariant_id`) REFERENCES `product_variant` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD CONSTRAINT `fk_cartdetail_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cartdetail_variant` FOREIGN KEY (`productVariant_id`) REFERENCES `product_variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_bill` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_products_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON UPDATE CASCADE; /* <-- Khóa ngoại đã sửa */

--
-- Các ràng buộc cho bảng `product_variant`
--
ALTER TABLE `product_variant`
  ADD CONSTRAINT `fk_variant_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;