$(document).ready(function () {
    var postContainer = $(".post-container");

    function loadPosts(page) {
        $.ajax({
            url: "get_posts.php",
            method: "GET",
            data: {
                page: page
            },
            success: function (data) {
                postContainer.html(data);
            }
        });
    }

    $(".pagination-link").on("click", function (e) {
        e.preventDefault();
        var page = $(this).attr("href").split("=")[1];
        loadPosts(page);

        history.pushState(null, null, `?page=${page}`);
    });
});
