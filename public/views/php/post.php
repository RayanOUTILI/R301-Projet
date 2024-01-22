<!DOCTYPE html>
<html lang="fr">
<?php

session_start();
?>
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

    <div class="post-container">
        <form action="index.php?action=publish" method="post" enctype="multipart/form-data">
            <label for="post_title">Titre</label>
            <input type="text" name="post_title" required>

            <label for="post_text">Texte</label>
            <textarea name="post_text" required></textarea>

            <label for="post_images">Images (maintenez Ctrl pour sélectionner plusieurs):</label>
            <input type="file" name="post_images[]" id="post_images" multiple>
            <label id="error" for="error" style="display: none;">Votre fichier dépasse la limite de 1Mo</label>


            <label for="post_visibility">Visibilité:</label>
            <select name="post_visibility">
                <option value="amis">Amis seulement</option>
                <option value="public">Public</option>
            </select>

            <button type="submit" name="submit_post" id="submit_post">Publier</button>
        </form>

        <div class="preview-container" id="post-preview">
            <h2>Aperçu du Post</h2>
            <p id="preview-title"></p>
            <p id="preview-text"></p>
            <div id="preview-images"></div>
        </div>
    </div>
</body>

</html>