$(function() {
    var head = 0;
    var loading = false;

    init();

    function init() {
        head = 0;
        root = $('#blogs-list').empty();
        loadBlogs();
    }

    function loadBlogs() {
        if (loading) {
            return;
        }
        loading = true;

        $.getJSON('/apis/blogs', {start:head, needle:$('#needle').val()}, function(json) {
            var root = $('#blogs-list');
            $.each(json, function() {
                root.append(
                    '<div class="list-group-item">'
                        + '<h6 class="list-group-item-heading">' + this.blog_name + '</h6>'
                        + '<p class="list-group-item-text text-right">' + this.updated_at + '</p>'
                    + '</div>'
                );
            });
            head += 20;
            loading = false;
        });
    };

    $('#next-button').click(postRssUrl);
});
