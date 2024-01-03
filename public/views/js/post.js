document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').addEventListener('input', updatePreview);

    function updatePreview() {
        document.getElementById('preview-title').innerText = document.querySelector('[name="post_title"]').value;
        document.getElementById('preview-text').innerText = document.querySelector('[name="post_text"]').value;

        var imagesPreview = document.getElementById('preview-images');
        imagesPreview.innerHTML = '';

        var inputImages = document.querySelector('[name="post_images"]');
        for (var i = 0; i < inputImages.files.length; i++) {
            var img = document.createElement('img');
            img.src = URL.createObjectURL(inputImages.files[i]);
            img.className = 'preview-image';
            imagesPreview.appendChild(img);
        }

        // Ajoute la visibilité à l'aperçu
        document.getElementById('preview-visibility').innerText = 'Visibilité : ' + document.querySelector('[name="post_visibility"]').value;
    }
});