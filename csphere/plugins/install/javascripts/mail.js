// Wait for the document to be ready
jQuery(document).ready(function() {

    // Hide smtp settings by default
    $(".mail_smtp").hide();

    // Change visible input fields depending on selected driver
    $(window).on("load change", function() {

        var type = $("#mail_driver").val();

        if (type == "smtp") {

            $(".mail_smtp").show();

        } else {

            $(".mail_smtp").hide();
        }
    });
});
