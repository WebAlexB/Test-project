jQuery(document).ready(function ($) {
    let building_floor = '';
    let building_type = '';
    $("#floor").change(function () {
        building_floor = $(this).val()
    });
    $("#type").click(function () {
        building_type = $(this).val()
    });
    $("#filter-submit").click(function () {
        jQuery.ajax({
            url: filter_form.url,
            type: 'post',
            data: {
                action: "filter_form",
                building_floor: building_floor,
                building_type: building_type
            },
            success: function (data) {
                jQuery(".response").html(data);
                $(".blog-grid").hide();
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
    });
});



