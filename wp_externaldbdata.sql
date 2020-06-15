-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Jún 15. 22:34
-- Kiszolgáló verziója: 10.4.11-MariaDB
-- PHP verzió: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `wordpress`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `wp_externaldbdata`
--

CREATE TABLE `wp_externaldbdata` (
  `id` mediumint(9) NOT NULL,
  `sql_type` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pw` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_column_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_stock_column_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `wp_externaldbdata`
--

INSERT INTO `wp_externaldbdata` (`id`, `sql_type`, `host`, `username`, `pw`, `db_name`, `table_name`, `product_column_name`, `product_stock_column_name`) VALUES
(1, 'mysql', 'localhost', 'root', '', 'producttest', 'products', 'product_sku', 'product_stock');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `wp_externaldbdata`
--
ALTER TABLE `wp_externaldbdata`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `wp_externaldbdata`
--
ALTER TABLE `wp_externaldbdata`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
