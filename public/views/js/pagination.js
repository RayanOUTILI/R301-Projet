// document.addEventListener('DOMContentLoaded', function () {

//     function loadPage(page) {
//         $.ajax({
//             url: '?action=page',
//             type: 'GET',
//             data: { page: page },
//             success: function (data) {
//                 // console.log('Réponse du serveur :', data);
//                 $('#content').html(data);
//             },
//             error: function (xhr, status, error) {
//                 console.error('Erreur AJAX:', status, error);
//             }
//         });
//     }

//     $('.pagination-link').on('click', function (e) {
//         e.preventDefault();
//         console.log('click');

//         var page = $(this).attr('href').split('=')[1];

//         console.log(page);

//         loadPage(page);
//     });

// });