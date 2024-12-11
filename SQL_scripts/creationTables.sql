-- CREATION DATABASE
CREATE DATABASE IF NOT EXISTS RoomManager DEFAULT CHARACTER SET utf8mb4  COLLATE utf8mb4_general_ci;
USE RoomManager;

-- SUPPRESSION DES TABLES EXISTANTES (SI ELLES EXISTENT)
DROP TABLE IF EXISTS `reservation`;
DROP TABLE IF EXISTS `logiciel_salle`;
DROP TABLE IF EXISTS `salle`;
DROP TABLE IF EXISTS `interlocuteur`;
DROP TABLE IF EXISTS `utilisateur`;
DROP TABLE IF EXISTS `logiciel`;
DROP TABLE IF EXISTS `activite`;

-- CREATION TABLES

CREATE TABLE `activite` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `logiciel` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `salle` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `capacite` int(5) NOT NULL,
  `videoProjecteur` varchar(3) NOT NULL,
  `ecranXXL` varchar(3) NOT NULL,
  `nombreOrdinateur` int(5) NOT NULL,
  `typeOrdinateur` varchar(70) NOT NULL,
  `imprimante` varchar(3) NOT NULL,
  UNIQUE(`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `logiciel_salle` (
  `id_logiciel` int(7) NOT NULL,
  `id_salle` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `utilisateur` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prenom` varchar(70) NOT NULL,
  `telephone` char(10) NOT NULL,
  `role` varchar(70) NOT NULL,
  `login` varchar(70) NOT NULL,
  `motDePasse` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `interlocuteur` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prenom` varchar(70) NOT NULL,
  `telephone` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reservation` (
  `identifiant` int(7) NOT NULL,
  `date` DATE NOT NULL,
  `heureDebut` TIME NOT NULL,
  `heureFin` TIME NOT NULL,
  `descriptionActivite` varchar(100),
  `object` varchar(70),
  `interlocuteur` int(7),
  `salle` int(7) NOT NULL,
  `activite` int(7) NOT NULL,
  `reservant` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- PRIMARY KEYS

ALTER TABLE `activite`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `logiciel`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `salle`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `logiciel_salle`
  ADD PRIMARY KEY (`id_logiciel`, `id_salle`);

ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `interlocuteur`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `reservation`
  ADD PRIMARY KEY (`identifiant`),
  ADD KEY `fk_interlocuteur` (`interlocuteur`),
  ADD KEY `fk_salle` (`salle`),
  ADD KEY `fk_activite` (`activite`),
  ADD KEY `fk_utilisateur` (`reservant`);

-- AUTO INCREMENTS

ALTER TABLE `activite`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `logiciel`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `salle`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `utilisateur`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `interlocuteur`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `reservation`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

-- CONSTRAINTS

ALTER TABLE `logiciel_salle`
  ADD CONSTRAINT `fk_logiciel` FOREIGN KEY (`id_logiciel`) REFERENCES `logiciel` (`identifiant`),
  ADD CONSTRAINT `fk_salle` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`identifiant`);

ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_interlocuteur` FOREIGN KEY (`interlocuteur`) REFERENCES `interlocuteur` (`identifiant`),
  ADD CONSTRAINT `fk_salle_reservee` FOREIGN KEY (`salle`) REFERENCES `salle` (`identifiant`),
  ADD CONSTRAINT `fk_activite` FOREIGN KEY (`activite`) REFERENCES `activite` (`identifiant`),
  ADD CONSTRAINT `fk_utilisateur` FOREIGN KEY (`reservant`) REFERENCES `utilisateur` (`identifiant`);

ALTER TABLE `salle`
  ADD CONSTRAINT `oui_non_projecteur` CHECK (videoProjecteur = "oui" OR videoProjecteur = "non"),
  ADD CONSTRAINT `oui_non_ecranXXL` CHECK (ecranXXL = "oui" OR ecranXXL = "non"),
  ADD CONSTRAINT `oui_non_imprimante` CHECK (imprimante = "oui" OR imprimante = "non");
