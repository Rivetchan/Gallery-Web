-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 08:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `AlbumID` int(11) NOT NULL,
  `NamaAlbum` varchar(255) NOT NULL,
  `Deskripsi` text DEFAULT NULL,
  `TanggalDibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`AlbumID`, `NamaAlbum`, `Deskripsi`, `TanggalDibuat`, `UserID`) VALUES
(1, 'SpiderMan', 'Multiverse of Spiderman', '2024-10-10 12:32:00', 2),
(2, '20th Century Boys', 'Manga', '2024-10-10 12:49:00', 2),
(3, 'Murder Drones', 'Murder Drones adalah sebuah seri animasi yang berlangsung di masa depan di mana drone yang dirancang untuk membunuh, dikenal sebagai \"Murder Drones,\" menjadi senjata yang menakutkan di tangan korporasi yang tidak bertanggung jawab.', '2024-10-14 23:14:00', 3),
(4, 'Cyber Security', '', '2024-10-14 23:55:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `FotoID` int(11) NOT NULL,
  `JudulFoto` varchar(255) NOT NULL,
  `Deskripsi` text DEFAULT NULL,
  `TanggalUnggah` timestamp NOT NULL DEFAULT current_timestamp(),
  `LokasiFile` varchar(255) NOT NULL,
  `AlbumID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`FotoID`, `JudulFoto`, `Deskripsi`, `TanggalUnggah`, `LokasiFile`, `AlbumID`, `UserID`) VALUES
(1, 'Peni Parker', 'My Waifu', '2024-10-10 15:14:00', 'Peni Parker.jpg', 1, 2),
(2, 'Friend', '20th Century Boys', '2024-10-10 18:45:00', '20 Century boys.jpg', 2, 2),
(3, 'Miles Morales', 'Main Character in SpiderVerse', '2024-10-13 10:04:00', 'Miles Morales.jpeg', 1, 2),
(4, 'Uzi', 'She is the rebellious daughter of Khan and Nori Doorman and initially sought to battle against Disassembly Drones,', '2024-10-14 23:19:00', 'Uzi.jpeg', 3, 3),
(5, 'V', 'V is a former Worker Drone, converted by Cyn into a Disassembly Drone and sent to Copper 9 to destroy runaway AI as Worker Drones.', '2024-10-14 23:44:00', 'v.jpeg', 3, 3),
(6, 'J', 'Serial Designation J-10X111001, best known as simply J, is a major antagonist in the 2021-2024 Glitch Productions web series Murder Drones.', '2024-10-14 23:46:00', 'J.jpeg', 3, 3),
(7, 'Endo Kenji', 'Kenji Endō is the main protagonist of the 20th Century Boys series. He is the uncle of Kanna Endō and the leader of a group comprising some of his former classmates aiming to put a stop to \"Friend\'s\"', '2024-10-14 23:50:00', 'Endo Kenji.jpeg', 2, 2),
(8, 'Malware', ' Malware dirancang untuk merusak, mengubah, atau mencuri data dari komputer atau jaringan', '2024-10-14 23:55:00', 'Malware.jpeg', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `komentarfoto`
--

CREATE TABLE `komentarfoto` (
  `KomentarID` int(11) NOT NULL,
  `FotoID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `IsiKomentar` text NOT NULL,
  `TanggalKomentar` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentarfoto`
--

INSERT INTO `komentarfoto` (`KomentarID`, `FotoID`, `UserID`, `IsiKomentar`, `TanggalKomentar`) VALUES
(11, 1, 2, 'Keren', '2024-10-15 09:15:22'),
(12, 2, 1, 'Wow manganya bagus banget', '2024-10-15 09:20:03'),
(13, 1, 1, 'wow', '2024-10-15 09:22:25'),
(14, 3, 1, 'Nice Miles Morales\r\n', '2024-10-15 09:23:14'),
(15, 3, 2, 'Nice Image', '2024-10-15 09:24:35'),
(16, 2, 2, '7/10', '2024-10-15 11:00:22'),
(17, 4, 3, 'Cantiknya amboi', '2024-10-15 13:34:27'),
(18, 2, 3, 'Keren Cool banget\r\n', '2024-10-15 13:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `likefoto`
--

CREATE TABLE `likefoto` (
  `LikeID` int(11) NOT NULL,
  `FotoID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TanggalLike` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likefoto`
--

INSERT INTO `likefoto` (`LikeID`, `FotoID`, `UserID`, `TanggalLike`) VALUES
(42, 1, 2, '2024-10-15 09:18:16'),
(43, 2, 1, '2024-10-15 09:20:10'),
(45, 3, 1, '2024-10-15 09:23:36'),
(46, 1, 1, '2024-10-15 09:37:23'),
(48, 2, 2, '2024-10-15 11:00:01'),
(49, 3, 2, '2024-10-15 11:00:05'),
(52, 4, 2, '2024-10-15 13:31:24'),
(53, 4, 3, '2024-10-15 13:34:20'),
(54, 3, 3, '2024-10-15 13:36:40'),
(55, 1, 3, '2024-10-15 13:36:41'),
(56, 2, 3, '2024-10-15 13:36:45'),
(57, 5, 3, '2024-10-15 13:44:35'),
(58, 6, 3, '2024-10-15 13:47:33'),
(59, 7, 2, '2024-10-15 13:50:56'),
(60, 6, 2, '2024-10-15 13:53:01'),
(61, 5, 2, '2024-10-15 13:53:02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `NamaLengkap` varchar(225) NOT NULL,
  `Alamat` varchar(225) NOT NULL,
  `Level` int(11) DEFAULT 2,
  `FotoUser` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Email`, `Password`, `NamaLengkap`, `Alamat`, `Level`, `FotoUser`) VALUES
(1, 'Rivet', 'tevirchan@gmail.com', 'Drags421', 'Enno Nurwansyah Rasyidi', 'Perum Griya KPN Blok I8 No 18', 1, 'Peni Parker.jpg'),
(2, 'Enno', 'ennonurwansyahr@gmail.com', 'Drags421', 'RivetChan', 'Perum Griya KPN Blok I8 No 18', 2, 'Miles Morales.jpeg'),
(3, 'Kaneki', 'kanekitouru2@gmail.com', '123', 'Kaneki Touru', 'Perum Griya KPN Blok I8 No 18', 2, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD UNIQUE KEY `AlbumID` (`AlbumID`) USING BTREE,
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`FotoID`),
  ADD KEY `AlbumID` (`AlbumID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD PRIMARY KEY (`KomentarID`),
  ADD KEY `komentar_fotoid` (`FotoID`),
  ADD KEY `komentar_userid` (`UserID`);

--
-- Indexes for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD PRIMARY KEY (`LikeID`),
  ADD KEY `like_fotoid` (`FotoID`),
  ADD KEY `like_userid` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `AlbumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `FotoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  MODIFY `KomentarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `LikeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`AlbumID`) REFERENCES `album` (`AlbumID`) ON DELETE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentar_fotoid` FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentar_userid` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD CONSTRAINT `like_fotoid` FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`) ON DELETE CASCADE,
  ADD CONSTRAINT `like_userid` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
