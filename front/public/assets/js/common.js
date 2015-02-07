$(function() {
    function toggleNavbarOnSp() {
        if (window.innerWidth < 768) {
            $('#navbar-toggle').click();
        }
    }

    $('#search-form').submit(function(){
        if (!$('#needle').val()) {
            return false;
        }
        $(location).attr("href", "/selection/" + encodeURI($('#needle').val()));
        return false;
    });
});
