- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3309
-- Généré le : dim. 03 mars 2024 à 19:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chatsys`
--

-- --------------------------------------------------------

--
-- Structure de la table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(30) NOT NULL,
  `userId` int(225) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_img` text NOT NULL,
  `active_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_info`
--

INSERT INTO `user_info` (`id`, `userId`, `username`, `password`, `email`, `user_img`, `active_at`, `status`) VALUES
(4, 176583, 'selma', '$2y$10$VN1ktnr5aG35SRMrl6QgRegUz62H.vEZh/0obFCN0HHKo8G./E9gq', 'selma@gmail.com', '177317.jpg', '2024-03-03 18:29:37', 'Off'),
(5, 169447, 'ramy', '$2y$10$jwG4pDDdDsVQav1swkDB5OD7/zJ2.1NDCaiduBkKvvY8A5HPGu27y', 'ramy@gmail.com', '298827.jpg', '2024-03-03 18:29:48', 'On'),
(6, 329198, 'anis', '$2y$10$rbG6TkYerr4O6uOfhxrY9O/qX9upJNyv2SvLbL2dSz.44dMvfvwQS', 'anis@gmail.com', '119573.jpg', '2024-02-29 20:51:22', 'Off'),
(7, 300385, 'yesmine', '$2y$10$Dh7rJP/zXdfB.fdxmZx7zeLxQWC3PqiitmZzw/WR2YZw9IYxFsGl2', 'yesmine@gmail.com', '65722.jpg', '2024-02-29 21:48:00', 'Off');

-- --------------------------------------------------------

--
-- Structure de la table `user_msg`
--

CREATE TABLE `user_msg` (
  `id` int(30) NOT NULL,
  `incoming_id` int(255) NOT NULL,
  `outgoing_id` int(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `message_dcrypt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_msg`
--

INSERT INTO `user_msg` (`id`, `incoming_id`, `outgoing_id`, `messages`, `message_dcrypt`) VALUES
(1, 176583, 169447, 'cc', ''),
(2, 169447, 176583, 'cc', ''),
(3, 176583, 300385, 'cc', ''),
(4, 176583, 300385, 'cv', ''),
(5, 300385, 176583, 's,gbpsnfg', ''),
(6, 169447, 176583, '', ''),
(7, 169447, 176583, '', ''),
(8, 169447, 176583, 'rzkts', ''),
(9, 169447, 176583, 'uclqi', ''),
(10, 169447, 176583, 'defg', ''),
(11, 169447, 176583, 'rzkts', ''),
(12, 169447, 176583, 'uclqi', ''),
(13, 176583, 169447, 'bc uewu', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_msg`
--
ALTER TABLE `user_msg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user_msg`
--
ALTER TABLE `user_msg`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;