[file name]: duan_1.sql
[file content begin]
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 28, 2025 lúc 07:33 PM
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
(2, 2, 1, '2025-11-28 15:45:00', 'completed', 1197000);

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
(2, 7, 1, 550000, 2);

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
(1, 2, '2025-11-28 23:00:00');

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
(1, 1, 1, 5),
(2, 1, 4, 1),
(4, 1, 5, 12),
(6, 1, 3, 1);

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
(16, 'Áo Thun Freelancer In Hình "Nature Beats" FWTS25SS08G', 300000, 'Áo Nữ AURA là tuyên ngôn phong cách cho cô nàng hiện đại. Thiết kế tinh tế, cắt may ôm vừa vặn giúp tôn lên vẻ duyên dáng và nữ tính. Chất vải mềm mại, thấm hút tốt, đảm bảo sự thoải mái suốt cả ngày. Hoàn hảo để bạn tỏa sáng, dù là dạo phố hay công sở.', 'ao-nu6-Áo Thun Freelancer In Hình "Nature Beats" FWTS25SS08G.jpg', 'ao-nu6.2-Áo Thun Freelancer In Hình "Nature Beats" FWTS25SS08G.jpg', 1, 2),
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
(28, 'Quần Tây Nam Form Vừa DP25SS08C-NMSC', 450000, 'Mẫu quần tây DP25SS08C với gam màu trang nhã, dễ phối đồ là "vũ khí" bí mật của các quý ông công sở. Form quần đứng dáng, giúp "hack" dáng chân dài hơn.', 'quan-nam8-Quần Tây Nam Form Vừa DP25SS08C-NMSC.jpg', 'quan-nam8.1-Quần Tây Nam Form Vừa DP25SS08C-NMSC.jpg', 2, 1),
(29, 'Quần Tây Nam Form Vừa DP25ES01P-NM', 430000, 'Thiết kế Basic đơn giản nhưng không hề đơn điệu. DP25ES01P tập trung vào chất lượng đường kim mũi chỉ và chất liệu vải nhập khẩu. Quần có độ co giãn 4 chiều nhẹ.', 'quan-nam9-Quần Tây Nam Form Vừa DP25ES01P-NM.jpg', 'quan-nam9.1-Quần Tây Nam Form Vừa DP25ES01P-NM.jpg', 2, 1),
(30, 'Quần Tây Nam Form Vừa DP24SS03T-NM', 470000, 'Sản phẩm mới nhất DP24SS03T mang đến làn gió mới cho tủ đồ của bạn. Thiết kế cạp quần thông minh giúp cố định áo khi sơ vin, tránh xộc xệch.', 'quan-nam10-Quần Tây Nam Form Vừa DP24SS03T-NM.jpg', 'quan-nam10.1-Quần Tây Nam Form Vừa DP24SS03T-NM.jpg', 2, 1),
(31, 'Quần Tây Nữ Màu Nâu – FWDP25FH08C', 450000, 'Sắc nâu trầm ấm mang lại vẻ đẹp cổ điển và thanh lịch cho quý cô công sở. Mẫu quần FWDP25FH08C với thiết kế lưng cao giúp "hack" dáng chân dài miên man.', 'quan-nu1-Quần Tây Nữ Màu Nâu – FWDP25FH08C.jpg', 'quan-nu1.1-Quần Tây Nữ Màu Nâu – FWDP25FH08C.jpg', 2, 2),
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
(66, 'Túi Tote Nữ Thời Trang FWBA24SS01', 550000, 'Trẻ trung và năng động với mẫu túi Tote FWBA24SS01. Thiết kế form túi đứng cứng cáp, không bị mất dáng khi để ít đồ. Quai đeo vai chắc chắn, độ dài vừa phải.', 'tui.nu2-Túi Tote Nữ Thời Trang FWBA24SS01.jpg', 'tui.nu2.1-Túi Tote Nữ Thời Trang FWBA24SS01.jpg', 5, 2);

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

-- Thêm biến thể sản phẩm cho các sản phẩm áo nam (ID 1-7)
INSERT INTO `product_variant` (`product_id`, `color_id`, `size_id`, `quantity`) VALUES
-- Áo Polo KS25FH47C-SCWK (ID 1)
(1, 4, 1, 50), (1, 4, 2, 45), (1, 4, 3, 30), (1, 5, 1, 40), (1, 5, 2, 35), (1, 5, 3, 25),
-- Áo Polo KS25FH50T-SCWK (ID 2)
(2, 4, 1, 55), (2, 4, 2, 50), (2, 4, 3, 40), (2, 2, 1, 45), (2, 2, 2, 40), (2, 2, 3, 35),
-- Áo Polo KS26SS40-AT (ID 3)
(3, 5, 2, 15), (3, 5, 3, 12), (3, 5, 4, 10), (3, 6, 2, 12), (3, 6, 3, 10), (3, 6, 4, 8),
-- Áo Polo Nam Tay Ngắn Form Vừa KS25FH40C-SCHE (ID 4)
(4, 5, 1, 30), (4, 5, 2, 25), (4, 5, 3, 20), (4, 6, 1, 25), (4, 6, 2, 20), (4, 6, 3, 15),
-- Áo Polo Nam Tay Ngắn Form Vừa KS25FH46T-SCCA (ID 5)
(5, 2, 2, 20), (5, 2, 3, 18), (5, 2, 4, 15), (5, 4, 2, 18), (5, 4, 3, 15), (5, 4, 4, 12),
-- Áo Polo Nam Tay Ngắn Form Vừa KS25FH48T-SCWK (ID 6)
(6, 4, 1, 40), (6, 4, 2, 35), (6, 4, 3, 30), (6, 5, 1, 35), (6, 5, 2, 30), (6, 5, 3, 25),

-- Thêm biến thể cho các sản phẩm áo nữ (ID 8-20)
-- Áo Thun Nữ Basic Cut-Out FWTS25SS14C (ID 8)
(8, 9, 1, 30), (8, 9, 2, 25), (8, 9, 3, 20), (8, 10, 1, 25), (8, 10, 2, 20), (8, 10, 3, 15),
-- Áo Polo Cổ Viền Tương Phản FWKS25FH04C (ID 10)
(10, 5, 1, 20), (10, 5, 2, 18), (10, 5, 3, 15), (10, 2, 1, 18), (10, 2, 2, 15), (10, 2, 3, 12),
-- Áo Thun Polo Nữ – FWKS25SS05G (ID 11)
(11, 3, 1, 25), (11, 3, 2, 20), (11, 3, 3, 18), (11, 8, 1, 20), (11, 8, 2, 18), (11, 8, 3, 15),
-- Áo Thun Polo Nữ Kẻ Sọc FWKS25SS07C (ID 14)
(14, 2, 1, 30), (14, 2, 2, 25), (14, 2, 3, 20), (14, 5, 1, 25), (14, 5, 2, 20), (14, 5, 3, 15),
-- Áo Thun Trắng Cổ Tròn Xẻ Tà FWTS25SS15C (ID 15)
(15, 5, 1, 35), (15, 5, 2, 30), (15, 5, 3, 25), (15, 9, 1, 30), (15, 9, 2, 25), (15, 9, 3, 20),
-- Áo Thun Freelancer In Hình "Nature Beats" FWTS25SS08G (ID 16)
(16, 4, 1, 40), (16, 4, 2, 35), (16, 4, 3, 30), (16, 7, 1, 35), (16, 7, 2, 30), (16, 7, 3, 25),
-- Áo Thun Nữ Cá Tính FWTS24FH05G (ID 17)
(17, 4, 1, 15), (17, 4, 2, 12), (17, 4, 3, 10), (17, 10, 1, 12), (17, 10, 2, 10), (17, 10, 3, 8),
-- Áo Polo Nữ Cổ Lưới FWKS25SS11G (ID 18)
(18, 5, 1, 10), (18, 5, 2, 8), (18, 5, 3, 6), (18, 9, 1, 8), (18, 9, 2, 6), (18, 9, 3, 5),
-- Áo Thun Polo Nữ FWKS24FH03G (ID 19)
(19, 2, 1, 20), (19, 2, 2, 18), (19, 2, 3, 15), (19, 8, 1, 18), (19, 8, 2, 15), (19, 8, 3, 12),
-- Áo Polo Nữ Cá Tính FWKS24SS03G (ID 20)
(20, 4, 1, 8), (20, 4, 2, 6), (20, 4, 3, 5), (20, 10, 1, 6), (20, 10, 2, 5), (20, 10, 3, 4),

-- Thêm biến thể cho các sản phẩm quần nam (ID 21-30)
-- Quần Tây Nam Form Ôm Vừa DP25FH13T-NMSC (ID 21)
(21, 4, 2, 25), (21, 4, 3, 20), (21, 4, 4, 15), (21, 6, 2, 20), (21, 6, 3, 15), (21, 6, 4, 12),
-- Quần Tây Nam Form Ôm Vừa DP25FH12T-EPSC (ID 22)
(22, 6, 2, 20), (22, 6, 3, 18), (22, 6, 4, 15), (22, 4, 2, 18), (22, 4, 3, 15), (22, 4, 4, 12),
-- Quần Tây Nam Form Ôm Vừa DP25FH11T-NMSC (ID 23)
(23, 4, 2, 30), (23, 4, 3, 25), (23, 4, 4, 20), (23, 6, 2, 25), (23, 6, 3, 20), (23, 6, 4, 15),
-- Quần Tây Nam Form Ôm Vừa DP25FH14P-NMSC (ID 24)
(24, 4, 2, 25), (24, 4, 3, 20), (24, 4, 4, 18), (24, 6, 2, 20), (24, 6, 3, 18), (24, 6, 4, 15),
-- Quần Tây Nam Form Ôm Vừa DP25ES01P-NMSC (ID 25)
(25, 4, 2, 35), (25, 4, 3, 30), (25, 4, 4, 25), (25, 6, 2, 30), (25, 6, 3, 25), (25, 6, 4, 20),
-- Quần Tây Nam Form Vừa DP25FH09P-NMSC (ID 26)
(26, 4, 2, 30), (26, 4, 3, 25), (26, 4, 4, 20), (26, 6, 2, 25), (26, 6, 3, 20), (26, 6, 4, 15),
-- Quần Tây Nam Form Vừa DP25FH10C-NMRG (ID 27)
(27, 4, 2, 20), (27, 4, 3, 18), (27, 4, 4, 15), (27, 6, 2, 18), (27, 6, 3, 15), (27, 6, 4, 12),
-- Quần Tây Nam Form Vừa DP25SS08C-NMSC (ID 28)
(28, 4, 2, 25), (28, 4, 3, 20), (28, 4, 4, 18), (28, 6, 2, 20), (28, 6, 3, 18), (28, 6, 4, 15),
-- Quần Tây Nam Form Vừa DP25ES01P-NM (ID 29)
(29, 4, 2, 30), (29, 4, 3, 25), (29, 4, 4, 20), (29, 6, 2, 25), (29, 6, 3, 20), (29, 6, 4, 15),
-- Quần Tây Nam Form Vừa DP24SS03T-NM (ID 30)
(30, 4, 2, 25), (30, 4, 3, 20), (30, 4, 4, 18), (30, 6, 2, 20), (30, 6, 3, 18), (30, 6, 4, 15),

-- Thêm biến thể cho các sản phẩm quần nữ (ID 31-40)
-- Quần Tây Nữ Màu Nâu – FWDP25FH08C (ID 31)
(31, 8, 2, 20), (31, 8, 3, 18), (31, 8, 4, 15), (31, 6, 2, 18), (31, 6, 3, 15), (31, 6, 4, 12),
-- Quần Tây Lửng Màu Beige FWDP25FH09C (ID 32)
(32, 5, 2, 25), (32, 5, 3, 20), (32, 5, 4, 18), (32, 9, 2, 20), (32, 9, 3, 18), (32, 9, 4, 15),
-- Quần Tây Nữ Xám Ống Rộng FWDP25SS01C (ID 33)
(33, 6, 2, 20), (33, 6, 3, 18), (33, 6, 4, 15), (33, 4, 2, 18), (33, 4, 3, 15), (33, 4, 4, 12),
-- Quần Tây Nữ Form Ôm FWDP25SS07C (ID 34)
(34, 4, 2, 25), (34, 4, 3, 20), (34, 4, 4, 18), (34, 10, 2, 20), (34, 10, 3, 18), (34, 10, 4, 15),
-- Quần Tây Slimfit Freelancer FWDP24FH01C (ID 35)
(35, 4, 2, 20), (35, 4, 3, 18), (35, 4, 4, 15), (35, 6, 2, 18), (35, 6, 3, 15), (35, 6, 4, 12),
-- Quần Tây Ống Rộng Freelancer - FWDP25SS04C (ID 36)
(36, 4, 2, 18), (36, 4, 3, 15), (36, 4, 4, 12), (36, 6, 2, 15), (36, 6, 3, 12), (36, 6, 4, 10),
-- Quần Tây Nữ Basic FWDP24SS06C (ID 37)
(37, 4, 2, 30), (37, 4, 3, 25), (37, 4, 4, 20), (37, 5, 2, 25), (37, 5, 3, 20), (37, 5, 4, 15),
-- Quần Tây Nữ Form Baggy FWDP23FH02G (ID 38)
(38, 4, 2, 25), (38, 4, 3, 20), (38, 4, 4, 18), (38, 6, 2, 20), (38, 6, 3, 18), (38, 6, 4, 15),
-- Quần tây nữ form ống rộng FWDP23SS09C (ID 39)
(39, 5, 2, 20), (39, 5, 3, 18), (39, 5, 4, 15), (39, 9, 2, 18), (39, 9, 3, 15), (39, 9, 4, 12),
-- Quần tây nữ basic ống đứng FWDP22SS03L (ID 40)
(40, 4, 2, 25), (40, 4, 3, 20), (40, 4, 4, 18), (40, 6, 2, 20), (40, 6, 3, 18), (40, 6, 4, 15),

-- Thêm biến thể cho các sản phẩm phụ kiện (không có size)
-- Thắt lưng (ID 41-45) - chỉ có màu sắc
(41, 4, 1, 30), (41, 6, 1, 25),
(42, 4, 1, 25), (42, 6, 1, 20),
(43, 4, 1, 30), (43, 6, 1, 25),
(44, 4, 1, 20), (44, 6, 1, 15),
(45, 4, 1, 25), (45, 6, 1, 20),

-- Balo/Túi (ID 46-50) - chỉ có màu sắc
(46, 4, 1, 15), (46, 6, 1, 12),
(47, 4, 1, 18), (47, 6, 1, 15),
(48, 2, 1, 25), (48, 4, 1, 20),
(49, 2, 1, 20), (49, 4, 1, 18),
(50, 2, 1, 15), (50, 4, 1, 12),

-- Ví (ID 51-55) - chỉ có màu sắc
(51, 4, 1, 20), (51, 6, 1, 15),
(52, 4, 1, 18), (52, 6, 1, 12),
(53, 4, 1, 25), (53, 6, 1, 20),
(54, 4, 1, 20), (54, 6, 1, 15),
(55, 4, 1, 30), (55, 6, 1, 25),

-- Vớ (ID 56-60) - chỉ có màu sắc
(56, 4, 1, 50), (56, 5, 1, 45), (56, 6, 1, 40),
(57, 4, 1, 45), (57, 5, 1, 40), (57, 6, 1, 35),
(58, 4, 1, 50), (58, 5, 1, 45), (58, 6, 1, 40),
(59, 4, 1, 55), (59, 5, 1, 50), (59, 6, 1, 45),
(60, 4, 1, 40), (60, 5, 1, 35), (60, 6, 1, 30),

-- Kính (ID 61-64) - chỉ có màu sắc
(61, 4, 1, 20), (61, 10, 1, 15),
(62, 4, 1, 25), (62, 10, 1, 20),
(63, 4, 1, 30), (63, 10, 1, 25),
(64, 7, 1, 20), (64, 9, 1, 15),

-- Túi xách nữ (ID 65-66) - chỉ có màu sắc
(65, 4, 1, 15), (65, 9, 1, 12),
(66, 5, 1, 20), (66, 9, 1, 18);

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
  `login_day` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `phone`, `login_day`) VALUES
(0, 'Guest User', 'guest@system.com', '', 'user', '', '2025-11-28 18:41:36'),
(1, 'Admin User', 'admin@example.com', '123456', 'admin', '0123456789', '2025-11-26 00:00:00'),
(2, 'Test User', 'test@example.com', '123456', 'user', '0987654321', '2025-11-25 00:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `billdetail`
--
ALTER TABLE `billdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `cartdetail`
--
ALTER TABLE `cartdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `fk_products_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON UPDATE CASCADE;

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
