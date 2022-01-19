$("#course").select2({
	placeholder: "Seleccione un curso",
	ajax: {
		url: "/docente/search_course",
		dataType: "json",
		delay: 250,
		data: function (data) {
			return {
				searchTerm: data.term, // search term
			};
		},
		processResults: function (response) {
			return {
				results: response,
			};
		},
		cache: true,
	},
});

$("#user").select2({
	placeholder: "Seleccione usuario",
	ajax: {
		url: "/docente/search_user",
		dataType: "json",
		delay: 250,
		data: function (data) {
			return {
				searchTerm: data.term, // search term
			};
		},
		processResults: function (response) {
			return {
				results: response,
			};
		},
		cache: true,
	},
});

$("#frm-guardar-docente-curso").on("submit", function (e) {
	e.preventDefault();
	e.stopPropagation();

	$.ajax({
		url: "/docente/guardar_docente",
		type: "POST",
		data: $("#frm-guardar-docente-curso").serialize(),
	}).done(function (response) {
		if (typeof response.exito != "undefined") {
			Swal.fire({
				html: response.exito,
				title: "Éxito!!!",
				icon: "info",
				showCancelButton: false,
				confirmButtonText: "Ok",
			});
		}

		if (typeof response.error != "undefined") {
			Swal.fire({
				html: response.error,
				title: "Error!!!",
				icon: "error",
				showCancelButton: false,
				confirmButtonText: "Ok",
			});
		}

		$("#user").val(null).trigger("change");
		$("#course").val(null).trigger("change");
	});
});
