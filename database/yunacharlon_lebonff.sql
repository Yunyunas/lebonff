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
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `url_picture`) VALUES
(1, 'Armes', 'Ici vous pouvez trouver votre bonheur. Gumblade, nunchaku, sceptre, épées, etc...', 'https://i.pinimg.com/originals/26/a6/91/26a6912dab74f2df9694aefc97e06dbf.jpg'),
(2, 'Matérias', 'Plusieurs types de matéria existes, celles de magie, de capacités, et dinvocation !', 'https://i.imgur.com/VDGBSJm.png'),
(3, 'objets', 'Ne partez pas à laventure sans avoir fait le stock de potions et tout autre objet utile', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQd5ds7VpSrccVCgFUga-PTu9I-f2DW-38t1w&usqp=CAU');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url_picture` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `id_user`, `id_category`, `name`, `description`, `url_picture`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Matéria de feu', 'lorem', 'https://images.pexels.com/photos/7693946/pexels-photo-7693946.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260', 544, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(2, 1, 1, 'Murasame', 'description ok', 'https://images.pexels.com/photos/4916562/pexels-photo-4916562.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260', 271, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(3, 4, 2, 'Matéria Ifrit', 'la belle description', 'https://images.pexels.com/photos/7474289/pexels-photo-7474289.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260', 268, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(4, 2, 1, 'Nirvana', 'une incroyable description', 'https://images.pexels.com/photos/6550780/pexels-photo-6550780.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260', 350, '2022-03-01 13:47:56', '2022-03-01 13:47:56'),
(5, 3, 2, 'Nosferatu', 'test description', 'https://images.pexels.com/photos/7693949/pexels-photo-7693949.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260', 195, '2022-03-01 13:47:56', '2022-03-01 13:47:56');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` int(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `email`, `password`, `address`, `postal_code`, `city`, `role`) VALUES
(1, 'Yuna', 'Cha', 'Yuna@gmail.com', '123456', '333 route de l enfer', 76360, 'Pissy-Poville', 'admin'),
(2, 'Shiva', 'Cha', 'Shiva@gmail.com', '123456', '78 avenue de la libération', 15210, 'Ydes', 'admin'),
(3, 'Tifa', 'Lockhart', 'Tifa@gmail.com', '123456', '11 rue josephine baker', 49100, 'Angers', 'user'),
(4, 'Squall', 'Leonhart', 'Squall@gmail.com', '123456', '1997 rue du best jeu ever', 19970, 'Balamb', 'user');

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
