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

	$("#addContact").on("click", function(){
		var request = $.ajax({
			url: "addressbook/add",
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

function update(id_contact){
	var request = $.ajax({
		url: "addressbook/update",
	  	method: "POST",
	  	data: { id_contacto : id_contact },
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
}

function add_telephone(){
	var html_email = '<div class="col-xs-4">';
		html_email += 	'Lada: <input type="text" maxlength="3" class="form-control lada" placeholder="Lada">';
		html_email += '</div>';
		html_email += '<div class="col-xs-8">';
		html_email += 	'Teléfono: <input type="text" maxlength="12" class="form-control numero" placeholder="Teléfono">';
		html_email += '</div>';

	$(html_email).insertBefore("#add-telephone");
}

function validate_form(form, e){
	e.preventDefault();
	$(form).find(".error-message").fadeOut("fast");
	$("#correo").next().find("span").html("Campo requerido")

	var field_required = $(form).find(".required");
	var valid_empty = validate_empty(field_required);

	var valid_email = validate_email($("#correo"));

	if(valid_empty && valid_email){
		var contact_id = $(form).attr("id");
		var contact = contact_id.split("_");
		var id_contact = contact[1];

		var formdata = $(form).serializeArray();
		var data_f = {};
		$(formdata).each(function(index, obj){
		    data_f[obj.name] = obj.value;
		});

		var array_phone = create_object_phone($(form));
		var data_phone = {};
		var count_p = 0;

		$(array_phone).each(function(index_f, obj_t){
			data_phone[count_p] = new Object;
		    data_phone[count_p].lada = obj_t.lada;
		    data_phone[count_p].numero = obj_t.numero;
		    count_p++;
		});

		var request = $.ajax({
			url: $(form).attr("action"),
		  	method: $(form).attr("method"),
		  	data: { id_contacto : id_contact,
		  			form_data : data_f,
		  			telephone : data_phone },
		  	dataType: "json",
		  	beforeSend: function( xhr ) {
				//$("#dinamic-content").fadeOut('fast');
			}
		});

		request.done(function(result) {console.log(result);
			if(result.respuesta == "t"){
				$("#dinamic-content").fadeOut('fast');
				$("#dinamic-content").html("<h1>Se ingresaron correctamente los datos del contacto.</h1>").fadeIn('slow');
			}else{
				alert("Existio un error al guardar los datos, intentenlo de nuevo.");
			}
		});

		request.fail(function(jqXHR, textStatus) {
		  	alert("Request failed: " + textStatus);
		});
	}
}

function validate_empty(fields){
	var valid = true;
	var count_fields = fields.find("input").length;
	
	for (var i = 0; i < count_fields; i++) {
		field_current = $(fields).eq(i);
		input_value = field_current.find("input").val();
		if(input_value.trim() == ""){
			field_current.find(".error-message").fadeIn("slow");
			valid = false;
		}
	}

	return valid;
}

function validate_email(input){
	var email_value = input.val();
	var valid_email = true;
	expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!expr.test(email_value)){
        input.val("").parent().find(".error-message").fadeIn("slow").find("span").html("Introduzca una direccion correcta de email (Ej. ejemplo@gmail.com)");
		valid_email = false;
    }

    return valid_email;
}

function create_object_phone(form){
	var div_phone = form.find("#telefonos");
	var count_phone = div_phone.find(".lada").length;
	var phones = new Array();
	var count_t = 0;

	for (var i = 0; i < count_phone; i++) {
		lada_value = div_phone.find(".lada").eq(i).val();
		number_value = div_phone.find(".numero").eq(i).val();

		if(lada_value.trim() != "" && number_value.trim() != ""){
			phones[count_t] = new Object();
			phones[count_t].lada = lada_value.trim();
			phones[count_t].numero = number_value.trim();
			count_t++;
		}
	}

	return phones;
}