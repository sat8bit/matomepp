$(function() {

    var head = 20;
    var loading = false;

    function loadArticles() {
        if (loading) {
            return;
        }
        loading = true;

        $.getJSON('/apis/articles', {start:head, needle:$('#needle').val()}, function(json) {
            var root = $('#articles-list');
            $.each(json, function() {
                root.append(
                    '<a href="' + this.url + '" class="list-group-item">'
                        + '<h6 class="list-group-item-heading">' + this.title + '</h6>'
                        + '<p class="list-group-item-text text-right">' + this.blog_name + '</p>'
                    + '</a>'
                );
            });
            head += 20;
            loading = false;
        });
    };

    $('#next-button').click(loadArticles);
});
