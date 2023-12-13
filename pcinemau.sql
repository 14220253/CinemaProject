-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 04:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcinemau`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_data`
--

CREATE TABLE `admin_data` (
  `NIP` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kontak` varchar(15) NOT NULL,
  `fk_location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `address`, `phone_number`, `username`, `password`) VALUES
(78, 'marvel wilbert odelio', 'raya wiguna tengah no 5', '+6285735605326', 'marvel', '$2y$10$KFkuCYWnJKYyKBDaDJ6y2uNUImYKB7Zzhsac6XI240XlwTL6Baby.'),
(79, 'marvel wilbert odelio', 'raya wiguna tengah no 5', '+6285735605326', 'm4rv3l24', '$2y$10$7nOwcdBYWn1RBWclVHEMsug0zOpXJ15PlSnpM.UgmpGd0q.FrzuTa');

-- --------------------------------------------------------

--
-- Table structure for table `data_theatre`
--

CREATE TABLE `data_theatre` (
  `theatre_id` int(11) NOT NULL,
  `fk_location_id` int(11) NOT NULL,
  `theatre_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penayangan`
--

CREATE TABLE `detail_penayangan` (
  `detail_penayangan_id` int(11) NOT NULL,
  `fk_movie_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `fk_schedule_hours_id` int(11) NOT NULL,
  `fk_theatre_id` int(11) NOT NULL,
  `harga_tiket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diagran_kursi`
--

CREATE TABLE `diagran_kursi` (
  `diagram_kursi_id` int(11) NOT NULL,
  `fk_theatre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `food_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_transaction`
--

CREATE TABLE `food_transaction` (
  `food_transaction_id` int(11) NOT NULL,
  `fk_customer_id` int(11) NOT NULL,
  `sum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_transaction_detail`
--

CREATE TABLE `food_transaction_detail` (
  `fk_food_id` int(11) NOT NULL,
  `fk_food_transaction_id` int(11) NOT NULL,
  `food_transc_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movie_id` int(11) NOT NULL,
  `movie_name` varchar(50) NOT NULL,
  `fk_supplier_id` int(11) NOT NULL,
  `movie_length` int(11) NOT NULL COMMENT 'in hour',
  `movie_details` varchar(500) NOT NULL COMMENT 'synopsis\r\ngenre\r\ncast\r\nhome production',
  `movie_image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movie_id`, `movie_name`, `fk_supplier_id`, `movie_length`, `movie_details`, `movie_image`) VALUES
(1, 'Shang Chi', 1, 132, 'Synopsis:\r\nShang-Chi and the Legend of the Ten Rings follows the journey of Shang-Chi, a skilled martial artist who is drawn into the clandestine Ten Rings organization. Trained since childhood by the mysterious Mandarin, Shang-Chi becomes a formidable force. However, as he delves deeper into the organization\'s secrets, he discovers a dark conspiracy that threatens the world. Forced to confront his past and the power of the Ten Rings, Shang-Chi must embrace his destiny and stand against the forc', ''),
(2, 'Doctor Strange', 1, 115, 'Synopsis:\r\n\"Doctor Strange\" follows the story of Dr. Stephen Strange, a brilliant but arrogant neurosurgeon whose life takes a dramatic turn after a car accident leaves him with severe nerve damage in his hands. Desperate to restore his medical career, Strange seeks out unconventional treatments and discovers the mystical arts. Under the guidance of the Ancient One, he learns to harness magical powers and becomes a sorcerer. As he delves into the world of mysticism, Strange must confront powerfu', ''),
(3, 'Spiderman: Far From Home', 1, 129, 'Synopsis:\r\n\"Spider-Man: Far From Home\" picks up after the events of \"Avengers: Endgame.\" Peter Parker, still mourning the loss of Tony Stark, decides to join his classmates on a European vacation. However, his plans for a peaceful trip are disrupted when Nick Fury recruits him to help investigate mysterious elemental creatures that are wreaking havoc across the continent. Teaming up with a new superhero, Mysterio, Peter faces new challenges and uncovers shocking truths about the nature of the th', ''),
(4, 'Frozen 2', 2, 103, 'Synopsis:\r\nIn \"Frozen II,\" Elsa, Anna, Kristoff, Olaf, and Sven embark on a new journey beyond their kingdom of Arendelle. The story explores the origins of Elsa\'s magical powers and the history of their family. Drawn to a mysterious enchanted forest, the group discovers ancient truths about their kingdom and the elemental spirits that inhabit the mystical land. Elsa must confront the past and uncover the secrets of her magical abilities to save her kingdom from a looming threat.\r\nGenre: Animati', ''),
(5, 'Wonka', 5, 116, 'Synopsis : \r\n\"Wonka will revolve around the beginning of Willy Wonka\'s (Timothee Chalamet) life before he becomes the owner of a mysterious and famous chocolate factory. The struggle of young people to make the best chocolate in the world and known by the wider community.\"\r\nGenre: Adventure, Family\r\nCast:\r\nTimothee Chalamet, Olivia Colman, Hugh Grant, Sally Hawkins, Keegan-michael Key, Rowan Atkinson, Mathew Baynton, Simon Farnaby, Matt Lucas\r\n', ''),
(6, 'wish', 2, 95, 'Synopsis:\r\n\"Wish will follow Asha, a 17-year-old young girl who has a pet goat named Valentino. One night Asha conveys her wishes to the stars. An unexpected thing happens when an adorable star approaches Asha and brings a miracle. Asha and Valentino embark on an adventure across the land of the Rosas kingdom to make their wishes come true. But fate brings him face to face with King Magnifico to fight for a better future.\"\r\nGenre: Animation, Adventure, Comedy\r\nCast:\r\nChris Pine, Evan Peters, Ala', ''),
(7, 'Trolls Band Together', 3, 91, 'Synopsis:\r\n\"Poppy (Anna Kendrick) learns that Branch (Justin Timberlake) was once part of a boy band, BroZone, alongside his brothers: Floyd (Troye Sivan), John Dory (Eric Andre), Spruce (Daveed Diggs), and Clay (Kid Cudi). But when Floyd is kidnapped, Branch and Poppy go on a journey to reunite the other brothers and rescue Floyd\"\r\nGenre: Animation\r\nCast:\r\nJustin Timberlake, Anna Kendrick, Zooey Deschanel, Daveed Diggs, Christopher Mintz-plasse, Andrew Rannells, Troye Sivan, Kunal Nayyar, Kevin', ''),
(8, 'The Marvels', 1, 105, 'Synopsis:\r\n\"Captain Marvel\'s (Brie Larson) powers are connected to Ms. Marvel (Iman Vellani) and Monica Rambeau (Teyonah Parris). This made the three constantly switch places. They finally meet and find out why their strengths are connected. With a new threat coming, the three decide to become a team to save the universe as The Marvels.\"\r\nGenre: Action, Adventure, Fantasy\r\nCast:\r\nBrie Larson, Samuel L. Jackson, Zawe Ashton, Teyonah Parris, Iman Vellani, Zenobia Shroff, Saagar Shaikh, Mohan Kapur', ''),
(9, 'The Hunger Games: The Ballad of Songbirds and Snak', 4, 157, 'Synopsis:\r\n\"Set 64 years before The Hunger Games in the land of Panem. Coriolanus Snow (Tom Blyth) is assigned to mentor Lucy (Rachel Zegler), a female participant from the 12th district in an annual 10th Hunger Games event. Realizing his student has a rebellious nature, Snow plots a secret and origin story as he becomes a ruthless panem leader.\"\r\nGenre: Action, Adventure\r\nCast:\r\nTom Blyth, Rachel Zegler, Hunter Schafer, Jason Schwartzman, Peter Dinklage, Kjell Brutscheidt, Viola Davis, Ayomide ', ''),
(10, 'Aquaman', 5, 143, 'Synopsis:\r\n\"Aquaman\" follows the story of Arthur Curry, the half-human, half-Atlantean heir to the underwater kingdom of Atlantis. Initially reluctant to embrace his destiny as the true ruler, Arthur is forced to step forward when his half-brother Orm seeks to unite the underwater kingdoms and declare war on the surface world. To prevent a catastrophic conflict, Arthur, with the help of Mera and other allies, must embark on a quest to find the legendary Trident of Atlan, facing various challenge', '');

-- --------------------------------------------------------

--
-- Table structure for table `movie_supplier`
--

CREATE TABLE `movie_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_supplier`
--

INSERT INTO `movie_supplier` (`supplier_id`, `supplier_name`) VALUES
(1, 'Marvel Studios'),
(2, 'Disney'),
(3, 'Universal Studio'),
(4, 'Lionsgate'),
(5, 'Warner Bros');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_hours`
--

CREATE TABLE `schedule_hours` (
  `schedule_hours_ID` int(11) NOT NULL,
  `fk_detail_penayangan` int(11) NOT NULL,
  `jam_penayangan` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `kursi_id` int(11) NOT NULL,
  `fk_diagram_kursi` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'sold or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `tiket_id` int(11) NOT NULL,
  `fk_customer_id` int(11) NOT NULL,
  `fk_schedule_hours_id` int(11) NOT NULL,
  `fk_kursi_id` int(11) NOT NULL,
  `price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_data`
--
ALTER TABLE `admin_data`
  ADD PRIMARY KEY (`NIP`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `data_theatre`
--
ALTER TABLE `data_theatre`
  ADD PRIMARY KEY (`theatre_id`);

--
-- Indexes for table `detail_penayangan`
--
ALTER TABLE `detail_penayangan`
  ADD PRIMARY KEY (`detail_penayangan_id`);

--
-- Indexes for table `diagran_kursi`
--
ALTER TABLE `diagran_kursi`
  ADD PRIMARY KEY (`diagram_kursi_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `food_transaction_detail`
--
ALTER TABLE `food_transaction_detail`
  ADD PRIMARY KEY (`food_transc_detail_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `schedule_hours`
--
ALTER TABLE `schedule_hours`
  ADD PRIMARY KEY (`schedule_hours_ID`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`kursi_id`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`tiket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_data`
--
ALTER TABLE `admin_data`
  MODIFY `NIP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `data_theatre`
--
ALTER TABLE `data_theatre`
  MODIFY `theatre_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_penayangan`
--
ALTER TABLE `detail_penayangan`
  MODIFY `detail_penayangan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagran_kursi`
--
ALTER TABLE `diagran_kursi`
  MODIFY `diagram_kursi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_transaction_detail`
--
ALTER TABLE `food_transaction_detail`
  MODIFY `food_transc_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule_hours`
--
ALTER TABLE `schedule_hours`
  MODIFY `schedule_hours_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `kursi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `tiket_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
