$(document).ready(function(){
	$("#getContact").on("click", function(){
		var request = $.ajax({
			url: "addressbook/contact",
		  	method: "POST",
		  	dataType: "html",
		  	beforeSend: function( xhr ) {
				$("#dinamic-content").fadeOut('fast');
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

function detail(title_modal, id_contacto){
	$("#myModalLabel").html(title_modal);

	var request = $.ajax({
		url: "addressbook/detail",
	  	method: "POST",
	  	data: { contacto : id_contacto },
	  	dataType: "html",
	  	beforeSend: function( xhr ) {
			$(".modal-body").find(".row").html("");
		}
	});

	request.done(function(result) {
		$(".modal-body").find(".row").append(result);
	});

	request.fail(function(jqXHR, textStatus) {
	  	alert("Request failed: " + textStatus);
	});
}