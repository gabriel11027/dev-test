-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 30, 2023 at 09:14 PM
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
-- Database: `CURSOS`
--

-- --------------------------------------------------------

--
-- Table structure for table `CURSOS_DISPONIVEIS`
--

CREATE TABLE `CURSOS_DISPONIVEIS` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(255) NOT NULL,
  `TIPO` varchar(255) NOT NULL,
  `MODALIDADE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `CURSOS_DISPONIVEIS`
--

INSERT INTO `CURSOS_DISPONIVEIS` (`ID`, `NOME`, `TIPO`, `MODALIDADE`) VALUES
(1, 'Administração', 'graduação', 'presencial'),
(2, 'Administração', 'graduação', 'ead'),
(3, 'Agronomia', 'graduação', 'presencial'),
(4, 'Arquitetura e Urbanismo', 'graduação', 'presencial'),
(5, 'Biomedicina', 'graduação', 'presencial'),
(6, 'Ciências Biológicas', 'graduação', 'ead'),
(7, 'Ciências Contábeis', 'graduação', 'presencial'),
(8, 'Ciências Contábeis', 'graduação', 'ead'),
(9, 'Direito', 'graduação', 'presencial'),
(10, 'Engenharia Civil', 'graduação', 'presencial'),
(11, 'História', 'graduação', 'ead'),
(12, 'Medicina', 'graduação', 'presencial'),
(13, 'Análises Clínicas', 'pós-graduação', 'ead'),
(14, 'Aprendizagem Ativa e Tecnologias Educacionais', 'pós-graduação', 'ead'),
(15, 'Assistência Técnica e Extensão Rural', 'pós-graduação', 'ead'),
(16, 'Banco de Dados', 'pós-graduação', 'ead'),
(17, 'Biomecânica da Atividade Física e Reabilitação', 'pós-graduação', 'ead'),
(18, 'Ciência de Dados e Big Data', 'pós-graduação', 'ead'),
(19, 'Ciências da Religião', 'pós-graduação', 'ead'),
(20, 'Clínica Médica de Cães e Gatos', 'pós-graduação', 'presencial');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CURSOS_DISPONIVEIS`
--
ALTER TABLE `CURSOS_DISPONIVEIS`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CURSOS_DISPONIVEIS`
--
ALTER TABLE `CURSOS_DISPONIVEIS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
