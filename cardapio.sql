-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 29-Jun-2018 às 12:15
-- Versão do servidor: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cardapio`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(2, 'Populares'),
(3, 'Acompanhamentos'),
(4, 'Tradicionais'),
(5, 'Especiais'),
(6, 'Bebidas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Login`
--

CREATE TABLE IF NOT EXISTS `Login` (
  `user` varchar(11) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `id_login` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `Login`
--

INSERT INTO `Login` (`user`, `senha`, `id_login`) VALUES
('Super', '827ccb0eea8a706c4c34a16891f84e7b', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `meal`
--

CREATE TABLE IF NOT EXISTS `meal` (
  `id_meal` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(800) NOT NULL,
  `src_photo` varchar(100) NOT NULL,
  `id_category` int(11) NOT NULL,
  `enable` varchar(1) NOT NULL,
  `enablePop` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `meal`
--

INSERT INTO `meal` (`id_meal`, `name`, `description`, `src_photo`, `id_category`, `enable`, `enablePop`) VALUES
(23, 'Mandioca Frita', 'Deliciosa mandioca cremosa frita acompanhada de molho especial da casa.', 'MandiocaCremosaFrita.png', 3, '1', 1),
(24, 'Tulipas Empanadas', 'Tulipas de frango maravilhosamente temperadas e empanadas em panko (farinha de rosca japonesa). Acompanha dois molhos especiais da casa. ', 'TulipasEmpanadas.png', 3, '1', NULL),
(25, 'Bacon Lovers', '150g do nosso blend de carnes bovinas com queijo mussarela, bacon assado crocante, nosso famoso crispy crocante de couve e maionese de alho. Acompanha batatas fritas.', 'BaconLovers.png', 4, '1', 0),
(26, 'Batatas Fritas', 'Desde as mais tradicionais atÃ© as mais especiais, as nossas batatas fritas sÃ£o crocantes por fora e macias por dentro.', 'BatatasFritas.png', 3, '1', NULL),
(27, 'Onion Rings', 'AnÃ©is de cebola empanados e crocantes, acompanhados de dois molhos especiais da casa.', 'OnionRings.png', 3, '1', 0),
(28, 'Cheese Lovers', '150g do nosso blend de carnes bovinas com queijos mussarela e gorgonzola, maionese de alho, alÃ©m do nosso famoso crispy de couve. Acompanha batatas fritas.', 'CheeseLovers.png', 4, '1', NULL),
(29, 'Cheddar Lovers', '150g do nosso blend de carnes bovinas com queijo cheddar Polenghi, bacon assado crocante, nosso famoso crispy de couve e maionese de alho. Acompanha batatas fritas.', '15302312555b3579d74f232.png', 4, '1', 1),
(30, 'Texano', '150g do nosso blend de carnes bovinas com queijo mussarela, molho de barbecue, nosso famoso crispy de couve e nosso molho especial Tex-Mex maravilhosamente condimentado. Acompanha batatas fritas.', 'Texano.png', 4, '1', NULL),
(31, 'Vegetariano', '150g do nosso blend de grÃ£o de bico e vegetais com queijo mussarela, nosso famoso crispy de couve e maionese de alho.', 'Vegetariano.png', 4, '1', NULL),
(32, 'Picanha', '200g de carne de picanha moÃ­da na hora, queijo mussarela e fatias de bacon assado crocante, maionese de alho, alÃ©m do nosso famoso crispy de couve.', 'Picanha.png', 5, '1', 1),
(33, 'Do Avesso', 'HambÃºrguer de 150g regado em nosso molho espacial secreto, no pÃ£o com bacon, catupiry e mussarela por fora. Servido com batatas fritas e ovo frito. ', 'DoAvesso.png', 5, '1', NULL),
(34, 'Costela ou Fraldinha', '150g de carne de costela moÃ­da ou fraldinha, queijo prato, fatias de bacon assado crocante, molho de maionese e nosso famoso crispy de couve.', 'CostelaouFraldinha.png', 5, '1', NULL),
(35, 'Duplex', 'Dois hambÃºrgueres de 150g do nosso blend de carnes, queijos cheddar e mussarela, bacon, onion rings, maionese de alho e o nosso famoso crispy de couve.', 'Duplex.png', 5, '1', NULL),
(36, 'Triplex', 'TrÃªs hambÃºrgueres de 150g do nosso blend de carnes, queijos cheddar, mussarela e prato, bacon, onion rings, ovo frito, maionese de alho e o nosso famoso crispy de couve. Acompanha onion rings.', 'Triplex.png', 5, '1', NULL),
(37, 'Refrigerantes', 'Os refrigerantes disponÃ­veis sÃ£o latas ou garrafas e podem ser pedidos em copos com gelo e limÃ£o.', 'refrigerante.png', 6, '1', NULL),
(38, 'Sucos', 'Os sucos polpa de jarra podem ser de diversos sabores: abacaxi, abacaxi com hortelÃ£, melancia, morango e acerola. Consulte as opÃ§Ãµes disponÃ­veis.', 'suco.png', 6, '1', 1),
(39, 'Cervejas', 'As cervejas em garrafas long neck sÃ£o servidas bem geladas e sÃ£o ideais para acompanhar nossos hambÃºrgueres.', 'cerveja.png', 6, '1', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `id_price` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `id_meal` int(11) NOT NULL,
  `enable` varchar(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `price`
--

INSERT INTO `price` (`id_price`, `description`, `price`, `id_meal`, `enable`) VALUES
(19, '400g', 20, 23, '1'),
(20, '500g', 38, 24, '1'),
(21, 'Simples 200g', 9, 26, '1'),
(22, 'Cebola e bacon 200g', 13, 26, '1'),
(23, 'Simples 400g', 15, 26, '1'),
(24, 'Cebola e bacon 400g', 19, 26, '1'),
(25, 'Cheddar e bacon', 23, 26, '1'),
(26, '200g', 16, 27, '1'),
(27, '400g', 24, 27, '1'),
(28, '', 22, 25, '1'),
(29, '', 23, 28, '1'),
(30, '', 22, 29, '1'),
(31, '', 23, 30, '1'),
(32, '', 27, 31, '1'),
(33, '', 33, 32, '1'),
(34, '', 30, 33, '1'),
(35, '', 29, 34, '1'),
(36, '', 35, 35, '1'),
(37, '', 49, 36, '1'),
(38, 'Coca-Cola(350ml)', 4.9, 37, '1'),
(39, 'Guaraná(350ml)', 4.5, 37, '0'),
(40, 'H20(500ml)', 6.9, 37, '1'),
(41, '600ml', 10, 38, '1'),
(42, 'Heineken', 7, 39, '1'),
(43, 'Stella Artois', 9, 39, '1'),
(44, 'Skol', 6.9, 39, '1'),
(45, 'Eisebahn', 7.9, 39, '1'),
(46, 'Fanta uva(350ml)', 4.9, 37, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`id_meal`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id_price`),
  ADD KEY `id_meal` (`id_meal`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Login`
--
ALTER TABLE `Login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `id_meal` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id_price` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `meal`
--
ALTER TABLE `meal`
  ADD CONSTRAINT `id_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `id_meal` FOREIGN KEY (`id_meal`) REFERENCES `meal` (`id_meal`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
