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
						text:
							"Lo sentimos, parece que se han detectado algunos errores. Vuelve a intentarlo.",
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
			alert("Validating ...");
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
						},
					},
					celular: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
							integer: {
								message: "El número celular no es válido",
								// The default separators
								thousandsSeparator: "",
								decimalSeparator: ".",
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

	KTWizard3.init();

	$("#frm_curso_inscripcion").submit(function (e) {
		e.preventDefault();
		if (!$("input:radio[name=tipo_certificado_solicitado]").is(":checked")) {
			Swal.fire("Advertencia!", "Elija el tipo de certificado", "warning");
		} else {
			let data = new FormData($(this)[0]);
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
					Swal.fire("Exito!", response.exito, "success");
				}
				if (typeof response.error != "undefined") {
					Swal.fire("Error!", response.error, "error");
				}
				if (typeof response.warning != "undefined") {
					Swal.fire("Advertencia!", response.warning, "info");
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
				$("#nombre").val(response.datos[0].nombre);
				$("#paterno").val(response.datos[0].paterno);
				$("#materno").val(response.datos[0].materno);
				$("#genero").val(response.datos[0].genero);
				$("#celular").val(response.datos[0].celular);
				$("#fecha_nacimiento").val(response.datos[0].fecha_nacimiento);
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
});
