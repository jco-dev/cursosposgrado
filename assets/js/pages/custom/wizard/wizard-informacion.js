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
								message: "El CI debe puede tener hasta 11 dígitos",
							},
						},
					},
					paterno: {
						validators: {
							regexp: {
								regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i,
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
	$("#ciudad_residencia").select2({
		placeholder: "Elige",
	});

	$("#expedido").select2({
		placeholder: "Elige",
		minimumResultsForSearch: Infinity,
	});

	$("#profesion_oficio").select2({
		placeholder: "Elige",
	});

	KTWizard3.init();

	$("#frm_curso_informacion").submit(function (e) {
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
				Swal.fire({
					title: response.exito,
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

				$("#profesion_oficio")
					.val(response.datos[0].id_profesion_oficio)
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
		console.log($(this).val());
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

	$("#profesion_oficio").on("change", function () {
		$("#m_profesion_oficio").html($("#profesion_oficio :selected").text());
	});
});
