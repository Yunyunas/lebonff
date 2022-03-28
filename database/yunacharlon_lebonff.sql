-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db.3wa.io
-- Généré le : mer. 16 mars 2022 à 13:45
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1-log
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `yunacharlon_lebonff`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text(1000) NOT NULL,
  `url_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `url_picture`) VALUES
(1, 'Armes', 'Ici vous pouvez trouver votre bonheur. Gumblade, nunchaku, sceptre, épées, etc...', 'armes.jpg'),
(2, 'Matérias', 'Plusieurs types de matéria existes, celles de magie, de capacités, et dinvocation !', 'materias.png'),
(3, 'Objets', 'Ne partez pas à laventure sans avoir fait le stock de potions et tout autre objet utile', 'potions.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text(1000) NOT NULL,
  `url_picture` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `id_user`, `id_category`, `name`, `description`, `url_picture`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Matéria de feu', 'lorem', 'materia-rouge.jpg', 544, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(2, 1, 1, 'Murasame', 'description ok', 'gunblade.jpg', 271, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(3, 4, 2, 'Matéria Ifrit', 'la belle description', 'materia-jaune.jpg', 268, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(4, 2, 1, 'Nirvana', 'une incroyable description', 'nirvana.jpg', 350, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(5, 3, 2, 'Nosferatu', 'test description', 'materia-violet.jpg', 195, '2022-03-01 13:47:56', '2022-03-01 13:47:56');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `phone`, `email`, `password`, `role`) VALUES
(1, 'Yuna', 'Cha', 'Yuna@gmail.com', '0629345890', '123456', 'admin'),
(2, 'Shiva', 'Cha', 'Shiva@gmail.com', '0785943625', '123456', 'admin'),
(3, 'Tifa', 'Lockhart', 'Tifa@gmail.com','0666799585', '123456', 'user'),
(4, 'Squall', 'Leonhart', 'Squall@gmail.com', '0785642362', '123456', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
