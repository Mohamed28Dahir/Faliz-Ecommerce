-- Database Export for faliz_db
-- Date: 2026-01-15 18:34:21

-- Table structure for table `orders`
CREATE TABLE `orders` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(6) unsigned DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `orders`
INSERT INTO `orders` VALUES
('1', '1', '125.00', 'Pending', '2026-01-15 15:04:07'),
('2', '1', '45.00', 'Completed', '2026-01-14 17:04:07'),
('3', '1', '210.50', 'Shipped', '2026-01-12 17:04:07'),
('4', '1', '85.00', 'Completed', '2026-01-15 17:04:07'),
('5', '2', '156.00', 'Shipped', '2026-01-15 19:38:20'),
('6', '2', '430.00', 'Pending', '2026-01-15 19:48:37'),
('7', '2', '90.00', 'Completed', '2026-01-15 19:57:16'),
('8', '2', '115.00', 'Cancelled', '2026-01-15 20:00:40');

-- Table structure for table `products`
CREATE TABLE `products` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `sizes` varchar(255) DEFAULT NULL,
  `colors` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sales_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `products`
INSERT INTO `products` VALUES
('1', 'Floral Summer Maxi', 'Dresses', '45.00', '65.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('2', 'Elegant Evening Gown', 'Dresses', '85.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('3', 'Boho Chic Midi', 'Dresses', '35.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('4', 'Classic Little Black Dress', 'Dresses', '55.00', '75.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1539008835279-43cf7efaa99d?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('5', 'Cocktail Party Mini', 'Dresses', '60.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('6', 'Linen Wrap Dress', 'Dresses', '38.00', '50.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('7', 'Velvet Occasion Gown', 'Dresses', '95.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1516762689617-e1cffcef479d?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('8', 'Sundress with Ruffles', 'Dresses', '32.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1544441893-675973e31985?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('9', 'Formal Silk Gown', 'Dresses', '100.00', '130.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('10', 'Vintage Polka Dot', 'Dresses', '42.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1582533561751-ef6f6ab93a2e?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('11', 'Sequin Party Dress', 'Dresses', '75.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1516762689617-e1cffcef479d?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('12', 'Bohemian Lace Dress', 'Dresses', '50.00', '68.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('13', 'Modern Slip Dress', 'Dresses', '30.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1549060279-7e168fcee0c2?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('14', 'A-Line Winter Dress', 'Dresses', '58.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('15', 'Casual Cotton Tunic', 'Dresses', '25.00', '35.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1554412930-c74f63ca526b?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('16', 'Leather Stiletto Heels', 'Shoes', '65.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('17', 'Classic White Sneakers', 'Shoes', '45.00', '60.00', '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('18', 'Ankle Strap Sandals', 'Shoes', '35.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('19', 'Suede Chelsea Boots', 'Shoes', '75.00', '95.00', '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1549416878-b9ca95e26903?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('20', 'Platform Espadrilles', 'Shoes', '45.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1535043934128-cf0b28d52f95?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('21', 'Elegant Ballet Flats', 'Shoes', '30.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('22', 'Velvet Party Pumps', 'Shoes', '65.00', '85.00', '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1549416878-b9ca95e26903?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('23', 'Hiking Active Boots', 'Shoes', '85.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('24', 'Mule Slip-ons', 'Shoes', '40.00', '55.00', '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('25', 'Gladiator High Sandals', 'Shoes', '60.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('26', 'Lace-up Oxford Shoes', 'Shoes', '55.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('27', 'Leopard Print Loafers', 'Shoes', '48.00', '65.00', '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('28', 'Thigh High Boots', 'Shoes', '95.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('29', 'Transparent Neon Heels', 'Shoes', '70.00', NULL, '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515347648462-8e51bb9ec65a?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('30', 'Running Performance Tech', 'Shoes', '80.00', '99.00', '37,38,39,40,41', 'Black,White,Beige', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('31', 'Minimalist Leather Tote', 'Bags', '65.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1584917033904-47b08753f173?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('32', 'Designer Crossbody Bag', 'Bags', '75.00', '95.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('33', 'Vintage Clasp Purse', 'Bags', '35.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('34', 'Round Bamboo Handbag', 'Bags', '45.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1588095241132-bb0b5fd65b36?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('35', 'Neon Party Clutch', 'Bags', '30.00', '45.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1566150905458-1bf1fd113961?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('36', 'Work Professional Briefcase', 'Bags', '90.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1544816153-12ad5d7132a1?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('37', 'Drawstring Bucket Bag', 'Bags', '50.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1605733513597-a8f8d410fe3c?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('38', 'Quilted Chain Strap', 'Bags', '85.00', '100.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1594223274512-ad4803739b7c?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('39', 'Straw Beach Bag', 'Bags', '25.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1588095241132-bb0b5fd65b36?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('40', 'Leather Laptop Sleeve', 'Bags', '40.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1584917033904-47b08753f173?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('41', 'Satchel Everyday Bag', 'Bags', '60.00', '80.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('42', 'Velvet Evening Mini', 'Bags', '45.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('43', 'Sporty Waist Pack', 'Bags', '20.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('44', 'Travel Weekend Duffle', 'Bags', '95.00', '120.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1544816153-12ad5d7132a1?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('45', 'Snake Print Clutch', 'Bags', '55.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1566150905458-1bf1fd113961?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('46', 'Silk Patterned Scarf', 'Accessories', '22.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('47', 'Oversized Sunglasses', 'Accessories', '35.00', '50.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1511499767323-ad89d14620f4?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('48', 'Leather Skinny Belt', 'Accessories', '18.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1624222247344-550fbadfd946?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('49', 'Wool Beret Hat', 'Accessories', '25.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('50', 'Knitted Winter Gloves', 'Accessories', '15.00', '22.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('51', 'Velvet Hair Scrunchie', 'Accessories', '8.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1624222247344-550fbadfd946?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('53', 'Rimless Fashion Specs', 'Accessories', '45.00', '60.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1511499767323-ad89d14620f4?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('61', 'Gold Pendant Necklace', 'Jewelry', '35.00', '50.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('62', 'Diamond Stud Earrings', 'Jewelry', '95.00', '130.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1535633302723-997f858d4d5e?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('63', 'Silver Charm Bracelet', 'Jewelry', '40.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('64', 'Rose Gold Luxury Watch', 'Jewelry', '85.00', '110.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('65', 'Pearl Drop Earrings', 'Jewelry', '45.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('66', 'Minimal Hoop Earrings', 'Jewelry', '20.00', '30.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1535633302723-997f858d4d5e?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('67', 'Statement Cuff Bracelet', 'Jewelry', '55.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('68', 'Crystal Evening Set', 'Jewelry', '90.00', '120.00', 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1535633302723-997f858d4d5e?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('69', 'Antique Silver Ring', 'Jewelry', '30.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('70', 'Tennis Link Bracelet', 'Jewelry', '65.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'https://images.unsplash.com/photo-1535633302723-997f858d4d5e?q=80&w=400', NULL, '0', '2026-01-15 18:05:06'),
('77', 'E-commerce Platform Redesign', 'Jewelry', '86.00', NULL, 'XS,S,M,L,XL', 'Black,White,Beige', 'assets/uploads/1768492340_Database stock illustration_ Illustration of storage - 17024075.jpg', '', '0', '2026-01-15 18:52:20');

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `users`
INSERT INTO `users` VALUES
('1', 'Admin', 'admin@faliz.com', 'admin123', 'admin', '2026-01-15 18:05:06'),
('2', 'Mohamed Dahir Osman', 'mohameddahirosman26@gmail.com', 'Mohamed Dahir Osman', 'customer', '2026-01-15 19:10:49');

