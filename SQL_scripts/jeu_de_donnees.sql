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

-- Administrateur
INSERT INTO `utilisateur` (nom, prenom, telephone, role, login, motDePasse)
VALUES
('nomAdmin', 'prenomAdmin', '2614000000', 'administrateur', 'admin', 'password123');

-- Employés
INSERT INTO `utilisateur` (nom, prenom, telephone, role, login, motDePasse)
VALUES
('Dupont', 'Pierre', '2614000000', 'employé', 'pierre_dupont', 'password123'),
('Lexpert', 'Noemie', '2614000000', 'employé', 'noemie_lexpert', 'password123'),
('Dujardin', 'Océane', '2633000000', 'employé', 'oceane_dujardin', 'password123'),
('Durand', 'Bill', '2696000000', 'employé', 'bill_durand', 'password123'),
('Dupont', 'Max', '2614000000', 'employé', 'max_dupont', 'password123'),
('Martin', 'Martin', '2678000000', 'employé', 'martin_martin', 'password123'),
('Legrand', 'Jean-Pierre', '2689000000', 'employé', 'jean_pierre_legrand', 'password123'),
('Deneuve', 'Zoé', '2626000000', 'employé', 'zoe_denueve', 'password123');

-- Logiciels 
INSERT INTO `logiciel` (nom) 
VALUES 
('bureautique'),
('java'),
('Intellij'),
('photoshop');

-- Salles 
INSERT INTO `salle` (nom, capacite, videoProjecteur, ecranXXL, nombreOrdinateur, typeOrdinateur, imprimante) 
VALUES 
('A6', 15, 'oui', 'non', 4, 'PC portable', 'non'),
('salle bleue', 18, 'oui', 'oui', NULL, NULL, NULL),
('salle ronde', 14, 'oui', 'non', NULL, NULL, NULL),
('salle Picasso', 15, 'non', 'non', NULL, NULL, NULL),
('petite salle', 7, 'oui', 'oui', NULL, NULL, NULL),
('A7', 4, 'non', 'non', NULL, NULL, NULL),
('salle patio', 6, 'non', 'non', NULL, NULL, NULL),
('salle Sydney', 20, 'oui', 'non', 16, 'PC Windows', 'non'),
('salle Brisbane', 22, 'oui', 'non', 18, 'PC Windows', 'oui');

-- logiciel - salle
INSERT INTO `logiciel_salle` (id_logiciel, id_salle) 
VALUES 
(1, 1),  -- Logiciel 1 (bureautique) dans salle 1 (A6)
(1, 8),  -- Logiciel 1 (bureautique) dans salle 8 (salle Sydney)
(1, 9),  -- Logiciel 1 (bureautique) dans salle 9 (salle Brisbane)
(2, 8),  -- Logiciel 2 (java) dans salle 8 (salle Sydney)
(2, 9),  -- Logiciel 2 (java) dans salle 9 (salle Brisbane)
(3, 8),  -- Logiciel 3 (Intellij) dans salle 8 (salle Sydney)
(3, 9),  -- Logiciel 3 (Intellij) dans salle 9 (salle Brisbane)
(4, 9);  -- Logiciel 4 (photoshop) dans salle 9 (salle Brisbane)

