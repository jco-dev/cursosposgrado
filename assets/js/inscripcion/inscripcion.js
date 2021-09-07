"use strict";
let _wizard;
// Class definition
var KTinscripcion_local = (function () {
	// Base elements
	var _wizardEl;
	var _formEl;
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
					id: {
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
					// respaldo_transaccion: {
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
			_wizardEl = KTUtil.getById("kt_wizard_inscripcion_local");
			_formEl = KTUtil.getById("frm_curso_inscripcion_local");

			initWizard();
			initValidation();
		},
	};
})();

jQuery(document).ready(function () {
	// Fecha de nacimiento
	$("#anio2").select2({
		placeholder: "Año",
	});
	$("#anio2").change(function () {
		$("#mes2").removeAttr("disabled");
	});

	$("#mes2").select2({
		placeholder: "Mes",
	});
	$("#mes2").prop("disabled", "disabled");
	$("#mes2").change(function () {
		$("#dia2").removeAttr("disabled");
	});

	$("#dia2").select2({
		placeholder: "Dia",
	});
	$("#dia2").prop("disabled", "disabled");

	$("#fecha2").on("change", "#anio2,#mes2", function (e) {
		let anio = parseInt($("#anio2").val());
		let mes = parseInt($("#mes2").val()) - 1;
		let res = Date.getDaysInMonth(anio, mes);
		llenar_dia(res);
	});

	const llenar_dia = (num) => {
		$("#dia2").children().remove();
		let opcion = "";
		for (let i = 1; i <= num; i++) {
			opcion += "<option value='" + i + "'>" + i + "</option>";
		}
		$("#dia2").append(opcion);
	};

	$("#card-title-inscripcion").addClass("d-none");

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

	$("#ciudad_residencia").select2({
		placeholder: "Elige",
	});

	$("#expedido").select2({
		placeholder: "Elige",
		minimumResultsForSearch: Infinity,
	});

	$("#frm_curso_inscripcion_local").on("submit", function (e) {
		// console.log("inscripcion");
		e.preventDefault();
		if (!$("input:radio[name=tipo_certificado_solicitado]").is(":checked")) {
			Swal.fire("Advertencia!", "Elija el tipo de certificado", "warning");
		} else {
			let data = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "/inscripcionadmin/guardar_preinscripcion",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "JSON",
			}).done(function (response) {
				if (typeof response.exito != "undefined") {
					window.open("/inscripcionadmin/imprimir/" + response.id, "_blank");
					Swal.fire({
						title: response.exito,
						text: "¡Gracias por inscribirse!",
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
		}
	});

	// traer datos
	$("#ci").on("change", function (e) {
		let ci = $(this).val();
		$.post("/inscripcionadmin/buscar_por_ci", { ci: ci }, function (response) {
			if (typeof response.datos != "undefined") {
				//poner datos
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

				$("#genero").val(response.datos[0].genero);
				$("#m_genero").text(response.datos[0].genero);

				$("#celular").val(response.datos[0].celular);
				$("#m_celular").text(response.datos[0].celular);

				if (response.datos[0].fecha_nacimiento != "") {
					let fecha = response.datos[0].fecha_nacimiento.split("-");
					$("#anio2").val(fecha[0]).trigger("change");
					$("#mes2").val(fecha[1]).trigger("change");
					$("#dia2").val(parseInt(fecha[2])).trigger("change");
				}

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

	$("#fecha2").on("change", "#anio2,#mes2, #dia2", function (e) {
		let anio = $("#anio2").val();
		let mes = $("#mes2").val();
		let dia = $("#dia2").val();
		$("#m_fecha_nacimiento").html(anio + "-" + mes + "-" + format_dia(dia));
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

	$("#id_transaccion1").on("change", function () {
		$("#m_id_transaccion2").html($(this).val());
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

	function format_dia(dia) {
		if (dia >= 1 && dia <= 9) {
			return "0" + dia;
		} else {
			return dia;
		}
	}

	// VERIFICAR MODALIDAD DE INSCRIPCION
	$("input[type=radio][name=modalidad_inscripcion]").change(function () {
		if (this.value == "PAGO EFECTIVO") {
			// Verificar el numero el id de facturacion
			$.ajax({
				url: "/inscripcionadmin/verificar_id_factura",
				type: "POST",
			}).done(function (response) {
				$("#id_transaccion1").val(response);
				$("#m_id_transaccion2").val(response);
			});
		}
	});

	KTinscripcion_local.init();
});
