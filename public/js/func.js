$(document).ready(function(){
	$("#getContact").on("click", function(){
		var request = $.ajax({
			url: "addressbook/contact",
		  	method: "POST",
		  	//data: { id : menuId },
		  	dataType: "html",
		  	beforeSend: function( xhr ) {
				$("#dinamic-content").fadeOut('slow');
			}
		});

		request.done(function(result) {
		  $("#dinamic-content").html(result).fadeIn('slow');
		});

		request.fail(function(jqXHR, textStatus) {
		  alert("Request failed: " + textStatus);
		});
	});
});