-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2022 at 01:08 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auto_part_db`
--

-- --------------------------------------------------------


--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom_ar`, `nom_fr`, `created_at`, `updated_at`) VALUES
(1, 'بياس موتور أي ويل', 'Pièces moteur et Huile', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(2, 'فيزيبيليتي', 'Visibilité', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(3, 'ديتكسيو/سيسبونسيو /تران', 'Direction / Suspension / Train', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(4, 'فريناج', 'Freinage', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(5, 'فيلتراسيون', 'Filtration', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(6, 'ديماراج و شارج', 'Démarrage et Charge', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(7, 'اومبرياج و بوات دو فيتاس', 'Embrayage et Boîte de vitesse', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(8, 'ايشابمو', 'Echappement', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(9, 'بياس ترميك و كليماتيزاسيو', 'Pièces Thermiques et Climatisation', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(10, 'اكسيسوار و ايكيبمو', 'Accessoires et Equipements', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(11, 'بياس ابيتاكل', 'Pièces Habitacle', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(12, 'بنو و ايكيبمو رو', 'Pneus et Equipements Roue', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(13, 'اونتروتيان و نيتوياج', 'Entretien et Nettoyage', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(14, 'اتلاج و بورتاج', 'Attelage et Portage', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(15, 'كاروسري و بانتور', 'Carrosserie et peinture', '2022-04-01 17:49:16', '2022-04-01 17:49:16'),
(16, 'اوتياج', 'Outillage', '2022-04-01 17:49:16', '2022-04-01 17:49:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--

-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
