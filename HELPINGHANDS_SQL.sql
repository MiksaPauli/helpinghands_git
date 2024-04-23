-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2024 at 11:24 PM
-- Server version: 10.6.16-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team05`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `adminName` varchar(100) NOT NULL,
  `adminPass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminName`, `adminPass`) VALUES
(1, 'Admin123', '$2y$10$miI8p2QEZKeoai9qcBKBh.Er8TytcLT5YkZjqeiUhqkl5KHoHPjyK');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` varchar(100) NOT NULL,
  `commentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postid`, `userid`, `text`, `commentid`) VALUES
(1, 9, 24, 'kill it ohh kill it', 0),
(19, 9, 24, 'hell yeah he killin it', 1),
(20, 9, 24, 'nuh uh', 1),
(21, 9, 24, 'WOOOOW *claps intensivly*', 0),
(22, 9, 24, 'asas', 0),
(23, 9, 24, 'nuh uh', 1),
(24, 9, 24, 'hell yeah he killin it', 21);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `text` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `email`, `text`) VALUES
(1, 'miksa.pauli2223@gmail.com', 'Problémám akadt a bejelentkezéssel'),
(28, 'valami@gmail.com', 'Haha');

-- --------------------------------------------------------

--
-- Table structure for table `passReset`
--

CREATE TABLE `passReset` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verification_code` varchar(11) NOT NULL,
  `req_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `category` int(11) NOT NULL,
  `mainPic` varchar(1000) NOT NULL,
  `secondPic` varchar(1000) NOT NULL,
  `thirdPic` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL,
  `reports` int(11) NOT NULL,
  `uploadDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userid`, `title`, `location`, `text`, `category`, `mainPic`, `secondPic`, `thirdPic`, `status`, `reports`, `uploadDate`) VALUES
(2, 10, 'Ez egy másik', 'Kamcsatka', 'Fáj a lábam SEND HELP', 3, '', '', '', 0, 0, '2024-03-25'),
(3, 16, 'Monke needs help', 'Budapest', 'Kéne kis segitség a majmom öntudatra kellt', 1, '', '', '', 0, 0, '2024-03-25'),
(4, 16, 'Ez egy teszt a sok között', 'Mimó', 'Kéne egy kis mentális segítség ez az 1000 sor php ba belehalok', 1, '', '', '', 0, 0, '2024-03-25'),
(5, 16, 'Bedugult az orrom', 'Otthon', 'Valaki segitsen máma kifujni az orrom elore is koszi báttya', 1, '', '', '', 0, 0, '2024-03-25'),
(6, 16, 'Elado occso gamer szmitogep', 'Ózd', 'Elado gamer szmitogep. Nagon eross intel 10 100gb vidi. Minden jatek fut rajta fut rajta a windows', 3, '', '', '', 0, 0, '2024-03-25'),
(7, 16, 'Batyó matyo', 'Kiskunfélegyháza', 'HihihihiHAA', 1, '', '', '', 0, 0, '2024-03-25'),
(8, 18, 'Mitymuty', 'Bivajlmao', 'Itt ahol lakom nincs semmi kéne valami', 0, '', '', '', 0, 0, '2024-03-25'),
(9, 23, 'Tesztxddd', 'valahol', 'minedn itt minden ottt', 1, '', '', '', 0, 0, '2024-03-25'),
(10, 24, 'assa', 's1s', 'qqqqq', 2, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(11, 24, 'asasasa', 'ssss', 'ssss', 3, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(12, 24, 'asasas', 'sasas', 'asas', 1, '', '', '', 0, 0, '2024-03-25'),
(13, 24, 'bbb', 'brbrrb', 'brbb', 1, 'f3f2f5832845c527dbba095120fd9684c41c23faaeda5d18.avif', 'wallpapersden.com_anime-landscape-hd-cloudy-forest-evening_1952x1120.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(14, 24, 'bbb', 'brbrrb', 'brbb', 1, 'f3f2f5832845c527dbba095120fd9684c41c23faaeda5d18.avif', 'wallpapersden.com_anime-landscape-hd-cloudy-forest-evening_1952x1120.jpg', '', 0, 0, '2024-03-25'),
(15, 24, 'bbb', 'brbrrb', 'brbb', 1, 'f3f2f5832845c527dbba095120fd9684c41c23faaeda5d18.avif', 'wallpapersden.com_anime-landscape-hd-cloudy-forest-evening_1952x1120.jpg', '', 0, 0, '2024-03-25'),
(16, 24, 'bbb', 'sasss', 'aqqqq', 2, 'f3f2f5832845c527dbba095120fd9684c41c23faaeda5d18.avif', 'wallpapersden.com_anime-landscape-hd-cloudy-forest-evening_1952x1120.jpg', '', 0, 0, '2024-03-25'),
(18, 24, 'puki', 'as', 'kak', 4, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(19, 24, 'asaaaa', 'aaaaaaa', 'aaaa', 4, 'f3f2f5832845c527dbba095120fd9684c41c23faaeda5d18.avif', 'HH_logo5 másolata.png', 'wallpapersden.com_anime-landscape-hd-cloudy-forest-evening_1952x1120.jpg', 0, 0, '2024-03-25'),
(20, 24, 'asaaaa', 'aaaaaaa', 'aaaa', 4, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(23, 24, 'aa', 'aa', 'aa', 3, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(24, 24, '', '', '', 0, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(25, 24, 'as', 'ss', 'asas', 4, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(26, 24, 'asas', 'ssss', 'sasa', 1, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(27, 24, 'eeeee', 'eee', 'eee', 3, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(28, 24, 'eee', 'eeee', 'eeeeeeeeeeee', 5, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(29, 24, 'ffff', 'ffff', 'ffff', 4, 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, '2024-03-25'),
(30, 24, 'ffff', 'ffff', 'fff', 5, 'default.jpg', 'default.jpg', 'default.jpg', 2, 0, '2024-03-25'),
(31, 24, 'frfrfr', 'frfrfrf', 'frfrfr', 3, 'default.jpg', 'default.jpg', 'default.jpg', 1, 0, '2024-03-25'),
(51, 29, 'Bútorszerelés', 'Budapest', 'Nemrég vásárolt bútor összeszerelésében szeretnék segítséget kérni', 3, 'butor1.jpg', 'butor2.png', 'butor3.png', 0, 1, '2024-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `userid`, `postid`) VALUES
(10, 24, 39),
(11, 24, 38),
(12, 29, 51);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `vezeteknev` varchar(100) NOT NULL,
  `keresztnev` varchar(100) NOT NULL,
  `felhasznalonev` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `prof_img` varchar(100) NOT NULL,
  `registDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `vezeteknev`, `keresztnev`, `felhasznalonev`, `email`, `password`, `prof_img`, `registDate`) VALUES
(1, 'Páricsi', 'Szabolcs', '', 'kukac@gmail.com', 'Asd', '', '2024-04-01'),
(2, 'Páricsi', 'Szabolcs', '', 'kukac1@gmail.com', 'asd', '', '2024-04-01'),
(8, 'Mikó', 'Pikó', '', 'nincsilyen@gmail.hu', 'Nincs01', '', '2024-04-01'),
(9, 'kiki', 'koko', '', 'k@gmail.com', 'Mikso', '', '2024-04-01'),
(10, 'jojo', 'hoho', '', 'h@gmail.com', 'Hoho', '', '2024-04-01'),
(11, 'lolo', 'momo', '', 'm@gmail.com', 'Mimi', '', '2024-04-01'),
(16, 'Proba', 'Valami', '', 'ProbaValami@gmail.com', 'Valami123', 'face.jpg', '2024-04-01'),
(18, 'Miksa', 'Pauli', 'LordOfHands', 'miksa.pauli2223@gmail.com', '$2y$10$Z3GLWwPx9tdZPSno/M.jBOpvJRAnnWR8i4UM8t/majrZBU2ykWele', 'default.jpg', '2024-04-01'),
(19, 'Szabi', 'Habi', 'LóbabosNéni', 'babos@gmail.com', 'babos', 'default.jpg', '2024-04-01'),
(23, 'Miksa', 'Pauli', 'SajtosBab', 'nemtom6921@gmail.com', '$2y$10$0yaGPSHFnuLYcfB6Ilaloev497LPWnMfz/.Fos6ns0kPAwcWW5/Wm', 'default.jpg', '2024-04-01'),
(24, 'Miksa', 'Pauli', 'Huhu', 'mek@gmail.com', '$2y$10$Ixhk/lwqORuWug5mDADvB.UzV7B.lxKma1NhDra5qPAQA9XNNt7u6', '122615-Ninja-minimalism-samurai-Japan-Japanese-Art-Animal-Collective-Kitty-Kitten-by-name-Woof.png', '2024-04-01'),
(29, 'Páricsi', 'Szabolcs', 'paricsi_szabolcs', 'paricsisz@gmail.com', '$2y$10$1WwNUtwrUn9xnxPNXTJ.E.pXSCg/f6Bkmlo.3/tFW8wRV4l8unz4W', 'default.jpg', '2024-04-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passReset`
--
ALTER TABLE `passReset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `passReset`
--
ALTER TABLE `passReset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
