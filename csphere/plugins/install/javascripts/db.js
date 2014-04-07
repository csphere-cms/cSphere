// Wait for the document to be ready
jQuery(document).ready(function() {

    // Hide filename by default
    $(".sql_filename").hide();

    // Change visible input fields depending on selected driver
    $(window).on("load change", function() {

        var type = $("#database_driver").val();

        if (type == "none") {

            // No additional inputs
            $(".sql_others").hide();
            $(".sql_filename").hide();

        } else if (type == "pdo_sqlite") {

            // SQLite only needs a few inputs
            $(".sql_others").hide();
            $(".sql_filename").show();

        } else if (type == "pdo_sqlsrv") {

            // MS SQL Server can use up to all inputs
            $(".sql_others").show();
            $(".sql_filename").show();

        } else {

            // Default inputs
            $(".sql_others").show();
            $(".sql_filename").hide();
        }
    });
});
