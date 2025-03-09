-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 02:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cherifauto`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrateurs`
--

INSERT INTO `administrateurs` (`id_admin`, `nom`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin00');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `date_naissance` varchar(16) NOT NULL,
  `adresse` varchar(64) NOT NULL,
  `num_permis` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `email`, `password`, `date_naissance`, `adresse`, `num_permis`) VALUES
(1, 'Bakhoum', 'Cherif', 'cherifbakhoum@gmail.com', '$2y$10$BHpiZU5gWLhUKd06/qG98uk4kpsiMFnYBbfC.QwIXT/SQcGZWhUUW', '2025-02-06', '153 Rue De La Republique', 'GDHGHGH667');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `date_envoie` varchar(16) NOT NULL,
  `message` varchar(500) NOT NULL,
  `nom` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id_message`, `email`, `date_envoie`, `message`, `nom`) VALUES
(16, 'bakhoumcherif06@gmail.com', '2025-03-07', 'tu as fait un excellent travail', 'Bakhoum'),
(17, 'aida@gmail.com', '2025-03-09', 'Nous offrons une large sélection de véhicules récents et confortables, des citadines aux voitures de luxe. Nos formules flexibles permettent une location à la journée, à la semaine ou au mois, avec des tarifs attractifs et un service client dédié.', 'Aida');

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE `paiements` (
  `id_paiement` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `montant` varchar(32) NOT NULL,
  `date_paiement` varchar(16) NOT NULL,
  `mode_paiement` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paiements`
--

INSERT INTO `paiements` (`id_paiement`, `id_reservation`, `montant`, `date_paiement`, `mode_paiement`) VALUES
(14, 9, '200000', '2025-03-07', 'Par espéce'),
(16, 13, '1125000', '2025-03-07', 'Par cheque'),
(17, 12, '420000', '2025-03-07', 'Par carte');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL,
  `date_debut` varchar(16) NOT NULL,
  `date_fin` varchar(16) NOT NULL,
  `statut_reservation` varchar(16) NOT NULL,
  `montant` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_client`, `id_voiture`, `date_debut`, `date_fin`, `statut_reservation`, `montant`) VALUES
(9, 1, 3, '2025-03-07', '2025-03-09', 'Confirmée', '200000'),
(10, 1, 1, '2025-03-08', '2025-03-14', 'Confirmée', '1200000'),
(11, 1, 2, '2025-03-07', '2025-03-09', 'Confirmée', '300000'),
(12, 1, 5, '2025-03-07', '2025-03-14', 'Confirmée', '420000'),
(13, 1, 6, '2025-03-11', '2025-03-20', 'Confirmée', '1125000'),
(14, 1, 8, '2025-03-08', '2025-03-09', 'Refusée', '75000');

-- --------------------------------------------------------

--
-- Table structure for table `voitures`
--

CREATE TABLE `voitures` (
  `id_voiture` int(11) NOT NULL,
  `marque` varchar(32) NOT NULL,
  `modele` varchar(32) NOT NULL,
  `annee_fabrication` varchar(16) NOT NULL,
  `plaque` varchar(16) NOT NULL,
  `statut` varchar(32) NOT NULL,
  `prix` varchar(32) NOT NULL,
  `chemin_image` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voitures`
--

INSERT INTO `voitures` (`id_voiture`, `marque`, `modele`, `annee_fabrication`, `plaque`, `statut`, `prix`, `chemin_image`) VALUES
(1, 'tesla', 'cybertruck', '2024', 'DK-564-SN', 'Louée', '200000', 'img/cyber.png'),
(2, 'Tesla', 'model S plaid', '2022', 'DK-545-SN', 'Louée', '150000', 'img/tesla1-removebg-preview.png'),
(3, 'Mercedes', 'GLE', '2020', 'JD-565-HJ', 'Louée', '100000', 'img/suv1-removebg-preview.png'),
(5, 'Range Rover', 'evoque', '2016', 'GH-875-UI', 'Louée', '60000', 'img/defaultcar.png'),
(6, 'BMW', 'X5', '2021', 'AZ-567-RN', 'Louée', '125000', 'img/defaultcar.png'),
(7, 'KIA', 'Sportage', '2022', 'RN-457-UL', 'Disponible', '80000', 'img/defaultcar.png'),
(8, 'Toyota', 'RAV4', '2021', 'BK-089-AZ', 'Disponible', '75000', 'img/defaultcar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Indexes for table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id_paiement`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`);

--
-- Indexes for table `voitures`
--
ALTER TABLE `voitures`
  ADD PRIMARY KEY (`id_voiture`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `voitures`
--
ALTER TABLE `voitures`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
