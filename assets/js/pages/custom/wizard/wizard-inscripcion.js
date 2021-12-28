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
					anio: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					mes: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					dia: {
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
								message: "La imagen de respaldo de pago es obligatoria",
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
								min: 50,
								max: 1000,
								message: "El monto de pago debe estar entre 50 y 1000",
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

	$("#anio1").select2({
		placeholder: "Año",
	});
	$("#anio1").change(function () {
		$("#mes1").removeAttr("disabled");
	});

	$("#mes1").select2({
		placeholder: "Mes",
	});
	$("#mes1").prop("disabled", "disabled");
	$("#mes1").change(function () {
		$("#dia1").removeAttr("disabled");
	});

	$("#dia1").select2({
		placeholder: "Dia",
	});
	$("#dia1").prop("disabled", "disabled");

	$("#fecha").on("change", "#anio1,#mes1", function (e) {
		let anio = parseInt($("#anio1").val());
		let mes = parseInt($("#mes1").val()) - 1;
		let res = Date.getDaysInMonth(anio, mes);
		llenar_dia(res);
	});

	const llenar_dia = (num) => {
		$("#dia1").children().remove();
		let opcion = "";
		for (let i = 1; i <= num; i++) {
			opcion += "<option value='" + i + "'>" + i + "</option>";
		}
		$("#dia1").append(opcion);
	};

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
		} else if (imagen["size"] > 7000000) {
			$("#respaldo_transaccion").val("");
			Swal.fire("error", "La imagen no debe pesar más de 7MB!", "error");
		} else {
			var datosImagen = new FileReader();
			datosImagen.readAsDataURL(imagen);

			$(datosImagen).on("load", function (event) {
				var rutaImagen = event.target.result;
				$("#img-preview").attr("src", rutaImagen);
				$("#img-preview").attr("data-original", rutaImagen);
				// $("a.image-popup-no-margins").attr("href", rutaImagen);
			});
		}
		//ocultar la imagen y visualiar
		if ($(this).val() != "") {
			$(".container").removeClass("d-none");
		} else {
			$(".container").addClass("d-none");
		}
	});

	KTWizard3.init();

	$("#frm_curso_inscripcion").submit(function (e) {
		e.preventDefault();
		if (!$("input:radio[name=tipo_certificado_solicitado]").is(":checked")) {
			Swal.fire("Advertencia!", "Elija el tipo de certificado", "warning");
		} else {
			Swal.fire({
				text: "¿Si todo esta bien?. Por favor confirme sus datos para enviar.",
				icon: "success",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Si, enviar",
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
								icon: "warning",
								showCancelButton: false,
								confirmButtonText: "Ok",
							});
						}

						if (typeof response.info != "undefined") {
							Swal.fire({
								title: response.info,
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
			if (response != "") {
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

					$(
						"input[name=genero][value='" + response.datos[0].genero + "']"
					).prop("checked", true);
					$("#m_genero").text(response.datos[0].genero);

					$("#celular").val(response.datos[0].celular);
					$("#m_celular").text(response.datos[0].celular);

					if (
						response.datos[0].fecha_nacimiento != "" &&
						response.datos[0].fecha_nacimiento != null
					) {
						let fecha = response.datos[0].fecha_nacimiento.split("-");
						$("#anio1").val(fecha[0]).trigger("change");
						$("#mes1").val(fecha[1]).trigger("change");
						$("#dia1").val(parseInt(fecha[2])).trigger("change");
					} else {
						$("#anio1").val("").trigger("change");
						$("#mes1").val("").trigger("change");
						$("#dia1").val("").trigger("change");
					}
					$("#m_fecha_nacimiento").text(response.datos[0].fecha_nacimiento);

					$("#ciudad_residencia")
						.val(response.datos[0].id_municipio)
						.trigger("change");

					$("input[name=genero][value=" + response.datos[0].genero + "]").attr(
						"checked",
						"checked"
					);
				}
			} else {
				$("#frm_curso_inscripcion").trigger("reset");
				$("#ci").focus();
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

	$("#fecha").on("change", "#anio1,#mes1, #dia1", function (e) {
		let anio = $("#anio1").val();
		let mes = $("#mes1").val();
		let dia = $("#dia1").val();
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

	function format_dia(dia) {
		if (dia >= 1 && dia <= 9) {
			return "0" + dia;
		} else {
			return dia;
		}
	}

	// Verificar cupón
	$("#cupon").on("keyup", function (e) {
		e.preventDefault();
		e.stopPropagation();
		if ($(this).val().length >= 4) {
			let cupon = $(this).val();
			let ci = $("#ci").val();
			$.ajax({
				url: "/cupon/verificar_cupon",
				method: "POST",
				data: { numero_cupon: cupon, ci: ci },
				dataType: "json",
				success: function (response) {
					console.log(response);
				},
			});
		}
	});

	$("#ci").on("keyup change", function (e) {
		e.preventDefault();
		e.stopPropagation();
		let ci = $(this).val();

		if (ci.length >= 4) {
			$.post("/cupon/buscar_cupones_usuario", { ci: ci }, function (response) {
				if (response.cupones.length > 0) {
					$("#card-cupon-body").empty();
					$("#card-cupon").show();

					$("#card-cupon-body").append(
						'<label for="monto_pago">Aplicar cupón</label>'
					);
					$("#card-cupon-body").append(
						'<div class="radio-list form-group m-0">'
					);
					response.cupones.forEach((element) => {
						$("#card-cupon-body").append(
							' <label class="radio mb-2 p-2"><input type="radio" name="cupon_participante" id="cupon_participante" value="' +
								element +
								'" /><span style="margin-right: 6px;"></span> ' +
								element +
								"</label>"
						);
					});
					$("#card-cupon-body").append(
						'<label class="radio mb-2 p-2"><input type="radio" name="cupon_participante" id="cupon_participante" value="ninguno" /><span style="margin-right: 6px;"></span>Ninguno</label>'
					);
					$("#card-cupon-body").append("</div>");
				} else {
					$("#card-cupon").hide();
				}
			});
		}
	});

	$("#padding-container").on(
		"change",
		"input[name=cupon_participante][type='radio']",
		function (e) {
			let valor = $(this).val();
			if (valor != "ninguno") {
				let costo_curso = parseInt(getNumbersInString($("#costo_curso").val()));
				let ci = $("#ci").val();
				$.ajax({
					url: "/cupon/porcentaje_cupon",
					method: "POST",
					data: {
						numero_cupon: valor,
						ci: ci,
					},
				}).done(function (response) {
					console.log(response);
				});
			}
		}
	);

	function getNumbersInString(string) {
		var tmp = string.split("");

		var map = tmp.map(function (current) {
			if (!isNaN(parseInt(current))) {
				return current;
			}
		});

		var numbers = map.filter(function (value) {
			return value != undefined;
		});

		return numbers.join("");
	}
});
