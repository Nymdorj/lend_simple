-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2021 at 10:32 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.2.31-1+ubuntu19.10.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lend`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `userid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productid` int NOT NULL,
  `orderid` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `userid`, `quantity`, `size`, `color`, `material`, `productid`, `orderid`) VALUES
(4, 'IreBPdK1PspDgpRMxAWMTw==', '1', 'M', 'Black & Grey', 'Straight', 1, 30),
(5, 'IreBPdK1PspDgpRMxAWMTw==', '1', 'M', 'Grey', 'Wide', 2, 30),
(6, 'IreBPdK1PspDgpRMxAWMTw==', '2', 'S', 'Grey', 'Wide', 2, 31),
(7, 'IreBPdK1PspDgpRMxAWMTw==', '2', 'S', 'Black', 'Wool', 5, 32),
(8, 'IreBPdK1PspDgpRMxAWMTw==', '2', 'M', 'Blue', 'Slim', 4, 33),
(9, 'IreBPdK1PspDgpRMxAWMTw==', '3', 'S', 'Grey', 'Lorem', 8, 34),
(10, 'IreBPdK1PspDgpRMxAWMTw==', '2', 'M', 'Grey', 'Lorem', 8, 35);

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`id`, `name`, `description`, `imageid`) VALUES
(1, 'VOGUE STYLE', 'FOR MODERN WOMEN', 1),
(2, 'NEW COLLECTION', 'FOR YOUR BEAUTY AND FASHION', 2),
(3, 'FEEL THE LUXURY', 'SPECIAL COLLECTION', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `invoice_number`, `user_id`, `amount`, `status`) VALUES
(23, '689c2e37-f6e7-4dd8-9dea-b03e7401aac1', 'IreBPdK1PspDgpRMxAWMTw==', 1092, 'PENDING'),
(24, '190b1169-7050-4f08-a324-4b194b19b80c', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'PENDING'),
(25, '1c6f6dd3-3b85-4ab7-9bc5-2badf1821640', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'PENDING'),
(26, '89976f15-9d33-48fa-9635-035f8d370a9a', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'PENDING'),
(27, 'ca6be1fd-faf0-4435-9daa-25f177d3a287', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'PENDING'),
(28, 'aaabe02f-c8bb-4bc7-97e4-b4308834cff6', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'PENDING'),
(29, '28aa62b0-2553-47f3-88c5-64ab17cf0640', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'PENDING'),
(30, '69150633-c233-4905-8909-5c03333481f4', 'IreBPdK1PspDgpRMxAWMTw==', 432, 'STATUS_COMPLETE'),
(31, '4989a167-0649-4984-bfb7-cf313e7943ff', 'IreBPdK1PspDgpRMxAWMTw==', 399, 'PENDING'),
(32, '12dd9529-94ab-4061-aa4e-6f7738cb4b94', 'IreBPdK1PspDgpRMxAWMTw==', 285, 'STATUS_COMPLETE'),
(33, '670aac32-de9b-483a-83f2-1b6b971d225a', 'IreBPdK1PspDgpRMxAWMTw==', 285, 'PENDING'),
(34, 'e71bd79c-8543-4198-9bbc-6924def756eb', 'IreBPdK1PspDgpRMxAWMTw==', 205, 'PENDING'),
(35, '340a4186-9e9c-413d-94ba-20435a5a26cf', 'IreBPdK1PspDgpRMxAWMTw==', 145, 'STATUS_COMPLETE');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `description` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brandname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` int NOT NULL,
  `collectionid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `type`, `size`, `color`, `brandname`, `image`, `collectionid`) VALUES
(1, 'CONSECTETUR ADIPISICING', 220, 'Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas.', 'Slim,Straight,Slender,Wide', 'XS,S,M,L,XL', 'Black & Grey,Red,Green,Yellow,Orange', 'Brandname', 1, 1),
(2, 'DOLOREMAGNA ALIQUA', 187, 'Nullam rutrum nulla et nunc euismod, in eleifend est scelerisque. Nunc et vulputate magna, id ultrices nisl. Vestibulum id orci fringilla, hendrerit urna a, elementum sem. In nec semper arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam ultrices velit in est tempus, quis imperdiet enim tempor. Integer lobortis nibh sit amet rhoncus faucibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce suscipit eget urna nec scelerisque. Aenean varius neque non mauris porttitor consequat sit amet a lorem. Sed volutpat feugiat orci ut rutrum. Ut convallis quis lacus vitae ultricies. Mauris id augue vitae ligula tristique iaculis. Suspendisse luctus felis in metus aliquam, sit amet congue massa mollis. Donec bibendum ligula semper mi elementum, at ultrices ligula auctor.', 'Wide,Slim', 'S,M,L', 'Black,Grey', 'DOLOR SIT', 2, 1),
(3, 'Dolor in reprehenderit', 380, 'Aliquam ut gravida ipsum. Nulla et porta sapien. Aenean sed quam quis odio elementum venenatis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent hendrerit urna vel ligula commodo, sit amet sodales tellus iaculis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc posuere enim nisl, non convallis eros pulvinar eget. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam maximus efficitur nunc sit amet suscipit. Sed id justo lacus. Praesent mattis facilisis tristique. Donec tempus diam a nulla efficitur sodales.', 'Straight,Big,Wide', 'XL,L,S', 'White,Black&Red,Red,Black', 'Duis aute irure', 3, 1),
(4, 'Nemo enim ipsam', 130, 'Nulla facilisi. Donec non nulla sed ligula fermentum convallis. Donec vehicula quam scelerisque, sollicitudin lorem auctor, egestas eros. Nulla ultrices urna orci, vitae semper ante cursus at. Aenean sit amet odio fermentum, blandit libero ut, semper lacus. Duis efficitur sit amet nisi vel consequat. Curabitur scelerisque eros lorem, ac blandit urna imperdiet sed. Donec accumsan, diam ac convallis viverra, enim tellus auctor purus, id pretium sapien augue a lectus.', 'Slender,Slim', 'XS,S,M', 'Red,Blue,Light', 'Enim ad minim', 4, 1),
(5, 'Nemo enim ipsam', 130, 'Proin aliquet ipsum sed ipsum convallis tincidunt. Morbi tristique ex in imperdiet dignissim. Aenean congue suscipit risus ac imperdiet. Donec tempor sollicitudin quam, eu maximus sem ultrices sit amet. Proin tempus egestas nulla, quis posuere nulla. Pellentesque euismod sollicitudin rhoncus. Donec laoreet nec sem at eleifend. Etiam magna ligula, dapibus vitae volutpat a, ornare quis ex. Quisque volutpat scelerisque dapibus.', 'Silk,Warm,Wool', 'XL,S,L', 'Red,Black,Green', 'Enim ad minim', 5, 2),
(6, 'Enim ad minim', 110, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sed suscipit sapien, vitae fermentum lectus. Nam eget faucibus ipsum. Ut at tristique est, et dignissim felis. Donec felis lectus, lobortis a leo vitae, aliquet tincidunt purus. Suspendisse convallis accumsan felis, sed semper turpis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer cursus, felis non gravida suscipit, odio eros tempor lectus, in lacinia ligula lectus sed mi. Sed bibendum ipsum id elit pellentesque imperdiet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', 'Wool,Wide', 'S,XS,M', 'Red', 'Nemo enim ipsam', 6, 2),
(7, 'Etiam sem mauris', 140, 'Praesent et scelerisque nibh. Cras ornare sapien hendrerit, porta ex ac, sagittis turpis. Vivamus in lectus sem. Quisque congue porta leo sit amet ornare. Donec est magna, vulputate id aliquet in, eleifend vel ipsum. Praesent lobortis iaculis arcu, vel volutpat enim feugiat nec. Ut tortor massa, convallis in rhoncus imperdiet, dictum ut massa. Aenean quis magna ac mauris iaculis bibendum at a elit. Mauris bibendum tincidunt lorem, quis porttitor velit faucibus et. Quisque in neque tellus. Pellentesque fermentum risus eget convallis varius. Sed suscipit malesuada pretium. Ut at porttitor purus.', 'Silk,Lorem,Wide', 'L', 'Black,Red', 'Vestibulum', 7, 3),
(8, 'Morbi tristique ex', 60, 'Sed sit amet tellus metus. Donec eu quam eu tortor varius varius eget in massa. Suspendisse faucibus laoreet ligula vitae sagittis. Donec sodales lacus in imperdiet imperdiet. Vestibulum a rhoncus mauris. Mauris elit quam, malesuada vitae iaculis sed, finibus aliquet magna. Proin ullamcorper sit amet mauris vitae dictum.', 'Silk,Lorem,Wide', 'S,M', 'Yellow,Grey', 'Vivamus', 8, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
