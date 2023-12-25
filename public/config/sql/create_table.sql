-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    adresse_email VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    adresse VARCHAR(255),
    telephone_portable VARCHAR(15),
    photo_profil VARCHAR(255),
    adresse_email_secours VARCHAR(255),
    role ENUM('membre', 'admin') DEFAULT 'membre', 
    UNIQUE KEY (adresse_email),
    UNIQUE KEY (adresse_email_secours)
);

-- ajout champs photo_profil et adresse_email_secours
ALTER TABLE utilisateurs DROP INDEX adresse_email;

ALTER TABLE utilisateurs
ADD COLUMN photo_profil VARCHAR(255),
ADD COLUMN adresse_email_secours VARCHAR(255);

ALTER TABLE utilisateurs
ADD UNIQUE KEY (adresse_email, adresse_email_secours);


-- Table des publications
CREATE TABLE publications (
    id_publication INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    titre VARCHAR(255),
    texte TEXT,
    photo_url VARCHAR(255),
    visibilite ENUM('amis', 'public') DEFAULT 'amis',
    date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

-- Table des appréciations (like/dislike)
CREATE TABLE appreciations (
    id_appreciation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_publication INT,
    type ENUM('like', 'dislike') NOT NULL,
    commentaire TEXT,
    date_appreciation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
    FOREIGN KEY (id_publication) REFERENCES publications(id_publication)
);

-- -- Table des amis
-- CREATE TABLE amis (
--     id_amitie INT AUTO_INCREMENT PRIMARY KEY,
--     id_utilisateur1 INT,
--     id_utilisateur2 INT,
--     statut ENUM('attente', 'accepte') DEFAULT 'attente',
--     FOREIGN KEY (id_utilisateur1) REFERENCES utilisateurs(id_utilisateur),
--     FOREIGN KEY (id_utilisateur2) REFERENCES utilisateurs(id_utilisateur)
-- );


-- Table des administrateurs
CREATE TABLE administrateurs (
    id_administrateur INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

-- Table des actions d'administration
CREATE TABLE actions_administration (
    id_action INT AUTO_INCREMENT PRIMARY KEY,
    id_administrateur INT,
    type_action ENUM('suppression_membre', 'suppression_information', 'envoi_mail') NOT NULL,
    id_membre_concerne INT,
    commentaire TEXT,
    date_action DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_administrateur) REFERENCES administrateurs(id_administrateur),
    FOREIGN KEY (id_membre_concerne) REFERENCES utilisateurs(id_utilisateur)
);
