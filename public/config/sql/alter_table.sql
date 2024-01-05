-- ajout champs photo_profil et adresse_email_secours
ALTER TABLE utilisateurs DROP INDEX adresse_email;

ALTER TABLE utilisateurs
ADD COLUMN photo_profil VARCHAR(255),
ADD COLUMN adresse_email_secours VARCHAR(255);

ALTER TABLE utilisateurs
ADD UNIQUE KEY (adresse_email, adresse_email_secours);


--(gérer plusieurs images par post))
ALTER TABLE publications
DROP COLUMN photo_url;

CREATE TABLE images_publication (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_publication INT,
    photo_url VARCHAR(255),
    FOREIGN KEY (id_publication) REFERENCES publications(id_publication)
);


ALTER TABLE images_publication
ADD CONSTRAINT fk_images_publication_publications
FOREIGN KEY (id_publication) REFERENCES publications(id_publication);