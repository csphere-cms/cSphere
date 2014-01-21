// Wait for the document to be ready
jQuery(document).ready(function() {

    // Hide smtp settings by default
    $(".cache_redis").hide();

    // Change visible input fields depending on selected driver
    $(window).on("load change", function() {

        var type = $("#cache_driver").val();

        if (type == "redis") {

            $(".cache_redis").show();

        } else {

            $(".cache_redis").hide();
        }
    });
});