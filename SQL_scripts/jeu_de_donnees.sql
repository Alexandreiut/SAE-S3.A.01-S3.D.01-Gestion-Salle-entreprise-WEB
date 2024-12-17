-- Activité
INSERT INTO activite (nom) 
VALUES 
('réunion'),
('formation'),
('entretien de la salle'),
('prêt'),
('location'),
('autre');

-- Utilisateur

-- Employés
INSERT INTO utilisateur (nom, prenom, telephone, role, login, motDePasse)
VALUES
('Dupont', 'Pierre', '2614', 'employé', 'pierre_dupont', 'password123'),
('Lexpert', 'Noemie', '2614', 'employé', 'noemie_lexpert', 'password123'),
('Dujardin', 'Océane', '2633', 'employé', 'oceane_dujardin', 'password123'),
('Durand', 'Bill', '2696', 'employé', 'bill_durand', 'password123'),
('Dupont', 'Max', '2614', 'employé', 'max_dupont', 'password123'),
('Martin', 'Martin', '2678', 'employé', 'martin_martin', 'password123'),
('Legrand', 'Jean-Pierre', '2689', 'employé', 'jean_pierre_legrand', 'password123'),
('Deneuve', 'Zoé', '2626', 'employé', 'zoe_denueve', 'password123');

-- Administrateur
INSERT INTO utilisateur (nom, prenom, telephone, role, login, motDePasse)
VALUES
('nomAdmin', 'prenomAdmin', '2614', 'administrateur', 'admin', 'password123');

-- Logiciels 
INSERT INTO logiciel (nom) 
VALUES 
('bureautique'),
('java'),
('Intellij'),
('photoshop');

-- Salles 
INSERT INTO salle (nom, capacite, videoProjecteur, ecranXXL, nombreOrdinateur, typeOrdinateur, imprimante) 
VALUES 
('A6', 15, 'oui', 'non', 4, 'PC portable', 'non'),
('salle bleue', 18, 'oui', 'oui', 0, '', 'non'),
('salle ronde', 14, 'oui', 'non', 0, '', 'non'),
('salle Picasso', 15, 'non', 'non', 0, '', 'non'),
('petite salle', 7, 'oui', 'oui', 0, '', 'non'),
('A7', 4, 'non', 'non', 0, '', 'non'),
('salle patio', 6, 'non', 'non', 0, '', 'non'),
('salle Sydney', 20, 'oui', 'non', 16, 'PC Windows', 'non'),
('salle Brisbane', 22, 'oui', 'non', 18, 'PC Windows', 'oui');

-- logiciel - salle
INSERT INTO logiciel_salle (id_logiciel, id_salle) 
VALUES 
(1, 1),  -- Logiciel 1 (bureautique) dans salle 1 (A6)
(1, 8),  -- Logiciel 1 (bureautique) dans salle 8 (salle Sydney)
(1, 9),  -- Logiciel 1 (bureautique) dans salle 9 (salle Brisbane)
(2, 8),  -- Logiciel 2 (java) dans salle 8 (salle Sydney)
(2, 9),  -- Logiciel 2 (java) dans salle 9 (salle Brisbane)
(3, 8),  -- Logiciel 3 (Intellij) dans salle 8 (salle Sydney)
(3, 9),  -- Logiciel 3 (Intellij) dans salle 9 (salle Brisbane)
(4, 9);  -- Logiciel 4 (photoshop) dans salle 9 (salle Brisbane)

-- interlocuteurs
INSERT INTO interlocuteur (nom, prenom, telephone) 
VALUES 
('Legendre', 'Noémie', '0600000000'),
('Leroux', 'Jacques', '0600000001'),
('Marin', 'Hector', '0666666666'),
('Tournefeuille', 'Michel', '0655555555');

-- Réservations
INSERT INTO reservation (date, heureDebut, heureFin, descriptionActivite, object, interlocuteur, salle, activite, reservant)
VALUES 
('2024-10-07', '17:00', '19:00', 'club gym', 'réunion', 1, 1, 4, 1),
('2024-10-07', '15:00', '18:00', 'réunion avec client', '', NULL, 4, 1, 1),
('2024-10-07', '10:00', '11:00', 'Préparation réunion client', '', NULL, 4, 1, 5),
('2024-10-08', '09:00', '11:00', '', '', NULL, 4, 1, 2),
('2024-10-08', '17:00', '19:00', 'club gym', 'AG', 1, 1, 4, 3),
('2024-10-09', '09:00', '12:00', 'tests candidats', '', NULL, 8, 6, 7),
('2024-10-07', '15:00', '18:00', 'présentation maquette', '', NULL, 3, 1, 7),
('2024-10-10', '08:00', '18:00', 'Bureautique', '', 2, 1, 2, 3),
('2024-10-11', '08:00', '18:00', 'Bureautique', '', 2, 1, 2, 3),
('2024-10-07', '10:00', '12:00', 'accueil nouveau membre', '', NULL, 3, 1, 8),
('2024-10-10', '09:00', '12:00', 'tests candidats', '', NULL, 8, 6, 1),
('2024-10-15', '09:00', '10:00', 'point avec stagiaire', '', NULL, 6, 1, 7),
('2024-10-11', '08:00', '17:00', 'mise à jour logiciels', '', NULL, 8, 3, 3),
('2024-10-11', '08:00', '17:00', 'mise à jour logiciels', '', NULL, 9, 3, 7),
('2024-10-16', '10:00', '11:00', 'visite tuteur IUT', '', NULL, 6, 1, 7),
('2024-10-17', '14:00', '15:30', 'validation maquette', '', NULL, 6, 1, 5),
('2024-10-18', '08:00', '13:00', 'Mairie', 'réunion', 3, 1, 5, 8),
('2024-10-18', '13:00', '19:00', 'Département', 'réunion', 4, 1, 5, 5);

