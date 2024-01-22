document.addEventListener('DOMContentLoaded', function () {

    var likeButtons = document.querySelectorAll('.icon.like');

    likeButtons.forEach(function (likeButton) {

        likeButton.addEventListener('click', function () {

            var postId = likeButton.getAttribute('data-id');

            $.ajax({
                url: '?action=postLiked',
                type: 'GET',
                data: { post_id: postId },
                success: function (data) {
                    // console.log('Réponse du serveur :', data);

                    likeButton.classList.toggle('active');

                    var likesCount = document.querySelectorAll('.nbLikes');

                    likesCount.forEach(function (likes) {
                        if (likes.getAttribute('data-id') == postId) {
                            if (likeButton.classList.contains('active')) {
                                likes.innerText = parseInt(likes.innerText) + 1;
                            } else {
                                likes.innerText = parseInt(likes.innerText) - 1;
                            }
                        }
                    });

                    var imageSrc = likeButton.querySelector('img').src;
                    var newImageSrc = imageSrc.includes('_red') ? imageSrc.replace('_red', '') : imageSrc.replace('.png', '_red.png');
                    likeButton.querySelector('img').src = newImageSrc;

                },
                error: function (xhr, status, error) {
                    console.error('Erreur AJAX:', status, error);
                }
            });
        });
    });
});
