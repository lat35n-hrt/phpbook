-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2025 年 1 月 05 日 11:50
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sample_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `price` int(6) NOT NULL,
  `publish` date NOT NULL,
  `author` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `books`
--

INSERT INTO `books` (`id`, `title`, `isbn`, `price`, `publish`, `author`) VALUES
(1, 'PHPの本', '9994295001249', 980, '2024-09-01', '佐藤'),
(2, 'XAMPPの本', '9994295001250', 1980, '2024-05-29', '鈴木'),
(3, 'MdNの本', '9994295001251', 580, '2024-04-30', '高橋'),
(4, '2024年の本', '9994295001251', 10000, '2024-01-01', '田中'),
(5, 'データベースの本', '1234567890123', 2200, '2024-12-02', '田中'),
(6, 'データベースの本第二版', '1122334455667', 2600, '2024-05-18', '伊藤'),
(7, 'Java Fundamentals', '8888888888', 3300, '2024-04-01', 'James Gosling'),
(8, 'PHP Fundamentals', '99999999', 1200, '2024-05-01', 'Joe Satriani'),
(9, 'SQL Basic', '1234567890123', 1000, '2024-04-13', 'Donald Fagen'),
(10, 'Go Fundamental', '1234567', 2200, '2024-05-05', 'Ryan Fan'),
(12, 'CSRF Test', '1234567', 1004, '2024-04-01', 'CSRF Test');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'mdnuser', '$2y$10$fSGntNMNWw1FNSHJCEFgYOjFQxn.HH5xRS5U5SEKk7HDTkQFiyIQK'),
(3, 'test', '$2y$10$40Y3Iz6a01LfkYHOVShu5.Kd/GRlbU7r2cyl3Zbf.DhemaepHEdQu'),
(4, 'test1', '$2y$10$7.3v3ssuGz6TQVrPIX5zu.AlkQAd4tBuO.YdOYWlKFw/P.5zXu6eO');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
