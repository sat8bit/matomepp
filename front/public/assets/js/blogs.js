$(function() {
    var head = 20;
    var loading = false;

    function loadBlogs() {
        if (loading) {
            return;
        }
        loading = true;

        $.getJSON('/apis/blogs', {start:head, needle:$('#needle').val()}, function(json) {
            var root = $('#blogs-list');
            $.each(json, function() {
                root.append(
                    '<a target="_blank" href="' + this.index_url + '" class="list-group-item">'
                        + '<h6 class="list-group-item-heading">' + this.blog_name + '</h6>'
                        + '<p class="list-group-item-text text-right">' + this.index_url + '</p>'
                    + '</a>'
                );
            });
            head += 20;
            loading = false;
        });
    };

    $('#next-button').click(loadBlogs);
});
