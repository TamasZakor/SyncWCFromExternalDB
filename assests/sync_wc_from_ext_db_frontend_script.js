var $ = jQuery.noConflict();

$(document).ready(function() {
    var pathname = window.location.pathname;
    var res = pathname.split("/");
    if (res[res.length - 3] == "product") {
        product_id = $('a#refresh_product').attr("data-product_id");
        var data = {
            'action': 'sync_wc_from_ext_db_ajax_call',
            'product_id': product_id
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: sync_wc_from_ext_db_ajax_object.ajax_url,
            data: data,
            success: function(response) {
                if ($('p.stock.in-stock').length) {
                    $("p.stock.in-stock")[0].innerHTML = response['stock_quantity'] + "    in stock";
                }
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    }
});