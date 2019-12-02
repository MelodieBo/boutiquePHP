-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 02, 2019 at 01:23 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `montant` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(3) NOT NULL,
  `id_commande` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `quantite` int(3) NOT NULL,
  `prix` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `code_postal` int(5) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(5, 'admin', '$2y$10$kY2Fify/dDpf2XqgZ5qvZ.tbVysje3m8FaN7lGsJuISrie0SRK1v6', 'dupont', 'john', 'john.dupont@gmail.com', 'm', 'paris', 75018, 'Rue montmartre', 1),
(6, 'John', '$2y$10$sR86zOpbboYLrowTHZUsI.t1fvoY5zfvc5zALzJL2iX6/54S.ROEe', 'Doe', 'John', 'johndoe@gmail.com', 'm', 'Paris', 75009, 'Rue victor hugo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(3) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(20) NOT NULL,
  `taille` varchar(5) NOT NULL,
  `public` enum('m','f','mixte') NOT NULL,
  `photo` varchar(250) NOT NULL,
  `prix` int(3) NOT NULL,
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(11, '4', 'enfant', 'Doudoune sans manche', 'Proin egestas pharetra odio at auctor. Praesent ac diam non nibh vehicula fermentum. Integer dictum imperdiet sapien, ac scelerisque ex pulvinar quis. Donec in lorem ante. Suspendisse potenti. Etiam id pharetra tortor. Phasellus sit amet dolor odio. ', 'bleu', 'S', 'mixte', 'photo/ref_4_kid-1241817_1280.jpg', 30, 1),
(12, '5', 'robe', 'Robe patineuse', 'Nullam facilisis dui augue, id sollicitudin ligula tincidunt eu. Cras et urna ultricies, maximus lectus nec, tincidunt massa. Aliquam sed lectus eu mauris pretium gravida ac eget enim. Phasellus faucibus massa non viverra condimentum. Morbi ullamcorper, diam sed aliquam mollis, elit justo feugiat metus, in mattis massa sapien sit amet nibh. Donec vel lacus at purus convallis gravida malesuada non libero. Ut eget dolor id nisi condimentum sagittis.', 'orange', 'M', 'f', 'photo/ref_5_dress-864107_1280.jpg', 65, 2),
(13, '6', 'maille', 'Gilet grosse maille', 'Integer sit amet molestie urna. Sed ante dui, facilisis et lacus a, feugiat vestibulum velit. Vestibulum et metus hendrerit, convallis turpis ac, condimentum arcu. Suspendisse dignissim ut dui non ullamcorper.', 'gris', 'L', 'f', 'photo/ref_6_beautiful-1867093_1280.jpg', 60, 3),
(15, '7', 'chaussure', 'Converse All Star', 'Integer sit amet molestie urna. Sed ante dui, facilisis et lacus a, feugiat vestibulum velit. Vestibulum et metus hendrerit, convallis turpis ac, condimentum arcu. Suspendisse dignissim ut dui non ullamcorper.', 'blanc', 'XL', 'mixte', 'photo/ref_7_legs-434918_1280.jpg', 75, 4),
(16, '1', 'pantalon', 'Jean Boyfriend', 'Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut frugi parens et prudens et dives Caesaribus tamquam liberis suis regenda patrimonii iura permisit.', 'bleu', 'S', 'f', 'photo/ref_1_ref_1_girl-983969_1280.jpg', 80, 1),
(17, '2', 'pantalon', 'Jean Slim', 'Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut frugi parens et prudens et dives Caesaribus tamquam liberis suis regenda patrimonii iura permisit.', 'noir', 'M', 'f', 'photo/ref_2_ref_2_ref_2_standing-336554_1280.jpg', 80, 2),
(18, '3', 'enfant', 'Chemise ', 'Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut frugi parens et prudens et dives Caesaribus tamquam liberis suis regenda patrimonii iura permisit.', 'bleu', 'S', 'mixte', 'photo/ref_3_ref_3_child-817373_1280.jpg', 15, 3),
(19, '8', 'pantalon', 'Chino 3/4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut velit id urna feugiat sollicitudin ut sed justo. Suspendisse iaculis maximus ligula. ', 'noir', 'L', 'm', 'photo/ref_8_white-926838_1280.jpg', 50, 6),
(20, '9', 'pantalon', 'Jeans Brut', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut velit id urna feugiat sollicitudin ut sed justo. Suspendisse iaculis maximus ligula. ', 'bleu', 'XL', 'm', 'photo/ref_9_bag-1868758_1280.jpg', 75, 6),
(21, '10', 'pantalon', 'Jeans 501 Levi\'s', 'Donec nisl elit, dapibus ut mollis non, dignissim sit amet mi. Quisque dolor orci, molestie vitae vulputate a, viverra sed augue. Proin ante enim, egestas non iaculis eget, tempus ut sem. Mauris fringilla dignissim accumsan. Aenean nec lacinia felis. Nam molestie iaculis nisl eu ullamcorper.', 'bleu', 'M', 'mixte', 'photo/ref_10_bonding-1985863_1280.jpg', 75, 500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Indexes for table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
