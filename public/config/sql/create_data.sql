INSERT INTO publications (id_utilisateur, titre, texte, visibilite, date_publication)
VALUES 
(
    (SELECT id_utilisateur FROM utilisateurs WHERE nom = 'Outili' AND prenom = 'Rayan'), 
    "John wick c\'est vraiment trop bien !!!", 
    'test', 
    'public', 
    NOW() -- INTERVAL 6 DAY
);

INSERT INTO administrateurs (id_utilisateur)
VALUES 
(
    (SELECT id_utilisateur FROM utilisateurs WHERE adresse_mail = 'rayan.outili@gmail.com'), 
    
);

-- thomas me demande en amis
INSERT INTO amis (id_utilisateur_demandeur, id_utilisateur_receveur)
VALUES 
(
    (SELECT id_utilisateur FROM utilisateurs WHERE nom = 'Portelette' AND prenom = 'Thomas'), 
    (SELECT id_utilisateur FROM utilisateurs WHERE nom = 'Outili' AND prenom = 'Rayan')
);
