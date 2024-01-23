<!DOCTYPE html>
<html lang="fr">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="public/views/css/post.css">
        <link rel="stylesheet" href="public/views/css/main.css">
        <link rel="stylesheet" href="public/views/css/nav.css">
        <script src="public/views/js/post.js" defer></script>
        <title>Publier un post</title>
    </head>

<body>
    <?php include_once('nav.php'); ?>

    <h2>Recherche par Tranche de Temps</h2>

    <form action="resultats_recherche.php" method="get">
        <label for="dateDebut">Date de début :</label>
        <input type="datetime-local" id="dateDebut" name="dateDebut" required>

        <label for="dateFin">Date de fin :</label>
        <input type="datetime-local" id="dateFin" name="dateFin" required>

        <button type="submit">Rechercher</button>
    </form>
</body>

</html>