INSERT INTO publications (id_utilisateur, titre, texte, visibilite, date_publication)
VALUES (
    (SELECT id_utilisateur FROM utilisateurs WHERE nom = 'Outili' AND prenom = 'Rayan'), 
    'John wick c\'est vraiment trop bien !!!', 
    'test', 
    'public', 
    NOW() - INTERVAL 6 DAY
);
