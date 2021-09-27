"use strict";

// Class definition
var KTWizard3 = (function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _validations = [];

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true, // allow step clicking
		});

		// Validation before going to next page
		_wizard.on("beforeNext", function (wizard) {
			// Don't go to the next step yet
			_wizard.stop();

			// Validate form
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
			validator.validate().then(function (status) {
				if (status == "Valid") {
					_wizard.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Por favor, llene los campos obligatorios.",
						icon: "warning",
						buttonsStyling: false,
						confirmButtonText: "Ok",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light",
						},
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Change event
		_wizard.on("change", function (wizard) {
			KTUtil.scrollTop();
		});

		_wizard.on("core.form.validating", function () {
			// alert("Validating ...");
		});
	};

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(
			FormValidation.formValidation(_formEl, {
				fields: {
					// ci: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: "Esta pregunta es obligatoria",
					// 		},
					// 		stringLength: {
					// 			max: 11,
					// 			message: "El CI debe puede tener hasta 11 dígitos",
					// 		},
					// 	},
					// },
					// paterno: {
					// 	validators: {
					// 		regexp: {
					// 			regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i,
					// 			message:
					// 				"El apellido paterno puede constar de caracteres alfabéticos y solo espacios",
					// 		},
					// 	},
					// },
					// materno: {
					// 	validators: {
					// 		regexp: {
					// 			regexp: /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/i,
					// 			message:
					// 				"El apellidos materno puede constar de caracteres alfabéticos y solo espacios",
					// 		},
					// 	},
					// },
					// correo: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: "Esta pregunta es obligatoria",
					// 		},
					// 		emailAddress: {
					// 			message: "Debe ser un correo válido",
					// 		},
					// 	},
					// },
					nombre: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
							regexp: {
								regexp: /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/i,
								message:
									"El nombre puede constar de caracteres alfabéticos y solo espacios",
							},
						},
					},
					celular: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
							regexp: {
								regexp: /^(7|6)?[0-9]{7}$/i,
								message: "El número de celular debe empezar por 6 o 7",
							},
							integer: {
								message: "El número de celular no es válido",
							},
							stringLength: {
								max: 8,
								min: 8,
								message: "El número de celular debe tener 8 dígitos",
							},
						},
					},
					// ciudad_residencia: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: "Esta pregunta es obligatoria",
					// 		},
					// 	},
					// },
					// anio: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: "Esta pregunta es obligatoria",
					// 		},
					// 	},
					// },
					// mes: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: "Esta pregunta es obligatoria",
					// 		},
					// 	},
					// },
					// dia: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: "Esta pregunta es obligatoria",
					// 		},
					// 	},
					// },
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
				},
			}).on()
		);
	};

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById("kt_wizard_v3");
			_formEl = KTUtil.getById("frm_curso_informacion");

			initWizard();
			initValidation();
		},
	};
})();

jQuery(document).ready(function () {
	$("#celular").on("change", function (e) {
		$.ajax({
			url: "/informacion/buscar_contacto",
			type: "POST",
			data: {
				celular: $(this).val(),
			},
		}).done(function (response) {
			if (response.length > 0) {
				$("#nombre").val(response[0].nombre);
			}
		});
	});

	$("#frm_curso_informacion").on("submit", function (e) {
		e.preventDefault();
		let data = new FormData($("#frm_curso_informacion")[0]);
		$.ajax({
			type: "POST",
			url: "/informacion/guardar_informacion",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
		}).done(function (response) {
			if (typeof response.exito != "undefined") {
				limpiarCampos();
				window.open(
					`https://api.whatsapp.com/send?phone=+591${
						response.celular
					}&text=${encodeURI(`${response.exito[0].mensaje_whatsapp}`)}`,
					"_blank"
				);
			}
			// if (typeof response.error != "undefined") {
			// 	Swal.fire({
			// 		title: response.error,
			// 		icon: "error",
			// 		showCancelButton: false,
			// 		confirmButtonText: "Ok",
			// 	}).then(function (result) {
			// 		if (result.value) {
			// 			location.reload();
			// 		}
			// 	});
			// }
			if (typeof response.warning != "undefined") {
				Swal.fire({
					html: response.warning,
					title: "Advertencia !!!",
					icon: "info",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
			}
		});
	});

	const limpiarCampos = () => {
		$("#nombre").val("");
		$("#celular").val("");
	};

	function format_dia(dia) {
		if (dia >= 1 && dia <= 9) {
			return "0" + dia;
		} else {
			return dia;
		}
	}

	// Envio de información por whatsapp
	// $("#enviar-whatsapp-informacion").on("click", function (e) {
	// 	let id = $(this).attr("data-curso");
	// 	if (/^\d{8}$/.test($("#celular").val())) {
	// 		$.post("/informacion/informacion_curso", { id }, function (response) {
	// 			if (typeof response.exito != "undefined") {
	// 				console.log(response);
	// 				window.open(
	// 					`https://api.whatsapp.com/send?phone=+591${$(
	// 						"#celular"
	// 					).val()}&text=${encodeURI(
	// 						`${response.exito[0].mensaje_whatsapp}`
	// 					)}`,
	// 					"_blank"
	// 				);
	// 			} else {
	// 				Swal.fire({
	// 					title: "Error al enviar la información del curso",
	// 					icon: "error",
	// 					showCancelButton: false,
	// 					confirmButtonText: "Ok",
	// 				});
	// 			}
	// 		});
	// 	} else {
	// 		Swal.fire({
	// 			title: "El número de celular ingresado es inválido",
	// 			icon: "error",
	// 			showCancelButton: false,
	// 			confirmButtonText: "Ok",
	// 		});
	// 	}
	// });

	KTWizard3.init();
});
