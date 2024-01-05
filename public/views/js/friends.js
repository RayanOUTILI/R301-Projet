$(document).ready(function () {

    $('.friend-requests').on('click', '.friend-request', function () {
        var $elem = $(this);
        var username = $elem.attr('data-username');
        var type = $elem.hasClass('accept-request');
        console.log(username);

        var $rBtnrow = $('.request-btn-row[data-username="' + username + '"]');
        $rBtnrow.addClass('disappear');

        var message;
        if (type) {
            message = makeHTMLElement('div', 'fr-request-pending accepted', 'Demande d\'amis acceptée.');
            
        } else {
            message = makeHTMLElement('div', 'fr-request-pending declined', 'Demande d\'amis refusée.');
        }

        $rBtnrow.empty().append(message);
    });




});
