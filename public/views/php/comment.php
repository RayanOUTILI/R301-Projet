<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/views/css/comment.css">
    <link rel="stylesheet" href="public/views/css/main.css">
    <link rel="stylesheet" href="public/views/css/nav.css">
    <title>Commenter un post</title>
</head>

<body>


    <!-- on affiche tous les commentaires  -->
    <div class="comment-container">
        <?php if (empty($comments)): ?>
            <p>Soyez le premier à commenter !</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <!-- on affiche le nom, prenom, la date et le commentaire -->
                <div class="comment">
                    <div class="comment-header">
                        <div class="comment-author">
                            <div class="comment-author-name">
                                <?php echo $comment['nom'] . " " . $comment['prenom'] ?>
                            </div>
                        </div>
                        <div class="comment-date">
                            <?php echo "le : " . $comment['date_appreciation'] ?>
                        </div>
                    </div>
                    <div class="comment-text">
                        <?php echo "a commenté : " . $comment['commentaire'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

</body>

</html>