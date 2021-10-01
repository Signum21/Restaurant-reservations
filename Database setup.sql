CREATE DATABASE sitoristoranti;

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Cognome` varchar(30) NOT NULL,
  `DataNascita` date NOT NULL,
  `Genere` varchar(10) NOT NULL,
  `Tipo` varchar(15) NOT NULL,
  `Random` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` text NOT NULL,
  `Attivo` tinyint(1) NOT NULL
);

CREATE TABLE `locali` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Nome` varchar(30) NOT NULL,
  `Numero` varchar(10) NOT NULL,
  `Citta` varchar(30) NOT NULL,
  `CAP` int(11) NOT NULL,
  `Indirizzo` varchar(30) NOT NULL,
  `NumeroCivico` int(11) NOT NULL,
  `Foto1` longblob NOT NULL,
  `Foto2` longblob NOT NULL,
  `Foto3` longblob NOT NULL,
  `Foto4` longblob NOT NULL,
  `Attivo` tinyint(1) NOT NULL
);

CREATE TABLE `menu` (
  `Id` int(11) NOT NULL,
  `LocaleId` int(11) DEFAULT NULL,
  `Tipo` varchar(15) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Prezzo` decimal(10,2) NOT NULL,
  `Ingredienti` text NOT NULL,
  `Foto` longblob NOT NULL,
  `Attivo` tinyint(1) NOT NULL
);

CREATE TABLE `prenotazioni` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `LocaleId` int(11) DEFAULT NULL,
  `Data` date NOT NULL,
  `Ora` time NOT NULL,
  `Persone` int(11) NOT NULL,
  `Stato` varchar(50) NOT NULL
);

CREATE TABLE `menu_prenotazioni` (
  `Id` int(11) NOT NULL,
  `PrenotazioneId` int(11) DEFAULT NULL,
  `MenuId` int(11) DEFAULT NULL,
  `Quantita` int(11) NOT NULL
);

ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Random` (`Random`),
  ADD UNIQUE KEY `Username` (`Username`);
  
ALTER TABLE `locali`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`);
  
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `menu_ibfk_1` (`LocaleId`);
  
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `LocaleId` (`LocaleId`);
  
ALTER TABLE `menu_prenotazioni`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPrenotazione` (`PrenotazioneId`),
  ADD KEY `IdMenu` (`MenuId`);

ALTER TABLE `users` MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `locali` MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `menu` MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `prenotazioni` MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `menu_prenotazioni` MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `locali` ADD CONSTRAINT `locali_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

ALTER TABLE `menu` ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`LocaleId`) REFERENCES `locali` (`Id`) ON DELETE CASCADE;

ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`LocaleId`) REFERENCES `locali` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `menu_prenotazioni`
  ADD CONSTRAINT `menu_prenotazioni_ibfk_1` FOREIGN KEY (`PrenotazioneId`) REFERENCES `prenotazioni` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_prenotazioni_ibfk_2` FOREIGN KEY (`MenuId`) REFERENCES `menu` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;