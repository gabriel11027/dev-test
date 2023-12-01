-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 01, 2023 at 12:10 AM
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
-- Database: `ALUNOS`
--

-- --------------------------------------------------------

--
-- Table structure for table `ALUNOS_MATRICULADOS`
--

CREATE TABLE `ALUNOS_MATRICULADOS` (
  `ID` int(11) NOT NULL,
  `NOME_COMPLETO` varchar(255) NOT NULL,
  `CURSO` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `TELEFONE` varchar(255) NOT NULL,
  `NASCIMENTO` varchar(255) NOT NULL,
  `CEP` varchar(255) NOT NULL,
  `CPF` varchar(255) NOT NULL,
  `DOCUMENTO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ALUNOS_MATRICULADOS`
--

INSERT INTO `ALUNOS_MATRICULADOS` (`ID`, `NOME_COMPLETO`, `CURSO`, `EMAIL`, `TELEFONE`, `NASCIMENTO`, `CEP`, `CPF`, `DOCUMENTO`) VALUES
(1, 'Gabriel', 'gabriel@gmail.com', 'gabriel@gmail.com', '44988129839', '10/10/2000', '81910390', '89692842061', './documentos/documento89692842061.pdf'),
(2, 'Bilbo Baggins ', 'bilbo@theshire.com', 'bilbo@theshire.com', '22222222222', '01/01/2008', '12345678', '12345678901', './documentos/documento12345678901.pdf'),
(3, 'Frodo Baggings', 'frodo@valinor.org', 'frodo@valinor.org', '33333333333', '01/01/2009', '32131232', '31231232131', './documentos/documento31231232131.pdf'),
(4, 'Samwise Gamgee', 'samwisegangee@minastirith.com', 'samwisegangee@minastirith.com', '00101010001', '10/06/1990', '12312432', '31245242542', './documentos/documento31245242542.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `ALUNOS_POTENCIAIS`
--

CREATE TABLE `ALUNOS_POTENCIAIS` (
  `ID` int(11) NOT NULL,
  `NOME_COMPLETO` varchar(255) NOT NULL,
  `CURSO` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `TELEFONE` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ALUNOS_POTENCIAIS`
--

INSERT INTO `ALUNOS_POTENCIAIS` (`ID`, `NOME_COMPLETO`, `CURSO`, `EMAIL`, `TELEFONE`) VALUES
(1, 'Gabriel', 'curso16', 'gabriel127@gmail.com', '44999999999'),
(2, 'teste', 'curso6', 'teste@gmail.com', '44999999999'),
(3, 'teste2', 'curso2', 'teste2@gmail.com', '12345678901');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ALUNOS_MATRICULADOS`
--
ALTER TABLE `ALUNOS_MATRICULADOS`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ALUNOS_POTENCIAIS`
--
ALTER TABLE `ALUNOS_POTENCIAIS`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ALUNOS_MATRICULADOS`
--
ALTER TABLE `ALUNOS_MATRICULADOS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ALUNOS_POTENCIAIS`
--
ALTER TABLE `ALUNOS_POTENCIAIS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
