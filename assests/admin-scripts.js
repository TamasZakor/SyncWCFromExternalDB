var $ = jQuery.noConflict();

$(document).ready(function() {
    $("button.select_connection").click(function() {
        var id = $(this).attr('id');
        var res = id.split("-");
        $("tr#hidden-" + res[1]).toggle();
    });
});