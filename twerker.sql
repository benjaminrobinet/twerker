-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 30 nov. 2018 à 17:52
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `twerker`
--

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `follower` int(11) NOT NULL,
  `followee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `follow`
--

INSERT INTO `follow` (`id`, `follower`, `followee`) VALUES
(2, 10, 6),
(3, 10, 2),
(4, 1, 2),
(5, 6, 2),
(6, 9, 10),
(7, 2, 9);

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

CREATE TABLE `like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `like`
--

INSERT INTO `like` (`id`, `user_id`, `tweet_id`) VALUES
(1, 10, 63),
(2, 11, 75),
(3, 11, 63),
(4, 11, 74),
(5, 11, 73),
(6, 11, 72),
(7, 11, 71),
(8, 11, 67),
(9, 11, 68);

-- --------------------------------------------------------

--
-- Structure de la table `tweet`
--

CREATE TABLE `tweet` (
  `id` int(11) NOT NULL,
  `text` varchar(256) NOT NULL,
  `author` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tweet`
--

INSERT INTO `tweet` (`id`, `text`, `author`, `score`, `created_at`, `updated_at`) VALUES
(49, 'Off to Waterloo. Wish me luck.', 7, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(50, 'Logic will get you from A to B. Imagination will take you everywhere.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(51, 'Man who jump off cliff, jump to conclusion!', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(52, ' have spoken w/ @GovAbbott of Texas and @LouisianaGov Edwards. Closely monitoring #HurricaneHarvey developments & here to assist as needed.', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(53, 'Man who not poop for many days must take care of back log.', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(54, 'All Tweeters are Created Equal', 4, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(55, 'He who drops watch in toilet has shitty time', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(56, 'Going to a Cabinet Meeting (tele-conference) at 11:00 A.M. on #Harvey. Even experts have said they\'ve never seen one like this!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(57, 'HISTORIC rainfall in Houston, and all over Texas. Floods are unprecedented, and more rain coming. Spirit of the people is incredible.Thanks!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(58, 'Be yourself; everyone else is already taken.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(59, 'To live is the rarest thing in the world. Most people exist, that is all.', 9, 1, '2017-08-31 07:59:35', '2018-11-23 13:44:54'),
(60, 'For those at the back who obviously can\'t hear me, I said that they may take out lives, but they\'ll never take our freedom', 5, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(61, 'With Mexico being one of the highest crime Nations in the world, we must have THE WALL. Mexico will pay for it through reimbursement/other.', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(62, 'Man who sneezes without tissue takes matters in own hands.', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(63, 'I am so clever that sometimes I don\'t understand a single word of what I am saying.', 9, 3, '2017-10-08 12:07:37', '2018-11-23 14:05:28'),
(64, 'I am pleased to inform you that I have just granted a full Pardon to 85 year old American patriot Sheriff Joe Arpaio. He kept Arizona safe!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(65, 'Only two things are infinite, the universe and human stupidity, and I\'m not sure about the former.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(66, 'The true sign of intelligence is not knowledge but imagination.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(67, 'It is the supreme art of the teacher to awaken joy in creative expression and knowledge.', 8, 1, '2017-08-31 07:59:35', '2018-11-28 15:06:56'),
(68, 'Busted through that wall like it was paper #sorrynotsorry', 6, 1, '2017-08-31 07:59:35', '2018-11-28 15:06:59'),
(69, 'A person who never made a mistake never tried anything new.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(70, 'Always forgive your enemies; nothing annoys them so much.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(71, 'Hello world of tweeter #ImNewatThis', 10, 0, '2017-09-01 12:57:48', '2018-11-28 15:06:53'),
(72, 'Is there anybody out here ? #ImLonely', 10, 1, '2017-09-01 13:00:39', '2018-11-23 14:05:31'),
(73, 'Still nobody ??? #ImLonely', 10, -1, '2017-09-01 13:04:39', '2018-11-23 14:05:30'),
(74, 'This place sucks.', 10, 1, '2017-09-01 13:10:21', '2018-11-23 14:05:30'),
(75, 'salut la mifa ça va ?', 11, 6, '2018-11-23 13:43:35', '2018-11-23 14:03:56');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(512) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `level` int(11) NOT NULL,
  `followers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `password`, `level`, `followers`) VALUES
(1, 'Donald J. Trump', 'donald', '', 100, 0),
(2, 'Conficius', 'conficius', '', 100, 3),
(3, 'Master Yoda', 'yoda', '', 100, 0),
(4, 'Martin Luther King', 'martin', '', 100, 0),
(5, 'William Wallace', 'will', '', 100, 0),
(6, 'Genghis Khan', 'mongoldude', '', 100, 1),
(7, 'Napoleon Bonaparte', 'napoleon', '', 100, 0),
(8, 'Albert Einstein', 'albert', '', 100, 0),
(9, 'Oscar Wilde', 'oscar', '', 100, 1),
(10, 'John Doe', 'johny', '$2y$10$9xy1A.dN0.eppTrLciPCn.hiMBHm2WAr1ykbgqcvaX6Uc66A7il8C', 100, 1),
(11, 'benjamin', 'benjamin', '$2y$10$1rkRyhPih4xi/.LmvsmgY.kChEJtS34zupmb68g..EWix3bo5z/Rm', 150, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `like`
--
ALTER TABLE `like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
