-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 20, 2021 alle 16:38
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unishare`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquisto`
--

CREATE TABLE `acquisto` (
  `ID_acquisto` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `appunto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `appunti`
--

CREATE TABLE `appunti` (
  `idappunti` int(11) NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `Path` varchar(300) NOT NULL,
  `uploadDate` date NOT NULL DEFAULT current_timestamp(),
  `price` double NOT NULL,
  `insegnamento_scuola` int(11) NOT NULL,
  `user` varchar(45) NOT NULL,
  `tipoAppunti` int(11) NOT NULL DEFAULT 1,
  `nomeDocente` varchar(45) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `dashboard`
--

CREATE TABLE `dashboard` (
  `obj1` int(11) NOT NULL,
  `obj2` int(11) NOT NULL,
  `obj3` int(11) NOT NULL,
  `obj4` int(11) NOT NULL,
  `user` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `insegnamento`
--

CREATE TABLE `insegnamento` (
  `idInsegnamento` int(11) NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `scuola` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `idRecensione` int(11) NOT NULL,
  `valore` int(11) NOT NULL,
  `appunto` int(11) NOT NULL,
  `acquisto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `scuola`
--

CREATE TABLE `scuola` (
  `idScuola` int(11) NOT NULL,
  `nomeScuola` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `Name` varchar(45) NOT NULL,
  `Surname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(200) NOT NULL,
  `UserType` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquisto`
--
ALTER TABLE `acquisto`
  ADD PRIMARY KEY (`ID_acquisto`),
  ADD KEY `fk_Acquisto_Appunti1_idx` (`appunto`);

--
-- Indici per le tabelle `appunti`
--
ALTER TABLE `appunti`
  ADD PRIMARY KEY (`idappunti`),
  ADD KEY `fk_Appunti_DipartimentoScuola1_idx` (`insegnamento_scuola`),
  ADD KEY `fk_Appunti_Users1_idx` (`user`);

--
-- Indici per le tabelle `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`user`),
  ADD KEY `fk_dashboard_Users1_idx` (`user`);

--
-- Indici per le tabelle `insegnamento`
--
ALTER TABLE `insegnamento`
  ADD PRIMARY KEY (`idInsegnamento`),
  ADD KEY `fk_DipartimentoScuola_Scuola1_idx` (`scuola`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`idRecensione`),
  ADD KEY `fk_Recensione_Appunti1_idx` (`appunto`),
  ADD KEY `fk_Recensione_Acquisto1_idx` (`acquisto`);

--
-- Indici per le tabelle `scuola`
--
ALTER TABLE `scuola`
  ADD PRIMARY KEY (`idScuola`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `acquisto`
--
ALTER TABLE `acquisto`
  MODIFY `ID_acquisto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `appunti`
--
ALTER TABLE `appunti`
  MODIFY `idappunti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `insegnamento`
--
ALTER TABLE `insegnamento`
  MODIFY `idInsegnamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `idRecensione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `scuola`
--
ALTER TABLE `scuola`
  MODIFY `idScuola` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquisto`
--
ALTER TABLE `acquisto`
  ADD CONSTRAINT `fk_Acquisto_Appunti1` FOREIGN KEY (`appunto`) REFERENCES `appunti` (`idappunti`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `appunti`
--
ALTER TABLE `appunti`
  ADD CONSTRAINT `fk_Appunti_DipartimentoScuola1` FOREIGN KEY (`insegnamento_scuola`) REFERENCES `insegnamento` (`idInsegnamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Appunti_Users1` FOREIGN KEY (`user`) REFERENCES `users` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `dashboard`
--
ALTER TABLE `dashboard`
  ADD CONSTRAINT `fk_dashboard_Users1` FOREIGN KEY (`user`) REFERENCES `users` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `insegnamento`
--
ALTER TABLE `insegnamento`
  ADD CONSTRAINT `fk_DipartimentoScuola_Scuola1` FOREIGN KEY (`scuola`) REFERENCES `scuola` (`idScuola`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `fk_Recensione_Acquisto1` FOREIGN KEY (`acquisto`) REFERENCES `acquisto` (`ID_acquisto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Recensione_Appunti1` FOREIGN KEY (`appunto`) REFERENCES `appunti` (`idappunti`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
