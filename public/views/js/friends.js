document.addEventListener('DOMContentLoaded', function() {
    var acceptButtons = document.querySelectorAll('.accept-request');
    var declineButtons = document.querySelectorAll('.decline-request');
    var btns = document.querySelectorAll('.request-btn-row');

    acceptButtons.forEach(function(button) {
        button.addEventListener('click', addFriend);
    });

    declineButtons.forEach(function(button) {
        button.addEventListener('click', declineFriend);
    });

    function addFriend() {
        btns.forEach(function(btn) {
            btn.classList.add('disappear');
        });
        var text = this.closest('.friend-box').querySelector('.user-name-box');
        text.innerHTML = "a bien été ajouté !";

        
    }

    function declineFriend() {
        btns.forEach(function(btn) {
            btn.classList.add('disappear');
        });
        var text = this.closest('.friend-box').querySelector('.user-name-box');
        text.innerHTML = "a été refusé !";
    }
});





