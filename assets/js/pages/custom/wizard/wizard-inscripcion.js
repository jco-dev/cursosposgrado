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
						text: "Lo sentimos, parece que se han detectado algunos errores. Vuelve a intentarlo.",
						icon: "error",
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
					ci: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
							stringLength: {
								max: 11,
								message: "El CI puede tener hasta 11 dígitos",
							},
						},
					},
					paterno: {
						validators: {
							regexp: {
								regexp: /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/i,
								message:
									"El apellido paterno puede constar de caracteres alfabéticos y solo espacios",
							},
						},
					},
					materno: {
						validators: {
							regexp: {
								regexp: /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/i,
								message:
									"El apellidos materno puede constar de caracteres alfabéticos y solo espacios",
							},
						},
					},
					correo: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
							emailAddress: {
								message: "Debe ser un correo válido",
							},
						},
					},
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
					ciudad_residencia: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
				},
			}).on()
		);

		// Step 2
		_validations.push(
			FormValidation.formValidation(_formEl, {
				fields: {
					modalidad_inscripcion: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					id_transaccion: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					respaldo_transaccion: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					fecha_pago: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					monto_pago: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
							between: {
								min: 100,
								max: 1000,
								message: "El monto de pago debe estar entre 100 y 1000",
							},
						},
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
				},
			})
		);

		// Step 3
		_validations.push(
			FormValidation.formValidation(_formEl, {
				fields: {
					tipo_certificado_solicitado: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
				},
			})
		);
	};

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById("kt_wizard_v3");
			_formEl = KTUtil.getById("frm_curso_inscripcion");

			initWizard();
			initValidation();
		},
	};
})();

jQuery(document).ready(function () {
	$("#ciudad_residencia").select2({
		placeholder: "Elige",
	});

	$("#expedido").select2({
		placeholder: "Elige",
		minimumResultsForSearch: Infinity,
	});

	$("#respaldo_transaccion").on("change", function () {
		var imagen = this.files[0];
		// se valida el formato de la imagen png y jpeg
		if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
			$("#respaldo_transaccion").val("");
			Swal.fire(
				"Error!",
				"¡La imagen debe estar en formato JPG o PNG!",
				"error"
			);
		} else if (imagen["size"] > 2000000) {
			$("#respaldo_transaccion").val("");
			Swal.fire("error", "La imagen no debe pesar más de 2MB!", "error");
		} else {
			var datosImagen = new FileReader();
			datosImagen.readAsDataURL(imagen);

			$(datosImagen).on("load", function (event) {
				var rutaImagen = event.target.result;
				$("#img-preview").attr("src", rutaImagen);
				$("a.image-popup-no-margins").attr("href", rutaImagen);
			});
		}
		//ocultar la imagen y visualiar
		if ($(this).val() != "") {
			$("a.image-popup-no-margins").removeClass("d-none");
		} else {
			$("a.image-popup-no-margins").addClass("d-none");
		}
	});

	$(".image-popup-no-margins").magnificPopup({
		type: "image",
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: "mfp-no-margins mfp-with-zoom", // class to remove default margin from left and right side
		image: {
			verticalFit: true,
		},
		zoom: {
			enabled: true, // don't foget to change the duration also in CSS
		},
	});

	KTWizard3.init();

	$("#frm_curso_inscripcion").submit(function (e) {
		e.preventDefault();
		if (!$("input:radio[name=tipo_certificado_solicitado]").is(":checked")) {
			Swal.fire("Advertencia!", "Elija el tipo de certificado", "warning");
		} else {
			Swal.fire({
				text: "Si todo esta bien! Por favor confirme sus datos para enviar.",
				icon: "success",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Si, enviar!",
				cancelButtonText: "No, cancelar",
				customClass: {
					confirmButton: "btn font-weight-bold btn-primary",
					cancelButton: "btn font-weight-bold btn-default",
				},
			}).then(function (result) {
				if (result.value) {
					let data = new FormData($("#frm_curso_inscripcion")[0]);
					$.ajax({
						type: "POST",
						url: "/inscripcion/guardar_preinscripcion",
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "JSON",
					}).done(function (response) {
						if (typeof response.exito != "undefined") {
							Swal.fire({
								title: response.exito,
								text: "¡Gracias por inscribirse al curso!",
								icon: "success",
								showCancelButton: false,
								confirmButtonText: "Ok",
							}).then(function (result) {
								if (result.value) {
									location.reload();
								}
							});
						}
						if (typeof response.error != "undefined") {
							Swal.fire({
								title: response.error,
								icon: "error",
								showCancelButton: false,
								confirmButtonText: "Ok",
							}).then(function (result) {
								if (result.value) {
									location.reload();
								}
							});
						}
						if (typeof response.warning != "undefined") {
							Swal.fire({
								title: response.warning,
								icon: "info",
								showCancelButton: false,
								confirmButtonText: "Ok",
							}).then(function (result) {
								if (result.value) {
									location.reload();
								}
							});
						}
					});
				} else if (result.dismiss === "cancel") {
					Swal.fire({
						text: "Tus datos no han sido enviado!.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok",
						customClass: {
							confirmButton: "btn font-weight-bold btn-primary",
						},
					});
				}
			});
		}
	});

	// traer datos
	$("#ci").on("change", function (e) {
		let ci = $(this).val();
		$.post("/inscripcion/buscar_por_ci", { ci: ci }, function (response) {
			if (typeof response.datos != "undefined") {
				//poner datos
				$("#expedido").val(response.datos[0].expedido).trigger("change");

				$("#correo").val(response.datos[0].correo);
				$("#m_correo").text(response.datos[0].correo);

				$("#nombre").val(response.datos[0].nombre);
				$("#m_nombre").text(response.datos[0].nombre);

				$("#paterno").val(response.datos[0].paterno);
				$("#m_paterno").text(response.datos[0].paterno);

				$("#materno").val(response.datos[0].materno);
				$("#m_materno").text(response.datos[0].materno);

				$("input[name=genero][value='" + response.datos[0].genero + "']").prop(
					"checked",
					true
				);
				$("#m_genero").text(response.datos[0].genero);

				$("#celular").val(response.datos[0].celular);
				$("#m_celular").text(response.datos[0].celular);

				$("#fecha_nacimiento").val(response.datos[0].fecha_nacimiento);
				$("#m_fecha_nacimiento").text(response.datos[0].fecha_nacimiento);

				$("#ciudad_residencia")
					.val(response.datos[0].id_municipio)
					.trigger("change");

				$("input[name=genero][value=" + response.datos[0].genero + "]").attr(
					"checked",
					"checked"
				);
			}
		});
	});

	// mostrar datos ingresados en el paso final
	$("#ci").on("change", function () {
		$("#m_ci").html($(this).val());
	});

	$("#expedido").on("change", function () {
		$("#m_expedido").html($(this).val());
	});

	$("#correo").on("change", function () {
		$("#m_correo").text($(this).val());
	});

	$("#nombre").on("change", function () {
		$("#m_nombre").text($(this).val());
	});

	$("#paterno").on("change", function () {
		$("#m_paterno").text($(this).val());
	});

	$("#materno").on("change", function () {
		$("#m_materno").text($(this).val());
	});

	$('input[name=genero][type="radio"]').on("change", function () {
		$("#m_genero").text($(this).val());
	});

	$("#fecha_nacimiento").on("change", function () {
		$("#m_fecha_nacimiento").html($(this).val());
	});

	$("#celular").on("change", function () {
		$("#m_celular").html($(this).val());
	});

	$("#ciudad_residencia").on("change", function () {
		$("#m_ciudad_residencia").html($("#ciudad_residencia :selected").text());
	});

	// MOSTRAR DATOS INGRASADOS PASO 2
	$('input[name=modalidad_inscripcion][type="radio"]').on(
		"change",
		function () {
			$("#m_modalidad_inscripcion").text($(this).val());
		}
	);

	$("#id_transaccion").on("change", function () {
		$("#m_id_transaccion").html($(this).val());
	});

	$("#fecha_pago").on("change", function () {
		$("#m_fecha_pago").html($(this).val());
	});

	$("#monto_pago").on("change", function () {
		$("#m_monto_pago").html("Bs. " + $(this).val());
	});

	// para el paso 3
	$('input[name=tipo_certificado_solicitado][type="radio"]').on(
		"change",
		function () {
			$("#m_tipo_certificado_solicitado").text($(this).val());
		}
	);
});
