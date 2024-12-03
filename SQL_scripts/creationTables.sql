-- CREATION TABLES

CREATE TABLE `activite` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `salle` (
  `identifiant` int(8) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `capacite` int(5) NOT NULL,
  `videoProjecteur` varchar(3) NOT NULL,
  `ecranXXL` varchar(3) NOT NULL,
  `nombreOrdinateur` int(5) NOT NULL,
  `typeOrdinateur` varchar(70) NOT NULL,
  `logicielPresent` varchar(5000) NOT NULL,
  `imprimante` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `utilisateur` (
  `identifiant` int(7) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prenom` varchar(70) NOT NULL,
  `telephone` char(10) NOT NULL,
  `administrateur` varchar(3) NOT NULL,
  `login` varchar(70) NOT NULL,
  `motDePasse` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reservation` (
  `identifiant` int(7) NOT NULL,
  `date` DATE NOT NULL,
  `heureDebut` char(5) NOT NULL,
  `heureFin` char(5) NOT NULL,
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
  `descriptionActivite` char(100),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- PRIMARY KEYS

ALTER TABLE `activite`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `salle`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`identifiant`);

ALTER TABLE `reservation`
  ADD PRIMARY KEY (`identifiant`);
  -- TODO FK


-- CONSTRAINTS (OUI / NON)




-- AUTO INCREMENTS

ALTER TABLE `activite`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `salle`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `utilisateur`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `reservation`
  MODIFY `identifiant` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;