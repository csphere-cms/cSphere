// Wait for the document to be ready
jQuery(document).ready(function() {
	
	// hide the sqlite part
	$(".sqlite").hide();
	
	$("#inputDatabaseDriver").change( function(){
		if($("#inputDatabaseDriver").val() == "pdo_sqlite"){
			$(".others").hide();
			$(".sqlite").show();
		} else {
			$(".others").show();
			$(".sqlite").hide();
		}
	});
});