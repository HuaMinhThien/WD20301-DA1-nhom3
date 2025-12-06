-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 06, 2025 lúc 05:11 PM
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

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`id`, `user_id`, `voucher_id`, `order_date`, `status`, `total_pay`) VALUES
(2, 2, 1, '2025-11-28 15:45:00', 'Đã giao', 1197000),
(3, 2, NULL, '2025-12-01 20:52:07', 'Chờ xác nhận', 1100000),
(4, 2, NULL, '2025-12-01 20:57:12', 'Chờ xác nhận', 2640000),
(5, 5, NULL, '2025-12-02 09:02:11', 'Đã giao', 3700000),
(6, 2, NULL, '2025-12-04 09:03:28', 'Đã hủy', 3225000),
(7, 2, NULL, '2025-12-04 09:14:54', 'Chờ xác nhận', 605000),
(8, 2, NULL, '2025-12-06 23:04:43', 'pending', 640000);

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

--
-- Đang đổ dữ liệu cho bảng `billdetail`
--

INSERT INTO `billdetail` (`id`, `productVariant_id`, `quantity`, `current_price`, `bill_id`) VALUES
(1, 4, 2, 390000, 2),
(2, 7, 1, 550000, 2),
(3, 45, 2, 0, 3),
(4, 679, 1, 0, 4),
(5, 196, 2, 0, 4),
(6, 496, 1, 0, 4),
(7, 526, 1, 0, 5),
(8, 511, 1, 0, 5),
(9, 676, 1, 0, 5),
(10, 625, 1, 0, 5),
(11, 226, 2, 0, 5),
(12, 631, 1, 0, 6),
(13, 680, 1, 0, 6),
(14, 769, 1, 0, 6),
(15, 500, 1, 0, 6),
(16, 91, 1, 0, 6),
(17, 922, 1, 0, 6),
(18, 511, 1, 0, 6),
(19, 594, 1, 0, 6),
(20, 691, 1, 0, 7),
(21, 766, 1, 0, 7),
(22, 514, 1, 0, 8),
(23, 212, 1, 0, 8),
(24, 215, 1, 0, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `date_create`) VALUES
(1, 2, '2025-12-01 02:24:53'),
(2, 1, '2025-12-01 16:21:29'),
(4, 5, '2025-12-02 07:51:15'),
(5, 7, '2025-12-02 09:04:15'),
(6, 4, '2025-12-04 09:26:20'),
(7, 3, '2025-12-04 09:26:24'),
(8, 0, '2025-12-05 12:35:28');

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

--
-- Đang đổ dữ liệu cho bảng `cartdetail`
--

INSERT INTO `cartdetail` (`id`, `cart_id`, `productVariant_id`, `quantity`) VALUES
(22, 2, 211, 1),
(25, 2, 514, 1),
(26, 2, 529, 1),
(56, 2, 676, 1);

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
(3, 'Thắt lưng'),
(4, 'Kính'),
(5, 'Túi'),
(6, 'Vớ'),
(7, 'Balo'),
(8, 'Ví');

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
(4, 'Đen', '#000000'),
(5, 'Trắng', '#FFFFFF'),
(9, 'Hồng', '#FFC0CB');

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
(2, 'Nữ');

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

--
-- Đang đổ dữ liệu cho bảng `payment`
--

INSERT INTO `payment` (`id`, `bill_id`, `method`, `date`, `price`) VALUES
(1, 2, 'Thanh toán online', '2025-11-28 15:50:00', 1197000);

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
  `gender_id` int(11) NOT NULL
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
(16, 'Áo Thun Freelancer In Hình \"Nature Beats\" FWTS25SS08G', 300000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu6.1-Áo Thun Freelancer In Hình “Nature Beats” FWTS25SS08G.jpg', 'ao-nu6.2-Áo Thun Freelancer In Hình \"Nature Beats\" FWTS25SS08G.jpg', 1, 2),
(17, 'Áo Thun Nữ Cá Tính FWTS24FH05G', 600000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu7-Áo Thun Nữ Cá Tính FWTS24FH05G.jpg', 'ao-nu7.1-Áo Thun Nữ Cá Tính FWTS24FH05G.jpg', 1, 2),
(18, 'Áo Polo Nữ Cổ Lưới FWKS25SS11G', 770000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu8-Áo Polo Nữ Cổ Lưới FWKS25SS11G.jpg', 'ao-nu8.1-Áo Polo Nữ Cổ Lưới FWKS25SS11G.jpg', 1, 2),
(19, 'Áo Thun Polo Nữ FWKS24FH03G', 440000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu9-Áo Thun Polo Nữ FWKS24FH03G.jpg', 'ao-nu9.2-Áo Thun Polo Nữ FWKS24FH03G.jpg', 1, 2),
(20, 'Áo Polo Nữ Cá Tính FWKS24SS03G', 900000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu10.2-Áo Polo Nữ Cá Tính FWKS24SS03G.jpg', 'ao-nu10.1-Áo Polo Nữ Cá Tính FWKS24SS03G.jpg', 1, 2),
(21, 'Quần Tây Nam Form Ôm Vừa DP25FH13T-NMSC', 450000, 'Mẫu quần tây nam DP25FH13T sở hữu thiết kế form ôm vừa (Slim Fit) hiện đại, giúp tôn dáng người mặc mà vẫn đảm bảo sự thoải mái tối đa.', 'quan-nam1-Quần Tây Nam Form Ôm Vừa DP25FH13T-NMSC.jpg', 'quan-nam1.1-Quần Tây Nam Form Ôm Vừa DP25FH13T-NMSC.jpg', 2, 1),
(22, 'Quần Tây Nam Form Ôm Vừa DP25FH12T-EPSC', 480000, 'Sự lựa chọn hoàn hảo cho quý ông yêu thích phong cách tối giản nhưng sang trọng. Mã DP25FH12T được may từ chất liệu vải cải tiến với khả năng chống nhăn tự nhiên.', 'quan-nam2-Quần Tây Nam Form Ôm Vừa DP25FH12T-EPSC.jpg', 'quan-nam2.1-Quần Tây Nam Form Ôm Vừa DP25FH12T-EPSC.jpg', 2, 1),
(23, 'Quần Tây Nam Form Ôm Vừa DP25FH11T-NMSC', 450000, 'Quần tây nam DP25FH11T nổi bật với chất vải bền màu, không bai xù qua nhiều lần giặt. Form dáng ôm vừa phải giúp người mặc trông cao ráo và gọn gàng hơn.', 'quan-nam3-Quần Tây Nam Form Ôm Vừa DP25FH11T-NMSC.jpg', 'quan-nam3.1-Quần Tây Nam Form Ôm Vừa DP25FH11T-NMSC.jpg', 2, 1),
(24, 'Quần Tây Nam Form Ôm Vừa DP25FH14P-NMSC', 460000, 'Mang đến phong cách trẻ trung và năng động, mẫu quần DP25FH14P được thiết kế dành riêng cho phái mạnh yêu thích sự chỉn chu. Chất liệu vải có độ rủ tự nhiên.', 'quan-nam4-Quần Tây Nam Form Ôm Vừa DP25FH14P-NMSC.jpg', 'quan-nam4.1-Quần Tây Nam Form Ôm Vừa DP25FH14P-NMSC.jpg', 2, 1),
(25, 'Quần Tây Nam Form Ôm Vừa DP25ES01P-NMSC', 420000, 'Sản phẩm DP25ES01P là sự kết hợp tinh tế giữa phong cách cổ điển và hơi thở hiện đại. Form quần được cắt may chuẩn xác theo số đo hình thể nam giới Việt.', 'quan-nam5-Quần Tây Nam Form Ôm Vừa DP25ES01P-NMSC.jpg', 'quan-nam5.1-Quần Tây Nam Form Ôm Vừa DP25ES01P-NMSC.jpg', 2, 1),
(26, 'Quần Tây Nam Form Vừa DP25FH09P-NMSC', 450000, 'Khác biệt với dòng Slim fit, mẫu quần Form Vừa (Regular Fit) DP25FH09P mang lại sự thoải mái tuyệt đối, không gây gò bó ở phần đùi và bắp chân.', 'quan-nam6-Quần Tây Nam Form Vừa DP25FH09P-NMSC.jpg', 'quan-nam6.1-Quần Tây Nam Form Vừa DP25FH09P-NMSC.jpg', 2, 1),
(27, 'Quần Tây Nam Form Vừa DP25FH10C-NMRG', 490000, 'Đẳng cấp và lịch lãm là những gì mẫu quần DP25FH10C mang lại. Sử dụng dòng vải cao cấp nhất trong bộ sưu tập, quần có độ bóng nhẹ sang trọng.', 'quan-nam7-Quần Tây Nam Form Vừa DP25FH10C-NMRG.jpg', 'quan-nam7.1-Quần Tây Nam Form Vừa DP25FH10C-NMRG.jpg', 2, 1),
(28, 'Quần Tây Nam Form Vừa DP25SS08C-NMSC', 450000, 'Mẫu quần tây DP25SS08C với gam màu trang nhã, dễ phối đồ là \"vũ khí\" bí mật của các quý ông công sở. Form quần đứng dáng, giúp \"hack\" dáng chân dài hơn.', 'quan-nam8-Quần Tây Nam Form Vừa DP25SS08C-NMSC.jpg', 'quan-nam8.1-Quần Tây Nam Form Vừa DP25SS08C-NMSC.jpg', 2, 1),
(29, 'Quần Tây Nam Form Vừa DP25ES01P-NM', 430000, 'Thiết kế Basic đơn giản nhưng không hề đơn điệu. DP25ES01P tập trung vào chất lượng đường kim mũi chỉ và chất liệu vải nhập khẩu. Quần có độ co giãn 4 chiều nhẹ.', 'quan-nam9-Quần Tây Nam Form Vừa DP25ES01P-NM.jpg', 'quan-nam9.1-Quần Tây Nam Form Vừa DP25ES01P-NM.jpg', 2, 1),
(30, 'Quần Tây Nam Form Vừa DP24SS03T-NM', 470000, 'Sản phẩm mới nhất DP24SS03T mang đến làn gió mới cho tủ đồ của bạn. Thiết kế cạp quần thông minh giúp cố định áo khi sơ vin, tránh xộc xệch.', 'quan-nam10-Quần Tây Nam Form Vừa DP24SS03T-NM.jpg', 'quan-nam10.1-Quần Tây Nam Form Vừa DP24SS03T-NM.jpg', 2, 1),
(31, 'Quần Tây Nữ Màu Nâu – FWDP25FH08C', 450000, 'Sắc nâu trầm ấm mang lại vẻ đẹp cổ điển và thanh lịch cho quý cô công sở. Mẫu quần FWDP25FH08C với thiết kế lưng cao giúp \"hack\" dáng chân dài miên man.', 'quan-nu1-Quần Tây Nữ Màu Nâu – FWDP25FH08C.jpg', 'quan-nu1.1-Quần Tây Nữ Màu Nâu – FWDP25FH08C.jpg', 2, 2),
(32, 'Quần Tây Lửng Màu Beige FWDP25FH09C', 420000, 'Trẻ trung và năng động với thiết kế quần tây dáng lửng (cropped) màu Beige nhẹ nhàng. FWDP25FH09C là lựa chọn lý tưởng cho những ngày hè hoặc môi trường làm việc sáng tạo.', 'quan-nu2-Quần Tây Lửng Màu Beige FWDP25FH09C.jpg', 'quan-nu2.1-Quần Tây Lửng Màu Beige FWDP25FH09C.jpg', 2, 2),
(33, 'Quần Tây Nữ Xám Ống Rộng FWDP25SS01C', 480000, 'Bắt kịp xu hướng thời trang hiện đại với mẫu quần ống rộng (Wide Leg) màu xám khói sang trọng. FWDP25SS01C mang lại sự thoải mái tuyệt đối trong từng bước di chuyển.', 'quan-nu3-Quần Tây Nữ Xám Ống Rộng FWDP25SS01C.jpg', 'quan-nu3.1-Quần Tây Nữ Xám Ống Rộng FWDP25SS01C.jpg', 2, 2),
(34, 'Quần Tây Nữ Form Ôm FWDP25SS07C', 440000, 'Mẫu quần tây nữ FWDP25SS07C được thiết kế form ôm nhẹ, tôn lên đường cong quyến rũ một cách tinh tế. Chất liệu co giãn 4 chiều giúp bạn thoải mái ngồi làm việc cả ngày dài.', 'quan-nu4-Quần Tây Nữ Form Ôm FWDP25SS07C.jpg', 'quan-nu4.1-Quần Tây Nữ Form Ôm FWDP25SS07C.jpg', 2, 2),
(35, 'Quần Tây Slimfit Freelancer FWDP24FH01C', 460000, 'Dành riêng cho những cô nàng Freelancer năng động, mẫu quần Slimfit FWDP24FH01C kết hợp hoàn hảo giữa tính thời trang và sự tiện dụng. Kiểu dáng gọn gàng, hiện đại.', 'quan-nu5-Quần Tây Slimfit Freelancer FWDP24FH01C.jpg', 'quan-nu5.1-Quần Tây Slimfit Freelancer FWDP24FH01C.jpg', 2, 2),
(36, 'Quần Tây Ống Rộng Freelancer - FWDP25SS04C', 490000, 'Phóng khoáng và tự do là tinh thần của mẫu quần ống rộng FWDP25SS04C. Thiết kế hướng đến sự thoải mái tối đa, phù hợp với những buổi gặp gỡ đối tác tại quán cafe.', 'quan-nu6-Quần Tây Ống Rộng Freelancer - FWDP25SS04C.jpg', 'quan-nu6.1-Quần Tây Ống Rộng Freelancer - FWDP25SS04C.jpg', 2, 2),
(37, 'Quần Tây Nữ Basic FWDP24SS06C', 400000, 'Đơn giản là đỉnh cao của sự tinh tế. Mẫu quần Basic FWDP24SS06C với thiết kế ống đứng truyền thống, không bao giờ lỗi mốt. Phù hợp với mọi dáng người và mọi độ tuổi.', 'quan-nu7-Quần Tây Nữ Basic FWDP24SS06C.jpg', 'quan-nu7.1-Quần Tây Nữ Basic FWDP24SS06C.jpg', 2, 2),
(38, 'Quần Tây Nữ Form Baggy FWDP23FH02G', 450000, 'Phong cách Baggy trẻ trung giúp che đi khuyết điểm vòng 3 và đùi hiệu quả. FWDP23FH02G mang hơi hướng retro nhưng vẫn rất hiện đại. Phần hông rộng rãi tạo cảm giác chân thon gọn hơn.', 'quan-nu8-Quần Tây Nữ Form Baggy FWDP23FH02G.jpg', 'quan-nu8.1-Quần Tây Nữ Form Baggy FWDP23FH02G.jpg', 2, 2),
(39, 'Quần tây nữ form ống rộng FWDP23SS09C', 470000, 'Thêm một lựa chọn tuyệt vời cho tín đồ của quần ống rộng. FWDP23SS09C sở hữu gam màu nhã nhặn, tôn da. Chất vải lụa cát mềm mại, không nhăn nhàu, tạo cảm giác mát lạnh.', 'quan-nu9-Quần tây nữ form ống rộng FWDP23SS09C.jpg', 'quan-nu9.1-Quần tây nữ form ống rộng FWDP23SS09C.jpg', 2, 2),
(40, 'Quần tây nữ basic ống đứng FWDP22SS03L', 430000, 'Mẫu quần ống đứng kinh điển FWDP22SS03L là biểu tượng của sự thanh lịch vượt thời gian. Form quần thẳng tắp giúp định hình dáng chân thẳng và dài hơn.', 'quan-nu10-Quần tây nữ basic ống đứng FWDP22SS03L.jpg', 'quan-nu10.1-Quần tây nữ basic ống đứng FWDP22SS03L.jpg', 2, 2),
(41, 'Thắt Lưng Nam Đầu Tăng Đơ BE26SS12-EP', 350000, 'Thắt lưng nam BE26SS12-EP sở hữu thiết kế đầu khóa tăng đơ hiện đại, giúp điều chỉnh kích thước linh hoạt mà không cần đục lỗ. Mặt khóa kim loại sáng bóng, chống gỉ sét.', 'thatlung-nam1-Thắt Lưng Nam Đầu Tăng Đơ BE26SS12-EP.jpg', 'thatlung-nam1.1-Thắt Lưng Nam Đầu Tăng Đơ BE26SS12-EP.jpg', 3, 1),
(42, 'Thắt Lưng Nam Đầu Tăng Đơ BE26SS08-EP', 380000, 'Sự lựa chọn hoàn hảo cho quý ông công sở. Mẫu thắt lưng BE26SS08-EP có bề mặt da sần nhẹ nam tính. Dễ dàng kết hợp với quần tây, quần kaki để hoàn thiện vẻ ngoài lịch lãm.', 'thatlung-nam2-Thắt Lưng Nam Đầu Tăng Đơ BE26SS08-EP.jpg', 'thatlung-nam2.1-Thắt Lưng Nam Đầu Tăng Đơ BE26SS08-EP.jpg', 3, 1),
(43, 'Thắt Lưng Nam Đầu Tăng Đơ BE26SS10-EP', 360000, 'Điểm nhấn của mẫu BE26SS10-EP nằm ở phần viền khóa được gia công tỉ mỉ. Dây lưng có độ mềm dẻo vừa phải, mang lại cảm giác thoải mái khi đeo, không gây hằn bụng.', 'thatlung-nam3-Thắt Lưng Nam Đầu Tăng Đơ BE26SS10-EP.jpg', 'thatlung-nam3.1-Thắt Lưng Nam Đầu Tăng Đơ BE26SS10-EP.jpg', 3, 1),
(44, 'Thắt Lưng Nam Đầu Tăng Đơ BE26SS02-EP', 390000, 'Phong cách mạnh mẽ và đẳng cấp thể hiện rõ qua mẫu thắt lưng BE26SS02-EP. Bản dây kích thước tiêu chuẩn, phù hợp với đỉa quần của hầu hết các loại quần nam hiện nay.', 'thatlung-nam4-Thắt Lưng Nam Đầu Tăng Đơ BE26SS02-EP.jpg', 'thatlung-nam4.1-Thắt Lưng Nam Đầu Tăng Đơ BE26SS02-EP.jpg', 3, 1),
(45, 'Thắt Lưng Nam Đầu Tăng Đơ BE25FH46-EP', 370000, 'Mẫu thắt lưng BE25FH46-EP mang hơi hướng trẻ trung với mặt khóa cách điệu nhẹ nhàng. Chất da được xử lý kỹ lưỡng để chống thấm nước và hạn chế nấm mốc.', 'thatlung-nam5-Thắt Lưng Nam Đầu Tăng Đơ BE25FH46-EP.jpg', 'thatlung-nam5.1-Thắt Lưng Nam Đầu Tăng Đơ BE25FH46-EP.jpg', 3, 1),
(46, 'Túi Da Nam Công Sở BA25FH14T-WB', 850000, 'Túi da nam công sở BA25FH14T-WB mang vẻ đẹp sang trọng, lịch lãm dành cho quý ông thành đạt. Chất liệu da cao cấp mềm mại, chống thấm nước tốt. Thiết kế nhiều ngăn thông minh.', 'balo-nam1-Túi Da Nam Công Sở BA25FH14T-WB.jpg', 'balo-nam1.1-Túi Da Nam Công Sở BA25FH14T-WB.jpg', 7, 1),
(47, 'Túi Da Nam Công Sở BA25FH13C-WB', 820000, 'Phiên bản BA25FH13C-WB sở hữu thiết kế vuông vắn, mạnh mẽ. Bề mặt da được xử lý tinh tế để hạn chế trầy xước. Các chi tiết khóa kéo kim loại được mạ sáng bóng.', 'balo-nam2-Túi Da Nam Công Sở BA25FH13C-WB.jpg', 'balo-nam2.1-Túi Da Nam Công Sở BA25FH13C-WB.jpg', 7, 1),
(48, 'Ba Lô Nam BA25FH04P-BP', 550000, 'Ba lô nam BA25FH04P-BP với phong cách năng động, trẻ trung. Được làm từ vải Polyester trượt nước, giúp bảo vệ đồ dùng bên trong khi gặp mưa nhẹ. Ngăn chính rộng rãi.', 'balo-nam3-Ba Lô Nam BA25FH04P-BP.jpg', 'balo-nam3.1-Ba Lô Nam BA25FH04P-BP.jpg', 7, 1),
(49, 'Ba Lô Nam BA25FH05C-BP', 580000, 'Thiết kế hiện đại với gam màu trung tính, dễ phối đồ. Mẫu ba lô BA25FH05C-BP chú trọng vào tính tiện dụng với hệ thống nhiều ngăn phụ phía trước. Quai đeo to bản êm ái.', 'balo-nam4-Ba Lô Nam BA25FH05C-BP.jpg', 'balo-nam4.1-Ba Lô Nam BA25FH05C-BP.jpg', 7, 1),
(50, 'Ba Lô Nam BA25FH03C-BP', 600000, 'Mẫu ba lô đa năng BA25FH03C-BP phù hợp cho cả đi học, đi làm lẫn du lịch ngắn ngày. Form dáng cứng cáp, không bị xẹp khi ít đồ. Chất vải bền màu, dễ dàng vệ sinh.', 'balo-nam5-Ba Lô Nam BA25FH03C-BP.jpg', 'balo-nam5.1-Ba Lô Nam BA25FH03C-BP.jpg', 7, 1),
(51, 'Ví Da Nam Dáng Ngang WT25FH14-HZ', 550000, 'Ví da nam dáng ngang WT25FH14-HZ mang phong cách tối giản nhưng đầy tinh tế. Chất liệu da bò thật 100% được xử lý kỹ lưỡng, bề mặt mềm mịn và có độ đàn hồi tốt.', 'vi-nam1-Ví Da Nam Dáng Ngang WT25FH14-HZ.jpg', 'vi-nam1.1-Ví Da Nam Dáng Ngang WT25FH14-HZ.jpg', 8, 1),
(52, 'Ví Da Nam Dáng Đứng WT25FH11-HZ', 580000, 'Mẫu ví dáng đứng hiện đại WT25FH11-HZ dành cho quý ông yêu thích sự gọn gàng. Kích thước nhỏ gọn, vừa vặn trong túi quần mà không gây cộm. Bề mặt da sần nhẹ nam tính.', 'vi-nam2-Ví Da Nam Dáng Đứng WT25FH11-HZ.jpg', 'vi-nam2.1-Ví Da Nam Dáng Đứng WT25FH11-HZ.jpg', 8, 1),
(53, 'Ví Da Nam Dáng Ngang WT25FH10-HZ', 520000, 'Sở hữu tông màu cổ điển sang trọng, mẫu ví WT25FH10-HZ là phụ kiện không thể thiếu của phái mạnh. Chất da cao cấp càng dùng càng bóng đẹp. Thiết kế ví mỏng nhẹ nhưng sức chứa lớn.', 'vi-nam3-Ví Da Nam Dáng Ngang WT25FH10-HZ.jpg', 'vi-nam3.1-Ví Da Nam Dáng Ngang WT25FH10-HZ.jpg', 8, 1),
(54, 'Ví Da Nam Dáng Ngang WT25FH12-HZ', 540000, 'Sự kết hợp hoàn hảo giữa tính thẩm mỹ và công năng. Ví nam WT25FH12-HZ có thiết kế đường viền nổi bật. Ngăn khóa kéo bí mật bên trong giúp bảo quản vật dụng quan trọng an toàn.', 'vi-nam4-Ví Da Nam Dáng Ngang WT25FH12-HZ.jpg', 'vi-nam4.1-Ví Da Nam Dáng Ngang WT25FH12-HZ.jpg', 8, 1),
(55, 'Ví Da Nam Dáng Ngang WT25FH08-HZ', 500000, 'Mẫu ví Basic WT25FH08-HZ tập trung vào trải nghiệm người dùng với chất da mềm mại, cầm êm tay. Kiểu dáng truyền thống không bao giờ lỗi mốt. Các ngăn chia thẻ được cắt may chính xác.', 'vi-nam5-Ví Da Nam Dáng Ngang WT25FH08-HZ.jpg', 'vi-nam5.1-Ví Da Nam Dáng Ngang WT25FH08-HZ.jpg', 8, 1),
(56, 'Vớ Cổ Cao SK24FH08P-HGDP', 45000, 'Vớ nam cổ cao SK24FH08P sử dụng công nghệ dệt kim hiện đại, hạn chế tối đa đường gân gây cộm chân. Chất liệu Cotton Bamboo kháng khuẩn tự nhiên, giúp khử mùi hôi hiệu quả.', 'vo-nam1-Vớ Cổ Cao SK24FH08P-HGDP.jpg', 'vo-nam1.1-Vớ Cổ Cao SK24FH08P-HGDP.jpg', 6, 1),
(57, 'Vớ Cổ Cao SK24FH07C-HGDP', 48000, 'Thiết kế họa tiết hình học tinh tế trên nền vải tối màu tạo nên nét cá tính cho mẫu vớ SK24FH07C. Sợi vải mềm mịn, thấm hút mồ hôi cực tốt, giữ cho đôi chân luôn khô thoáng.', 'vo-nam2-Vớ Cổ Cao SK24FH07C-HGDP.jpg', 'vo-nam2.1-Vớ Cổ Cao SK24FH07C-HGDP.jpg', 6, 1),
(58, 'Vớ Cổ Cao SK24FH06T-HGDP', 45000, 'Mẫu vớ basic SK24FH06T là lựa chọn hàng ngày hoàn hảo. Chất liệu sợi Spandex giúp vớ giữ form tốt, không bị bai dão sau nhiều lần giặt. Phần gót và mũi chân được gia cố thêm.', 'vo-nam3-Vớ Cổ Cao SK24FH06T-HGDP.jpg', 'vo-nam3.1-Vớ Cổ Cao SK24FH06T-HGDP.jpg', 6, 1),
(59, 'Vớ SK24FH05P-SH', 42000, 'Dành cho những ngày hè năng động, mẫu vớ cổ trung SK24FH05P mang lại cảm giác nhẹ nhàng, thoáng mát. Công nghệ dệt lưới thông hơi ở mu bàn chân giúp thoát nhiệt nhanh chóng.', 'vo-nam4-Vớ SK24FH05P-SH.jpg', 'vo-nam4.1-Vớ SK24FH05P-SH.jpg', 6, 1),
(60, 'Vớ Cổ Cao Cao Cấp SK23FH06P-HG', 55000, 'Dòng vớ cao cấp SK23FH06P được làm từ sợi Cotton Mercerized siêu bền và bóng mượt. Bề mặt vải mịn màng, không xù lông. Khả năng kháng khuẩn và chống nấm mốc vượt trội.', 'vo-nam5-Vớ Cổ Cao Cao Cấp SK23FH06P-HG.jpg', 'vo-nam5.1-Vớ Cổ Cao Cao Cấp SK23FH06P-HG.jpg', 6, 1),
(61, 'Mắt Kính FWSG23SS03G', 350000, 'Mắt kính FWSG23SS03G sở hữu gọng kính thanh mảnh, mang lại vẻ ngoài nhẹ nhàng và tinh tế cho phái đẹp. Tròng kính được tráng lớp chống tia UV400, bảo vệ mắt tối đa dưới ánh nắng.', 'kinh-nu1-Mắt Kính FWSG23SS03G.jpg', 'kinh-nu1.1-Mắt Kính FWSG23SS03G.jpg', 4, 2),
(62, 'Mắt Kính FWSG23SS02G', 320000, 'Phong cách thời thượng với mẫu kính FWSG23SS02G. Gọng kính được làm từ nhựa Acetate cao cấp, bền bỉ và an toàn cho da. Màu sắc tròng kính dịu nhẹ, giúp quan sát rõ ràng.', 'kinh-nu2-Mắt Kính FWSG23SS02G.jpg', 'kinh-nu2.1-Mắt Kính FWSG23SS02G.jpg', 4, 2),
(63, 'Mắt Kính FWSG23SS01G', 310000, 'Mẫu kính FWSG23SS01G mang hơi hướng Retro cổ điển nhưng không kém phần hiện đại. Thiết kế Oversize giúp che chắn bụi bẩn hiệu quả và tạo hiệu ứng khuôn mặt thon gọn hơn.', 'kinh-nu3-Mắt Kính FWSG23SS01G.jpg', 'kinh-nu3.1-Mắt Kính FWSG23SS01G.jpg', 4, 2),
(64, 'Mắt Kính Nữ FWSG23SS02G', 330000, 'Phiên bản đặc biệt FWSG23SS02G dành riêng cho nữ giới với các đường bo cong mềm mại. Gọng kim loại mạ vàng sáng bóng kết hợp cùng tròng kính Gradient chuyển màu thời trang.', 'kinh-nu4-Mắt Kính Nữ FWSG23SS02G.jpg', 'kinh-nu4.1-Mắt Kính Nữ FWSG23SS02G.jpg', 4, 2),
(65, 'Túi Xách Nữ Tiện Dụng FWBA24SS02', 650000, 'Túi xách nữ FWBA24SS02 là sự kết hợp hoàn hảo giữa tính tiện dụng và thời trang. Kích thước túi rộng rãi, chia nhiều ngăn thông minh giúp nàng thoải mái mang theo cả thế giới.', 'tui-nu1-Túi Xách Nữ Tiện Dụng FWBA24SS02.jpg', 'tui-nu1.1-Túi Xách Nữ Tiện Dụng FWBA24SS02.jpg', 5, 2),
(67, 'test', 111, 'test', 'uploads/1764947047_160_blazer_007-13_51e7520a0d8d43b6bc38e22130452dad_large.jpg', '', 5, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variant`
--

CREATE TABLE `product_variant` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 1,
  `gender_id` tinyint(1) NOT NULL DEFAULT 1,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 99
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variant`
--

INSERT INTO `product_variant` (`id`, `product_id`, `color_id`, `category_id`, `gender_id`, `size_id`, `quantity`) VALUES
(1, 1, 4, 1, 1, 1, 62),
(2, 1, 5, 1, 1, 1, 49),
(3, 1, 9, 1, 1, 1, 48),
(4, 1, 4, 1, 1, 2, 87),
(5, 1, 5, 1, 1, 2, 96),
(6, 1, 9, 1, 1, 2, 31),
(7, 1, 4, 1, 1, 3, 36),
(8, 1, 5, 1, 1, 3, 81),
(9, 1, 9, 1, 1, 3, 12),
(10, 1, 4, 1, 1, 4, 82),
(11, 1, 5, 1, 1, 4, 91),
(12, 1, 9, 1, 1, 4, 16),
(13, 1, 4, 1, 1, 5, 71),
(14, 1, 5, 1, 1, 5, 23),
(15, 1, 9, 1, 1, 5, 75),
(16, 2, 4, 1, 1, 1, 26),
(17, 2, 5, 1, 1, 1, 77),
(18, 2, 9, 1, 1, 1, 24),
(19, 2, 4, 1, 1, 2, 61),
(20, 2, 5, 1, 1, 2, 43),
(21, 2, 9, 1, 1, 2, 22),
(22, 2, 4, 1, 1, 3, 64),
(23, 2, 5, 1, 1, 3, 60),
(24, 2, 9, 1, 1, 3, 98),
(25, 2, 4, 1, 1, 4, 28),
(26, 2, 5, 1, 1, 4, 21),
(27, 2, 9, 1, 1, 4, 100),
(28, 2, 4, 1, 1, 5, 65),
(29, 2, 5, 1, 1, 5, 15),
(30, 2, 9, 1, 1, 5, 50),
(31, 3, 4, 1, 1, 1, 17),
(32, 3, 5, 1, 1, 1, 16),
(33, 3, 9, 1, 1, 1, 17),
(34, 3, 4, 1, 1, 2, 29),
(35, 3, 5, 1, 1, 2, 84),
(36, 3, 9, 1, 1, 2, 52),
(37, 3, 4, 1, 1, 3, 87),
(38, 3, 5, 1, 1, 3, 89),
(39, 3, 9, 1, 1, 3, 83),
(40, 3, 4, 1, 1, 4, 46),
(41, 3, 5, 1, 1, 4, 63),
(42, 3, 9, 1, 1, 4, 76),
(43, 3, 4, 1, 1, 5, 93),
(44, 3, 5, 1, 1, 5, 43),
(45, 3, 9, 1, 1, 5, 16),
(46, 4, 4, 1, 1, 1, 36),
(47, 4, 5, 1, 1, 1, 29),
(48, 4, 9, 1, 1, 1, 28),
(49, 4, 4, 1, 1, 2, 43),
(50, 4, 5, 1, 1, 2, 31),
(51, 4, 9, 1, 1, 2, 18),
(52, 4, 4, 1, 1, 3, 79),
(53, 4, 5, 1, 1, 3, 57),
(54, 4, 9, 1, 1, 3, 38),
(55, 4, 4, 1, 1, 4, 10),
(56, 4, 5, 1, 1, 4, 17),
(57, 4, 9, 1, 1, 4, 48),
(58, 4, 4, 1, 1, 5, 87),
(59, 4, 5, 1, 1, 5, 98),
(60, 4, 9, 1, 1, 5, 37),
(61, 5, 4, 1, 1, 1, 66),
(62, 5, 5, 1, 1, 1, 27),
(63, 5, 9, 1, 1, 1, 17),
(64, 5, 4, 1, 1, 2, 85),
(65, 5, 5, 1, 1, 2, 94),
(66, 5, 9, 1, 1, 2, 24),
(67, 5, 4, 1, 1, 3, 10),
(68, 5, 5, 1, 1, 3, 60),
(69, 5, 9, 1, 1, 3, 79),
(70, 5, 4, 1, 1, 4, 23),
(71, 5, 5, 1, 1, 4, 51),
(72, 5, 9, 1, 1, 4, 84),
(73, 5, 4, 1, 1, 5, 76),
(74, 5, 5, 1, 1, 5, 26),
(75, 5, 9, 1, 1, 5, 75),
(76, 6, 4, 1, 1, 1, 14),
(77, 6, 5, 1, 1, 1, 17),
(78, 6, 9, 1, 1, 1, 32),
(79, 6, 4, 1, 1, 2, 12),
(80, 6, 5, 1, 1, 2, 43),
(81, 6, 9, 1, 1, 2, 77),
(82, 6, 4, 1, 1, 3, 68),
(83, 6, 5, 1, 1, 3, 98),
(84, 6, 9, 1, 1, 3, 94),
(85, 6, 4, 1, 1, 4, 75),
(86, 6, 5, 1, 1, 4, 82),
(87, 6, 9, 1, 1, 4, 87),
(88, 6, 4, 1, 1, 5, 87),
(89, 6, 5, 1, 1, 5, 76),
(90, 6, 9, 1, 1, 5, 15),
(91, 8, 4, 1, 1, 1, 21),
(92, 8, 5, 1, 1, 1, 51),
(93, 8, 9, 1, 1, 1, 89),
(94, 8, 4, 1, 1, 2, 11),
(95, 8, 5, 1, 1, 2, 52),
(96, 8, 9, 1, 1, 2, 33),
(97, 8, 4, 1, 1, 3, 94),
(98, 8, 5, 1, 1, 3, 85),
(99, 8, 9, 1, 1, 3, 46),
(100, 8, 4, 1, 1, 4, 54),
(101, 8, 5, 1, 1, 4, 32),
(102, 8, 9, 1, 1, 4, 82),
(103, 8, 4, 1, 1, 5, 29),
(104, 8, 5, 1, 1, 5, 70),
(105, 8, 9, 1, 1, 5, 73),
(106, 10, 4, 1, 1, 1, 55),
(107, 10, 5, 1, 1, 1, 48),
(108, 10, 9, 1, 1, 1, 62),
(109, 10, 4, 1, 1, 2, 68),
(110, 10, 5, 1, 1, 2, 53),
(111, 10, 9, 1, 1, 2, 49),
(112, 10, 4, 1, 1, 3, 80),
(113, 10, 5, 1, 1, 3, 59),
(114, 10, 9, 1, 1, 3, 48),
(115, 10, 4, 1, 1, 4, 52),
(116, 10, 5, 1, 1, 4, 18),
(117, 10, 9, 1, 1, 4, 12),
(118, 10, 4, 1, 1, 5, 90),
(119, 10, 5, 1, 1, 5, 41),
(120, 10, 9, 1, 1, 5, 14),
(121, 11, 4, 1, 1, 1, 31),
(122, 11, 5, 1, 1, 1, 11),
(123, 11, 9, 1, 1, 1, 43),
(124, 11, 4, 1, 1, 2, 83),
(125, 11, 5, 1, 1, 2, 95),
(126, 11, 9, 1, 1, 2, 35),
(127, 11, 4, 1, 1, 3, 62),
(128, 11, 5, 1, 1, 3, 13),
(129, 11, 9, 1, 1, 3, 50),
(130, 11, 4, 1, 1, 4, 22),
(131, 11, 5, 1, 1, 4, 40),
(132, 11, 9, 1, 1, 4, 33),
(133, 11, 4, 1, 1, 5, 36),
(134, 11, 5, 1, 1, 5, 70),
(135, 11, 9, 1, 1, 5, 52),
(136, 14, 4, 1, 1, 1, 40),
(137, 14, 5, 1, 1, 1, 33),
(138, 14, 9, 1, 1, 1, 37),
(139, 14, 4, 1, 1, 2, 76),
(140, 14, 5, 1, 1, 2, 77),
(141, 14, 9, 1, 1, 2, 56),
(142, 14, 4, 1, 1, 3, 42),
(143, 14, 5, 1, 1, 3, 30),
(144, 14, 9, 1, 1, 3, 17),
(145, 14, 4, 1, 1, 4, 75),
(146, 14, 5, 1, 1, 4, 40),
(147, 14, 9, 1, 1, 4, 59),
(148, 14, 4, 1, 1, 5, 74),
(149, 14, 5, 1, 1, 5, 92),
(150, 14, 9, 1, 1, 5, 45),
(151, 15, 4, 1, 1, 1, 34),
(152, 15, 5, 1, 1, 1, 23),
(153, 15, 9, 1, 1, 1, 94),
(154, 15, 4, 1, 1, 2, 29),
(155, 15, 5, 1, 1, 2, 34),
(156, 15, 9, 1, 1, 2, 74),
(157, 15, 4, 1, 1, 3, 77),
(158, 15, 5, 1, 1, 3, 62),
(159, 15, 9, 1, 1, 3, 71),
(160, 15, 4, 1, 1, 4, 66),
(161, 15, 5, 1, 1, 4, 17),
(162, 15, 9, 1, 1, 4, 60),
(163, 15, 4, 1, 1, 5, 60),
(164, 15, 5, 1, 1, 5, 16),
(165, 15, 9, 1, 1, 5, 72),
(166, 16, 4, 1, 1, 1, 32),
(167, 16, 5, 1, 1, 1, 24),
(168, 16, 9, 1, 1, 1, 17),
(169, 16, 4, 1, 1, 2, 93),
(170, 16, 5, 1, 1, 2, 40),
(171, 16, 9, 1, 1, 2, 96),
(172, 16, 4, 1, 1, 3, 75),
(173, 16, 5, 1, 1, 3, 79),
(174, 16, 9, 1, 1, 3, 67),
(175, 16, 4, 1, 1, 4, 90),
(176, 16, 5, 1, 1, 4, 58),
(177, 16, 9, 1, 1, 4, 99),
(178, 16, 4, 1, 1, 5, 40),
(179, 16, 5, 1, 1, 5, 77),
(180, 16, 9, 1, 1, 5, 71),
(181, 17, 4, 1, 1, 1, 24),
(182, 17, 5, 1, 1, 1, 80),
(183, 17, 9, 1, 1, 1, 45),
(184, 17, 4, 1, 1, 2, 67),
(185, 17, 5, 1, 1, 2, 97),
(186, 17, 9, 1, 1, 2, 95),
(187, 17, 4, 1, 1, 3, 85),
(188, 17, 5, 1, 1, 3, 36),
(189, 17, 9, 1, 1, 3, 100),
(190, 17, 4, 1, 1, 4, 20),
(191, 17, 5, 1, 1, 4, 61),
(192, 17, 9, 1, 1, 4, 55),
(193, 17, 4, 1, 1, 5, 82),
(194, 17, 5, 1, 1, 5, 54),
(195, 17, 9, 1, 1, 5, 14),
(196, 18, 4, 1, 1, 1, 82),
(197, 18, 5, 1, 1, 1, 85),
(198, 18, 9, 1, 1, 1, 78),
(199, 18, 4, 1, 1, 2, 34),
(200, 18, 5, 1, 1, 2, 19),
(201, 18, 9, 1, 1, 2, 74),
(202, 18, 4, 1, 1, 3, 31),
(203, 18, 5, 1, 1, 3, 14),
(204, 18, 9, 1, 1, 3, 61),
(205, 18, 4, 1, 1, 4, 68),
(206, 18, 5, 1, 1, 4, 58),
(207, 18, 9, 1, 1, 4, 75),
(208, 18, 4, 1, 1, 5, 12),
(209, 18, 5, 1, 1, 5, 99),
(210, 18, 9, 1, 1, 5, 85),
(211, 19, 4, 1, 1, 1, 26),
(212, 19, 5, 1, 1, 1, 49),
(213, 19, 9, 1, 1, 1, 66),
(214, 19, 4, 1, 1, 2, 85),
(215, 19, 5, 1, 1, 2, 32),
(216, 19, 9, 1, 1, 2, 79),
(217, 19, 4, 1, 1, 3, 16),
(218, 19, 5, 1, 1, 3, 15),
(219, 19, 9, 1, 1, 3, 19),
(220, 19, 4, 1, 1, 4, 39),
(221, 19, 5, 1, 1, 4, 39),
(222, 19, 9, 1, 1, 4, 66),
(223, 19, 4, 1, 1, 5, 24),
(224, 19, 5, 1, 1, 5, 94),
(225, 19, 9, 1, 1, 5, 23),
(226, 20, 4, 1, 1, 1, 100),
(227, 20, 5, 1, 1, 1, 54),
(228, 20, 9, 1, 1, 1, 51),
(229, 20, 4, 1, 1, 2, 85),
(230, 20, 5, 1, 1, 2, 80),
(231, 20, 9, 1, 1, 2, 43),
(232, 20, 4, 1, 1, 3, 59),
(233, 20, 5, 1, 1, 3, 64),
(234, 20, 9, 1, 1, 3, 41),
(235, 20, 4, 1, 1, 4, 96),
(236, 20, 5, 1, 1, 4, 73),
(237, 20, 9, 1, 1, 4, 68),
(238, 20, 4, 1, 1, 5, 20),
(239, 20, 5, 1, 1, 5, 68),
(240, 20, 9, 1, 1, 5, 90),
(241, 21, 4, 1, 1, 1, 54),
(242, 21, 5, 1, 1, 1, 83),
(243, 21, 9, 1, 1, 1, 62),
(244, 21, 4, 1, 1, 2, 50),
(245, 21, 5, 1, 1, 2, 54),
(246, 21, 9, 1, 1, 2, 21),
(247, 21, 4, 1, 1, 3, 25),
(248, 21, 5, 1, 1, 3, 51),
(249, 21, 9, 1, 1, 3, 79),
(250, 21, 4, 1, 1, 4, 53),
(251, 21, 5, 1, 1, 4, 18),
(252, 21, 9, 1, 1, 4, 10),
(253, 21, 4, 1, 1, 5, 78),
(254, 21, 5, 1, 1, 5, 80),
(255, 21, 9, 1, 1, 5, 65),
(256, 22, 4, 1, 1, 1, 74),
(257, 22, 5, 1, 1, 1, 76),
(258, 22, 9, 1, 1, 1, 57),
(259, 22, 4, 1, 1, 2, 46),
(260, 22, 5, 1, 1, 2, 52),
(261, 22, 9, 1, 1, 2, 20),
(262, 22, 4, 1, 1, 3, 26),
(263, 22, 5, 1, 1, 3, 60),
(264, 22, 9, 1, 1, 3, 31),
(265, 22, 4, 1, 1, 4, 54),
(266, 22, 5, 1, 1, 4, 80),
(267, 22, 9, 1, 1, 4, 45),
(268, 22, 4, 1, 1, 5, 68),
(269, 22, 5, 1, 1, 5, 11),
(270, 22, 9, 1, 1, 5, 26),
(271, 23, 4, 1, 1, 1, 85),
(272, 23, 5, 1, 1, 1, 64),
(273, 23, 9, 1, 1, 1, 55),
(274, 23, 4, 1, 1, 2, 75),
(275, 23, 5, 1, 1, 2, 20),
(276, 23, 9, 1, 1, 2, 47),
(277, 23, 4, 1, 1, 3, 75),
(278, 23, 5, 1, 1, 3, 41),
(279, 23, 9, 1, 1, 3, 63),
(280, 23, 4, 1, 1, 4, 92),
(281, 23, 5, 1, 1, 4, 80),
(282, 23, 9, 1, 1, 4, 22),
(283, 23, 4, 1, 1, 5, 43),
(284, 23, 5, 1, 1, 5, 47),
(285, 23, 9, 1, 1, 5, 96),
(286, 24, 4, 1, 1, 1, 58),
(287, 24, 5, 1, 1, 1, 83),
(288, 24, 9, 1, 1, 1, 49),
(289, 24, 4, 1, 1, 2, 79),
(290, 24, 5, 1, 1, 2, 57),
(291, 24, 9, 1, 1, 2, 37),
(292, 24, 4, 1, 1, 3, 95),
(293, 24, 5, 1, 1, 3, 82),
(294, 24, 9, 1, 1, 3, 24),
(295, 24, 4, 1, 1, 4, 45),
(296, 24, 5, 1, 1, 4, 56),
(297, 24, 9, 1, 1, 4, 43),
(298, 24, 4, 1, 1, 5, 37),
(299, 24, 5, 1, 1, 5, 48),
(300, 24, 9, 1, 1, 5, 28),
(301, 25, 4, 1, 1, 1, 78),
(302, 25, 5, 1, 1, 1, 22),
(303, 25, 9, 1, 1, 1, 49),
(304, 25, 4, 1, 1, 2, 78),
(305, 25, 5, 1, 1, 2, 51),
(306, 25, 9, 1, 1, 2, 14),
(307, 25, 4, 1, 1, 3, 88),
(308, 25, 5, 1, 1, 3, 26),
(309, 25, 9, 1, 1, 3, 37),
(310, 25, 4, 1, 1, 4, 99),
(311, 25, 5, 1, 1, 4, 100),
(312, 25, 9, 1, 1, 4, 12),
(313, 25, 4, 1, 1, 5, 22),
(314, 25, 5, 1, 1, 5, 67),
(315, 25, 9, 1, 1, 5, 77),
(316, 26, 4, 1, 1, 1, 84),
(317, 26, 5, 1, 1, 1, 86),
(318, 26, 9, 1, 1, 1, 81),
(319, 26, 4, 1, 1, 2, 45),
(320, 26, 5, 1, 1, 2, 62),
(321, 26, 9, 1, 1, 2, 74),
(322, 26, 4, 1, 1, 3, 84),
(323, 26, 5, 1, 1, 3, 96),
(324, 26, 9, 1, 1, 3, 38),
(325, 26, 4, 1, 1, 4, 74),
(326, 26, 5, 1, 1, 4, 66),
(327, 26, 9, 1, 1, 4, 96),
(328, 26, 4, 1, 1, 5, 92),
(329, 26, 5, 1, 1, 5, 70),
(330, 26, 9, 1, 1, 5, 63),
(331, 27, 4, 1, 1, 1, 98),
(332, 27, 5, 1, 1, 1, 19),
(333, 27, 9, 1, 1, 1, 64),
(334, 27, 4, 1, 1, 2, 70),
(335, 27, 5, 1, 1, 2, 57),
(336, 27, 9, 1, 1, 2, 67),
(337, 27, 4, 1, 1, 3, 64),
(338, 27, 5, 1, 1, 3, 19),
(339, 27, 9, 1, 1, 3, 75),
(340, 27, 4, 1, 1, 4, 34),
(341, 27, 5, 1, 1, 4, 28),
(342, 27, 9, 1, 1, 4, 28),
(343, 27, 4, 1, 1, 5, 45),
(344, 27, 5, 1, 1, 5, 43),
(345, 27, 9, 1, 1, 5, 69),
(346, 28, 4, 1, 1, 1, 25),
(347, 28, 5, 1, 1, 1, 88),
(348, 28, 9, 1, 1, 1, 86),
(349, 28, 4, 1, 1, 2, 64),
(350, 28, 5, 1, 1, 2, 51),
(351, 28, 9, 1, 1, 2, 55),
(352, 28, 4, 1, 1, 3, 23),
(353, 28, 5, 1, 1, 3, 32),
(354, 28, 9, 1, 1, 3, 80),
(355, 28, 4, 1, 1, 4, 22),
(356, 28, 5, 1, 1, 4, 44),
(357, 28, 9, 1, 1, 4, 51),
(358, 28, 4, 1, 1, 5, 21),
(359, 28, 5, 1, 1, 5, 37),
(360, 28, 9, 1, 1, 5, 19),
(361, 29, 4, 1, 1, 1, 68),
(362, 29, 5, 1, 1, 1, 91),
(363, 29, 9, 1, 1, 1, 61),
(364, 29, 4, 1, 1, 2, 21),
(365, 29, 5, 1, 1, 2, 95),
(366, 29, 9, 1, 1, 2, 40),
(367, 29, 4, 1, 1, 3, 88),
(368, 29, 5, 1, 1, 3, 35),
(369, 29, 9, 1, 1, 3, 85),
(370, 29, 4, 1, 1, 4, 38),
(371, 29, 5, 1, 1, 4, 14),
(372, 29, 9, 1, 1, 4, 40),
(373, 29, 4, 1, 1, 5, 55),
(374, 29, 5, 1, 1, 5, 54),
(375, 29, 9, 1, 1, 5, 96),
(376, 30, 4, 1, 1, 1, 34),
(377, 30, 5, 1, 1, 1, 57),
(378, 30, 9, 1, 1, 1, 83),
(379, 30, 4, 1, 1, 2, 51),
(380, 30, 5, 1, 1, 2, 89),
(381, 30, 9, 1, 1, 2, 100),
(382, 30, 4, 1, 1, 3, 43),
(383, 30, 5, 1, 1, 3, 86),
(384, 30, 9, 1, 1, 3, 17),
(385, 30, 4, 1, 1, 4, 91),
(386, 30, 5, 1, 1, 4, 32),
(387, 30, 9, 1, 1, 4, 57),
(388, 30, 4, 1, 1, 5, 91),
(389, 30, 5, 1, 1, 5, 92),
(390, 30, 9, 1, 1, 5, 87),
(391, 31, 4, 1, 1, 1, 59),
(392, 31, 5, 1, 1, 1, 25),
(393, 31, 9, 1, 1, 1, 28),
(394, 31, 4, 1, 1, 2, 54),
(395, 31, 5, 1, 1, 2, 89),
(396, 31, 9, 1, 1, 2, 89),
(397, 31, 4, 1, 1, 3, 77),
(398, 31, 5, 1, 1, 3, 20),
(399, 31, 9, 1, 1, 3, 39),
(400, 31, 4, 1, 1, 4, 37),
(401, 31, 5, 1, 1, 4, 59),
(402, 31, 9, 1, 1, 4, 81),
(403, 31, 4, 1, 1, 5, 36),
(404, 31, 5, 1, 1, 5, 22),
(405, 31, 9, 1, 1, 5, 80),
(406, 32, 4, 1, 1, 1, 51),
(407, 32, 5, 1, 1, 1, 99),
(408, 32, 9, 1, 1, 1, 59),
(409, 32, 4, 1, 1, 2, 81),
(410, 32, 5, 1, 1, 2, 36),
(411, 32, 9, 1, 1, 2, 19),
(412, 32, 4, 1, 1, 3, 69),
(413, 32, 5, 1, 1, 3, 94),
(414, 32, 9, 1, 1, 3, 73),
(415, 32, 4, 1, 1, 4, 73),
(416, 32, 5, 1, 1, 4, 45),
(417, 32, 9, 1, 1, 4, 87),
(418, 32, 4, 1, 1, 5, 19),
(419, 32, 5, 1, 1, 5, 96),
(420, 32, 9, 1, 1, 5, 51),
(421, 33, 4, 1, 1, 1, 46),
(422, 33, 5, 1, 1, 1, 70),
(423, 33, 9, 1, 1, 1, 21),
(424, 33, 4, 1, 1, 2, 67),
(425, 33, 5, 1, 1, 2, 78),
(426, 33, 9, 1, 1, 2, 91),
(427, 33, 4, 1, 1, 3, 30),
(428, 33, 5, 1, 1, 3, 47),
(429, 33, 9, 1, 1, 3, 47),
(430, 33, 4, 1, 1, 4, 83),
(431, 33, 5, 1, 1, 4, 83),
(432, 33, 9, 1, 1, 4, 67),
(433, 33, 4, 1, 1, 5, 77),
(434, 33, 5, 1, 1, 5, 83),
(435, 33, 9, 1, 1, 5, 81),
(436, 34, 4, 1, 1, 1, 59),
(437, 34, 5, 1, 1, 1, 40),
(438, 34, 9, 1, 1, 1, 12),
(439, 34, 4, 1, 1, 2, 25),
(440, 34, 5, 1, 1, 2, 78),
(441, 34, 9, 1, 1, 2, 33),
(442, 34, 4, 1, 1, 3, 13),
(443, 34, 5, 1, 1, 3, 46),
(444, 34, 9, 1, 1, 3, 93),
(445, 34, 4, 1, 1, 4, 43),
(446, 34, 5, 1, 1, 4, 16),
(447, 34, 9, 1, 1, 4, 34),
(448, 34, 4, 1, 1, 5, 23),
(449, 34, 5, 1, 1, 5, 92),
(450, 34, 9, 1, 1, 5, 16),
(451, 35, 4, 1, 1, 1, 70),
(452, 35, 5, 1, 1, 1, 21),
(453, 35, 9, 1, 1, 1, 65),
(454, 35, 4, 1, 1, 2, 72),
(455, 35, 5, 1, 1, 2, 66),
(456, 35, 9, 1, 1, 2, 12),
(457, 35, 4, 1, 1, 3, 35),
(458, 35, 5, 1, 1, 3, 37),
(459, 35, 9, 1, 1, 3, 70),
(460, 35, 4, 1, 1, 4, 48),
(461, 35, 5, 1, 1, 4, 22),
(462, 35, 9, 1, 1, 4, 49),
(463, 35, 4, 1, 1, 5, 76),
(464, 35, 5, 1, 1, 5, 41),
(465, 35, 9, 1, 1, 5, 60),
(466, 36, 4, 1, 1, 1, 77),
(467, 36, 5, 1, 1, 1, 13),
(468, 36, 9, 1, 1, 1, 96),
(469, 36, 4, 1, 1, 2, 70),
(470, 36, 5, 1, 1, 2, 53),
(471, 36, 9, 1, 1, 2, 43),
(472, 36, 4, 1, 1, 3, 49),
(473, 36, 5, 1, 1, 3, 13),
(474, 36, 9, 1, 1, 3, 93),
(475, 36, 4, 1, 1, 4, 50),
(476, 36, 5, 1, 1, 4, 54),
(477, 36, 9, 1, 1, 4, 20),
(478, 36, 4, 1, 1, 5, 21),
(479, 36, 5, 1, 1, 5, 34),
(480, 36, 9, 1, 1, 5, 96),
(481, 37, 4, 1, 1, 1, 98),
(482, 37, 5, 1, 1, 1, 10),
(483, 37, 9, 1, 1, 1, 18),
(484, 37, 4, 1, 1, 2, 53),
(485, 37, 5, 1, 1, 2, 20),
(486, 37, 9, 1, 1, 2, 19),
(487, 37, 4, 1, 1, 3, 29),
(488, 37, 5, 1, 1, 3, 76),
(489, 37, 9, 1, 1, 3, 11),
(490, 37, 4, 1, 1, 4, 92),
(491, 37, 5, 1, 1, 4, 51),
(492, 37, 9, 1, 1, 4, 62),
(493, 37, 4, 1, 1, 5, 58),
(494, 37, 5, 1, 1, 5, 91),
(495, 37, 9, 1, 1, 5, 93),
(496, 38, 4, 1, 1, 1, 90),
(497, 38, 5, 1, 1, 1, 69),
(498, 38, 9, 1, 1, 1, 67),
(499, 38, 4, 1, 1, 2, 26),
(500, 38, 5, 1, 1, 2, 10),
(501, 38, 9, 1, 1, 2, 53),
(502, 38, 4, 1, 1, 3, 45),
(503, 38, 5, 1, 1, 3, 55),
(504, 38, 9, 1, 1, 3, 39),
(505, 38, 4, 1, 1, 4, 22),
(506, 38, 5, 1, 1, 4, 72),
(507, 38, 9, 1, 1, 4, 15),
(508, 38, 4, 1, 1, 5, 29),
(509, 38, 5, 1, 1, 5, 92),
(510, 38, 9, 1, 1, 5, 90),
(511, 39, 4, 1, 1, 1, 75),
(512, 39, 5, 1, 1, 1, 96),
(513, 39, 9, 1, 1, 1, 63),
(514, 39, 4, 1, 1, 2, 16),
(515, 39, 5, 1, 1, 2, 66),
(516, 39, 9, 1, 1, 2, 87),
(517, 39, 4, 1, 1, 3, 49),
(518, 39, 5, 1, 1, 3, 64),
(519, 39, 9, 1, 1, 3, 73),
(520, 39, 4, 1, 1, 4, 73),
(521, 39, 5, 1, 1, 4, 45),
(522, 39, 9, 1, 1, 4, 88),
(523, 39, 4, 1, 1, 5, 23),
(524, 39, 5, 1, 1, 5, 22),
(525, 39, 9, 1, 1, 5, 30),
(526, 40, 4, 1, 1, 1, 77),
(527, 40, 5, 1, 1, 1, 12),
(528, 40, 9, 1, 1, 1, 90),
(529, 40, 4, 1, 1, 2, 44),
(530, 40, 5, 1, 1, 2, 31),
(531, 40, 9, 1, 1, 2, 12),
(532, 40, 4, 1, 1, 3, 48),
(533, 40, 5, 1, 1, 3, 12),
(534, 40, 9, 1, 1, 3, 92),
(535, 40, 4, 1, 1, 4, 47),
(536, 40, 5, 1, 1, 4, 40),
(537, 40, 9, 1, 1, 4, 52),
(538, 40, 4, 1, 1, 5, 38),
(539, 40, 5, 1, 1, 5, 26),
(540, 40, 9, 1, 1, 5, 96),
(541, 41, 4, 1, 1, 1, 31),
(542, 41, 5, 1, 1, 1, 38),
(543, 41, 9, 1, 1, 1, 86),
(544, 41, 4, 1, 1, 2, 35),
(545, 41, 5, 1, 1, 2, 91),
(546, 41, 9, 1, 1, 2, 68),
(547, 41, 4, 1, 1, 3, 55),
(548, 41, 5, 1, 1, 3, 62),
(549, 41, 9, 1, 1, 3, 46),
(550, 41, 4, 1, 1, 4, 34),
(551, 41, 5, 1, 1, 4, 22),
(552, 41, 9, 1, 1, 4, 91),
(553, 41, 4, 1, 1, 5, 14),
(554, 41, 5, 1, 1, 5, 60),
(555, 41, 9, 1, 1, 5, 69),
(556, 42, 4, 1, 1, 1, 64),
(557, 42, 5, 1, 1, 1, 12),
(558, 42, 9, 1, 1, 1, 42),
(559, 42, 4, 1, 1, 2, 73),
(560, 42, 5, 1, 1, 2, 49),
(561, 42, 9, 1, 1, 2, 15),
(562, 42, 4, 1, 1, 3, 10),
(563, 42, 5, 1, 1, 3, 86),
(564, 42, 9, 1, 1, 3, 25),
(565, 42, 4, 1, 1, 4, 43),
(566, 42, 5, 1, 1, 4, 37),
(567, 42, 9, 1, 1, 4, 46),
(568, 42, 4, 1, 1, 5, 18),
(569, 42, 5, 1, 1, 5, 34),
(570, 42, 9, 1, 1, 5, 15),
(571, 43, 4, 1, 1, 1, 54),
(572, 43, 5, 1, 1, 1, 34),
(573, 43, 9, 1, 1, 1, 89),
(574, 43, 4, 1, 1, 2, 59),
(575, 43, 5, 1, 1, 2, 20),
(576, 43, 9, 1, 1, 2, 94),
(577, 43, 4, 1, 1, 3, 36),
(578, 43, 5, 1, 1, 3, 73),
(579, 43, 9, 1, 1, 3, 66),
(580, 43, 4, 1, 1, 4, 100),
(581, 43, 5, 1, 1, 4, 20),
(582, 43, 9, 1, 1, 4, 62),
(583, 43, 4, 1, 1, 5, 58),
(584, 43, 5, 1, 1, 5, 95),
(585, 43, 9, 1, 1, 5, 20),
(586, 44, 4, 1, 1, 1, 76),
(587, 44, 5, 1, 1, 1, 40),
(588, 44, 9, 1, 1, 1, 51),
(589, 44, 4, 1, 1, 2, 34),
(590, 44, 5, 1, 1, 2, 99),
(591, 44, 9, 1, 1, 2, 18),
(592, 44, 4, 1, 1, 3, 59),
(593, 44, 5, 1, 1, 3, 50),
(594, 44, 9, 1, 1, 3, 63),
(595, 44, 4, 1, 1, 4, 65),
(596, 44, 5, 1, 1, 4, 35),
(597, 44, 9, 1, 1, 4, 60),
(598, 44, 4, 1, 1, 5, 94),
(599, 44, 5, 1, 1, 5, 10),
(600, 44, 9, 1, 1, 5, 29),
(601, 45, 4, 1, 1, 1, 15),
(602, 45, 5, 1, 1, 1, 69),
(603, 45, 9, 1, 1, 1, 18),
(604, 45, 4, 1, 1, 2, 58),
(605, 45, 5, 1, 1, 2, 41),
(606, 45, 9, 1, 1, 2, 22),
(607, 45, 4, 1, 1, 3, 71),
(608, 45, 5, 1, 1, 3, 97),
(609, 45, 9, 1, 1, 3, 78),
(610, 45, 4, 1, 1, 4, 92),
(611, 45, 5, 1, 1, 4, 33),
(612, 45, 9, 1, 1, 4, 60),
(613, 45, 4, 1, 1, 5, 13),
(614, 45, 5, 1, 1, 5, 54),
(615, 45, 9, 1, 1, 5, 42),
(616, 61, 4, 1, 1, 1, 38),
(617, 61, 5, 1, 1, 1, 56),
(618, 61, 9, 1, 1, 1, 63),
(619, 61, 4, 1, 1, 2, 46),
(620, 61, 5, 1, 1, 2, 32),
(621, 61, 9, 1, 1, 2, 13),
(622, 61, 4, 1, 1, 3, 53),
(623, 61, 5, 1, 1, 3, 31),
(624, 61, 9, 1, 1, 3, 77),
(625, 61, 4, 1, 1, 4, 100),
(626, 61, 5, 1, 1, 4, 80),
(627, 61, 9, 1, 1, 4, 88),
(628, 61, 4, 1, 1, 5, 100),
(629, 61, 5, 1, 1, 5, 46),
(630, 61, 9, 1, 1, 5, 10),
(631, 62, 4, 1, 1, 1, 86),
(632, 62, 5, 1, 1, 1, 27),
(633, 62, 9, 1, 1, 1, 47),
(634, 62, 4, 1, 1, 2, 56),
(635, 62, 5, 1, 1, 2, 37),
(636, 62, 9, 1, 1, 2, 100),
(637, 62, 4, 1, 1, 3, 14),
(638, 62, 5, 1, 1, 3, 35),
(639, 62, 9, 1, 1, 3, 30),
(640, 62, 4, 1, 1, 4, 38),
(641, 62, 5, 1, 1, 4, 91),
(642, 62, 9, 1, 1, 4, 58),
(643, 62, 4, 1, 1, 5, 96),
(644, 62, 5, 1, 1, 5, 26),
(645, 62, 9, 1, 1, 5, 13),
(646, 63, 4, 1, 1, 1, 69),
(647, 63, 5, 1, 1, 1, 26),
(648, 63, 9, 1, 1, 1, 92),
(649, 63, 4, 1, 1, 2, 100),
(650, 63, 5, 1, 1, 2, 33),
(651, 63, 9, 1, 1, 2, 37),
(652, 63, 4, 1, 1, 3, 79),
(653, 63, 5, 1, 1, 3, 90),
(654, 63, 9, 1, 1, 3, 21),
(655, 63, 4, 1, 1, 4, 98),
(656, 63, 5, 1, 1, 4, 52),
(657, 63, 9, 1, 1, 4, 51),
(658, 63, 4, 1, 1, 5, 87),
(659, 63, 5, 1, 1, 5, 91),
(660, 63, 9, 1, 1, 5, 93),
(661, 64, 4, 1, 1, 1, 92),
(662, 64, 5, 1, 1, 1, 79),
(663, 64, 9, 1, 1, 1, 21),
(664, 64, 4, 1, 1, 2, 39),
(665, 64, 5, 1, 1, 2, 32),
(666, 64, 9, 1, 1, 2, 34),
(667, 64, 4, 1, 1, 3, 66),
(668, 64, 5, 1, 1, 3, 35),
(669, 64, 9, 1, 1, 3, 60),
(670, 64, 4, 1, 1, 4, 93),
(671, 64, 5, 1, 1, 4, 92),
(672, 64, 9, 1, 1, 4, 81),
(673, 64, 4, 1, 1, 5, 31),
(674, 64, 5, 1, 1, 5, 81),
(675, 64, 9, 1, 1, 5, 33),
(676, 65, 4, 1, 1, 1, 91),
(677, 65, 5, 1, 1, 1, 76),
(678, 65, 9, 1, 1, 1, 97),
(679, 65, 4, 1, 1, 2, 67),
(680, 65, 5, 1, 1, 2, 35),
(681, 65, 9, 1, 1, 2, 55),
(682, 65, 4, 1, 1, 3, 70),
(683, 65, 5, 1, 1, 3, 84),
(684, 65, 9, 1, 1, 3, 18),
(685, 65, 4, 1, 1, 4, 11),
(686, 65, 5, 1, 1, 4, 83),
(687, 65, 9, 1, 1, 4, 10),
(688, 65, 4, 1, 1, 5, 62),
(689, 65, 5, 1, 1, 5, 88),
(690, 65, 9, 1, 1, 5, 63),
(706, 56, 4, 1, 1, 1, 52),
(707, 56, 5, 1, 1, 1, 59),
(708, 56, 9, 1, 1, 1, 42),
(709, 56, 4, 1, 1, 2, 21),
(710, 56, 5, 1, 1, 2, 60),
(711, 56, 9, 1, 1, 2, 45),
(712, 56, 4, 1, 1, 3, 34),
(713, 56, 5, 1, 1, 3, 29),
(714, 56, 9, 1, 1, 3, 31),
(715, 56, 4, 1, 1, 4, 60),
(716, 56, 5, 1, 1, 4, 13),
(717, 56, 9, 1, 1, 4, 59),
(718, 56, 4, 1, 1, 5, 65),
(719, 56, 5, 1, 1, 5, 49),
(720, 56, 9, 1, 1, 5, 40),
(721, 57, 4, 1, 1, 1, 44),
(722, 57, 5, 1, 1, 1, 88),
(723, 57, 9, 1, 1, 1, 27),
(724, 57, 4, 1, 1, 2, 43),
(725, 57, 5, 1, 1, 2, 33),
(726, 57, 9, 1, 1, 2, 27),
(727, 57, 4, 1, 1, 3, 26),
(728, 57, 5, 1, 1, 3, 40),
(729, 57, 9, 1, 1, 3, 20),
(730, 57, 4, 1, 1, 4, 62),
(731, 57, 5, 1, 1, 4, 59),
(732, 57, 9, 1, 1, 4, 100),
(733, 57, 4, 1, 1, 5, 39),
(734, 57, 5, 1, 1, 5, 67),
(735, 57, 9, 1, 1, 5, 29),
(736, 58, 4, 1, 1, 1, 26),
(737, 58, 5, 1, 1, 1, 33),
(738, 58, 9, 1, 1, 1, 79),
(739, 58, 4, 1, 1, 2, 11),
(740, 58, 5, 1, 1, 2, 84),
(741, 58, 9, 1, 1, 2, 11),
(742, 58, 4, 1, 1, 3, 67),
(743, 58, 5, 1, 1, 3, 22),
(744, 58, 9, 1, 1, 3, 78),
(745, 58, 4, 1, 1, 4, 43),
(746, 58, 5, 1, 1, 4, 64),
(747, 58, 9, 1, 1, 4, 91),
(748, 58, 4, 1, 1, 5, 72),
(749, 58, 5, 1, 1, 5, 76),
(750, 58, 9, 1, 1, 5, 64),
(751, 59, 4, 1, 1, 1, 83),
(752, 59, 5, 1, 1, 1, 30),
(753, 59, 9, 1, 1, 1, 73),
(754, 59, 4, 1, 1, 2, 83),
(755, 59, 5, 1, 1, 2, 95),
(756, 59, 9, 1, 1, 2, 36),
(757, 59, 4, 1, 1, 3, 69),
(758, 59, 5, 1, 1, 3, 43),
(759, 59, 9, 1, 1, 3, 91),
(760, 59, 4, 1, 1, 4, 42),
(761, 59, 5, 1, 1, 4, 20),
(762, 59, 9, 1, 1, 4, 55),
(763, 59, 4, 1, 1, 5, 24),
(764, 59, 5, 1, 1, 5, 38),
(765, 59, 9, 1, 1, 5, 15),
(766, 60, 4, 1, 1, 1, 43),
(767, 60, 5, 1, 1, 1, 71),
(768, 60, 9, 1, 1, 1, 33),
(769, 60, 4, 1, 1, 2, 34),
(770, 60, 5, 1, 1, 2, 61),
(771, 60, 9, 1, 1, 2, 10),
(772, 60, 4, 1, 1, 3, 40),
(773, 60, 5, 1, 1, 3, 70),
(774, 60, 9, 1, 1, 3, 37),
(775, 60, 4, 1, 1, 4, 58),
(776, 60, 5, 1, 1, 4, 78),
(777, 60, 9, 1, 1, 4, 25),
(778, 60, 4, 1, 1, 5, 63),
(779, 60, 5, 1, 1, 5, 47),
(780, 60, 9, 1, 1, 5, 39),
(781, 46, 4, 1, 1, 1, 46),
(782, 46, 5, 1, 1, 1, 10),
(783, 46, 9, 1, 1, 1, 83),
(784, 46, 4, 1, 1, 2, 13),
(785, 46, 5, 1, 1, 2, 79),
(786, 46, 9, 1, 1, 2, 76),
(787, 46, 4, 1, 1, 3, 40),
(788, 46, 5, 1, 1, 3, 54),
(789, 46, 9, 1, 1, 3, 50),
(790, 46, 4, 1, 1, 4, 79),
(791, 46, 5, 1, 1, 4, 54),
(792, 46, 9, 1, 1, 4, 23),
(793, 46, 4, 1, 1, 5, 34),
(794, 46, 5, 1, 1, 5, 93),
(795, 46, 9, 1, 1, 5, 81),
(796, 47, 4, 1, 1, 1, 25),
(797, 47, 5, 1, 1, 1, 55),
(798, 47, 9, 1, 1, 1, 100),
(799, 47, 4, 1, 1, 2, 52),
(800, 47, 5, 1, 1, 2, 39),
(801, 47, 9, 1, 1, 2, 32),
(802, 47, 4, 1, 1, 3, 34),
(803, 47, 5, 1, 1, 3, 64),
(804, 47, 9, 1, 1, 3, 27),
(805, 47, 4, 1, 1, 4, 26),
(806, 47, 5, 1, 1, 4, 38),
(807, 47, 9, 1, 1, 4, 11),
(808, 47, 4, 1, 1, 5, 23),
(809, 47, 5, 1, 1, 5, 70),
(810, 47, 9, 1, 1, 5, 93),
(811, 48, 4, 1, 1, 1, 61),
(812, 48, 5, 1, 1, 1, 18),
(813, 48, 9, 1, 1, 1, 78),
(814, 48, 4, 1, 1, 2, 54),
(815, 48, 5, 1, 1, 2, 25),
(816, 48, 9, 1, 1, 2, 44),
(817, 48, 4, 1, 1, 3, 46),
(818, 48, 5, 1, 1, 3, 89),
(819, 48, 9, 1, 1, 3, 22),
(820, 48, 4, 1, 1, 4, 16),
(821, 48, 5, 1, 1, 4, 97),
(822, 48, 9, 1, 1, 4, 64),
(823, 48, 4, 1, 1, 5, 17),
(824, 48, 5, 1, 1, 5, 69),
(825, 48, 9, 1, 1, 5, 99),
(826, 49, 4, 1, 1, 1, 99),
(827, 49, 5, 1, 1, 1, 96),
(828, 49, 9, 1, 1, 1, 84),
(829, 49, 4, 1, 1, 2, 32),
(830, 49, 5, 1, 1, 2, 79),
(831, 49, 9, 1, 1, 2, 18),
(832, 49, 4, 1, 1, 3, 25),
(833, 49, 5, 1, 1, 3, 63),
(834, 49, 9, 1, 1, 3, 48),
(835, 49, 4, 1, 1, 4, 39),
(836, 49, 5, 1, 1, 4, 44),
(837, 49, 9, 1, 1, 4, 93),
(838, 49, 4, 1, 1, 5, 52),
(839, 49, 5, 1, 1, 5, 60),
(840, 49, 9, 1, 1, 5, 44),
(841, 50, 4, 1, 1, 1, 29),
(842, 50, 5, 1, 1, 1, 95),
(843, 50, 9, 1, 1, 1, 14),
(844, 50, 4, 1, 1, 2, 48),
(845, 50, 5, 1, 1, 2, 96),
(846, 50, 9, 1, 1, 2, 56),
(847, 50, 4, 1, 1, 3, 74),
(848, 50, 5, 1, 1, 3, 11),
(849, 50, 9, 1, 1, 3, 94),
(850, 50, 4, 1, 1, 4, 63),
(851, 50, 5, 1, 1, 4, 26),
(852, 50, 9, 1, 1, 4, 23),
(853, 50, 4, 1, 1, 5, 26),
(854, 50, 5, 1, 1, 5, 52),
(855, 50, 9, 1, 1, 5, 82),
(856, 51, 4, 1, 1, 1, 62),
(857, 51, 5, 1, 1, 1, 54),
(858, 51, 9, 1, 1, 1, 76),
(859, 51, 4, 1, 1, 2, 24),
(860, 51, 5, 1, 1, 2, 65),
(861, 51, 9, 1, 1, 2, 63),
(862, 51, 4, 1, 1, 3, 21),
(863, 51, 5, 1, 1, 3, 86),
(864, 51, 9, 1, 1, 3, 84),
(865, 51, 4, 1, 1, 4, 62),
(866, 51, 5, 1, 1, 4, 51),
(867, 51, 9, 1, 1, 4, 57),
(868, 51, 4, 1, 1, 5, 32),
(869, 51, 5, 1, 1, 5, 70),
(870, 51, 9, 1, 1, 5, 63),
(871, 52, 4, 1, 1, 1, 97),
(872, 52, 5, 1, 1, 1, 11),
(873, 52, 9, 1, 1, 1, 26),
(874, 52, 4, 1, 1, 2, 91),
(875, 52, 5, 1, 1, 2, 92),
(876, 52, 9, 1, 1, 2, 88),
(877, 52, 4, 1, 1, 3, 62),
(878, 52, 5, 1, 1, 3, 37),
(879, 52, 9, 1, 1, 3, 81),
(880, 52, 4, 1, 1, 4, 12),
(881, 52, 5, 1, 1, 4, 79),
(882, 52, 9, 1, 1, 4, 77),
(883, 52, 4, 1, 1, 5, 47),
(884, 52, 5, 1, 1, 5, 87),
(885, 52, 9, 1, 1, 5, 10),
(886, 53, 4, 1, 1, 1, 53),
(887, 53, 5, 1, 1, 1, 45),
(888, 53, 9, 1, 1, 1, 58),
(889, 53, 4, 1, 1, 2, 51),
(890, 53, 5, 1, 1, 2, 73),
(891, 53, 9, 1, 1, 2, 19),
(892, 53, 4, 1, 1, 3, 51),
(893, 53, 5, 1, 1, 3, 96),
(894, 53, 9, 1, 1, 3, 43),
(895, 53, 4, 1, 1, 4, 11),
(896, 53, 5, 1, 1, 4, 96),
(897, 53, 9, 1, 1, 4, 76),
(898, 53, 4, 1, 1, 5, 82),
(899, 53, 5, 1, 1, 5, 81),
(900, 53, 9, 1, 1, 5, 59),
(901, 54, 4, 1, 1, 1, 41),
(902, 54, 5, 1, 1, 1, 18),
(903, 54, 9, 1, 1, 1, 51),
(904, 54, 4, 1, 1, 2, 10),
(905, 54, 5, 1, 1, 2, 70),
(906, 54, 9, 1, 1, 2, 38),
(907, 54, 4, 1, 1, 3, 61),
(908, 54, 5, 1, 1, 3, 90),
(909, 54, 9, 1, 1, 3, 78),
(910, 54, 4, 1, 1, 4, 16),
(911, 54, 5, 1, 1, 4, 20),
(912, 54, 9, 1, 1, 4, 41),
(913, 54, 4, 1, 1, 5, 46),
(914, 54, 5, 1, 1, 5, 96),
(915, 54, 9, 1, 1, 5, 60),
(916, 55, 4, 1, 1, 1, 95),
(917, 55, 5, 1, 1, 1, 11),
(918, 55, 9, 1, 1, 1, 32),
(919, 55, 4, 1, 1, 2, 30),
(920, 55, 5, 1, 1, 2, 41),
(921, 55, 9, 1, 1, 2, 17),
(922, 55, 4, 1, 1, 3, 43),
(923, 55, 5, 1, 1, 3, 62),
(924, 55, 9, 1, 1, 3, 82),
(925, 55, 4, 1, 1, 4, 31),
(926, 55, 5, 1, 1, 4, 83),
(927, 55, 9, 1, 1, 4, 40),
(928, 55, 4, 1, 1, 5, 31),
(929, 55, 5, 1, 1, 5, 25),
(930, 55, 9, 1, 1, 5, 22),
(1024, 67, 9, 5, 1, 1, 1);

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
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `phone` varchar(15) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `login_day` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `phone`, `dob`, `gender`, `login_day`) VALUES
(0, 'name', 'email@gmail.com', '000000', 'user', '0000000000', NULL, 1, '2025-12-05 06:35:40'),
(1, 'Admin User', 'admin@gmail.com', '123456', 'admin', '0123456789', NULL, NULL, '2025-11-26 00:00:00'),
(2, 'Test User', 'test@example.com', '123456', 'user', '0987654321', NULL, NULL, '2025-11-25 00:00:00'),
(3, 'Liêm Trần', 'liemtran3107@gmail.com', '123', 'user', '', NULL, NULL, '2025-12-01 16:53:27'),
(5, 'Hứa Minh Thiên', 'thien@gmail.com', '123456', 'user', '0906761390', '2006-12-04', 1, '2025-12-01 23:19:15'),
(7, 'tuan', 'tuan@gmail.com', '123456', 'user', '0906761390', '2006-12-22', 1, '2025-12-02 09:03:14'),
(8, 'name', 'email@gmail.com', '000000', 'user', '0000000000', NULL, 1, '2025-12-05 06:35:40');

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
  ADD UNIQUE KEY `uk_user_cart` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_cart_variant` (`cart_id`,`productVariant_id`),
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
  ADD KEY `gender_id` (`gender_id`);

--
-- Chỉ mục cho bảng `product_variant`
--
ALTER TABLE `product_variant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_product_category` (`product_id`,`category_id`),
  ADD KEY `idx_gender_category` (`gender_id`,`category_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `billdetail`
--
ALTER TABLE `billdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `cartdetail`
--
ALTER TABLE `cartdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1025;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
