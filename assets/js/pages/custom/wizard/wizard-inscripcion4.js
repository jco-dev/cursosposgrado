"use strict";
$("#ci").focus();
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
					expedido: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
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
					anio1: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					mes1: {
						validators: {
							notEmpty: {
								message: "Esta pregunta es obligatoria",
							},
						},
					},
					dia1: {
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
					id_banco: {
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
					certificacion: {
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
		//disabled button

		e.preventDefault();
		if (!$("input:radio[name=tipo_certificado_solicitado]").is(":checked")) {
			Swal.fire("Advertencia!", "Elija el tipo de certificado", "warning");
		} else {
			Swal.fire({
				text: "¿Si todo esta bién?. Por favor confirme sus datos para enviar.",
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
					$(".submit").prop("disabled", true);
					$(".submit").addClass("spinner spinner-white spinner-left");
					$(".submit").html("<span class='ml-3'>Guardando ...</span>");
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
							$(".submit").prop("disabled", false);
							$(".submit").removeClass("spinner spinner-white spinner-left");
							$(".submit").html("<span class=''>Enviar</span>");
							Swal.fire({
								title: response.exito,
								text: "¡Gracias por inscribirse!",
								icon: "success",
								showCancelButton: false,
								confirmButtonText: "Ok",
							}).then(function (result) {
								if (result.value) {
									location.reload();
									limpiar_formulario();
									$("#frm_curso_inscripcion").trigger("reset");
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
									limpiar_formulario();
									$("#frm_curso_inscripcion").trigger("reset");
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
									limpiar_formulario();
									$("#frm_curso_inscripcion").trigger("reset");
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
	$("#ci").on("keyup change", function (e) {
		let ci = $(this).val();
		if (ci.length >= 4) {
			$.post("/inscripcion/buscar_por_ci", { ci: ci }, function (response) {
				if (response != "") {
					if (typeof response.datos != "undefined") {
						//poner datos
						$("#ci").val(response.datos[0].ci);
						// console.log(response.datos);
						$("#expedido").val(response.datos[0].expedido).trigger("change");

						$("#correo").val(response.datos[0].correo);

						$("#nombre").val(response.datos[0].nombre);

						$("#paterno").val(response.datos[0].paterno);

						$("#materno").val(response.datos[0].materno);

						$(
							"input[name=genero][value='" + response.datos[0].genero + "']"
						).prop("checked", true);

						$("#celular").val(response.datos[0].celular);

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

						$("#ciudad_residencia")
							.val(response.datos[0].id_municipio)
							.trigger("change");

						$(
							"input[name=genero][value=" + response.datos[0].genero + "]"
						).attr("checked", "checked");
					}
				} else {
					limpiar_formulario();
					$("#dia1").val("").trigger("change");
					$("#mes1").val("").trigger("change");
					$("#anio1").val("").trigger("change");
					$("#ciudad_residencia").val("").trigger("change");
					$("#ci").focus();
				}
			});
		}
		verificar_cupones(ci);
		verificar_registro($("#ci").val(), $("#id").val());
	});

	const verificar_registro = (ci, id) => {
		$.post("/inscripcion/verificar_registro", { ci, id }, function (response) {
			if (response.data) {
				Swal.fire({
					title: "Advertencia !!!",
					text: "Ya se encuentra registrado en el Curso.",
					icon: "warning",
					showCancelButton: false,
					confirmButtonText: "OK",
					reverseButtons: true,
				}).then(function (result) {
					if (result.value) {
						$("#ci").val("");
						$("#ci").focus();
						limpiar_formulario();
					}
				});
			}
		});
	};

	const listar_datos_usuario = () => {
		let campos = [];
		$("#frm_curso_inscripcion")
			.find("input, select")
			.each(function () {
				let text = null;
				let fila = [];
				if (this.name == "expedido") {
					text = $('select[name="expedido"] option:selected').text();
					fila.push(this.name);
					fila.push(this.value);
					fila.push(text);

					campos.push(fila);
				} else if (this.name == "ciudad_residencia") {
					text = $('select[name="ciudad_residencia"] option:selected').text();
					fila.push(this.name);
					fila.push(this.value);
					fila.push(text);

					campos.push(fila);
				} else if (this.name == "genero") {
					if ($(this).is(":checked")) {
						// You have a checked radio button here...
						text = $("input[name=genero][type=radio]:checked").val();

						fila.push(this.name);
						fila.push(this.value);
						fila.push(text);

						campos.push(fila);
					}
				} else if (this.name == "cupon_participante") {
					if ($(this).is(":checked")) {
						// You have a checked radio button here...
						text = $(
							"input[name=cupon_participante][type=radio]:checked"
						).val();

						fila.push(this.name);
						fila.push(this.value);
						fila.push(text);

						campos.push(fila);
					}
				} else if (this.name == "modalidad_inscripcion") {
					if ($(this).is(":checked")) {
						// You have a checked radio button here...
						text = $(
							"input[name=modalidad_inscripcion][type=radio]:checked"
						).val();

						fila.push(this.name);
						fila.push(this.value);
						fila.push(text);

						campos.push(fila);
					}
				} else if (this.name == "tipo_certificado_solicitado") {
					if ($(this).is(":checked")) {
						// You have a checked radio button here...
						text = $(
							"input[name=tipo_certificado_solicitado][type=radio]:checked"
						).val();

						fila.push(this.name);
						fila.push(this.value);
						fila.push(text);

						campos.push(fila);
					}
				} else if (this.name == "certificacion") {
					if ($(this).is(":checked")) {
						// You have a checked radio button here...
						text = $("input[name=certificacion][type=radio]:checked").val();

						fila.push(this.name);
						fila.push(this.value);
						fila.push(text);

						campos.push(fila);
					}
				} else {
					fila.push(this.name);
					fila.push(this.value);
					fila.push(text);
					campos.push(fila);
				}

				// console.log(text);
				// return { value: this.value, name: this.name, text: text };
			});

		campos.map((data) => {
			$("#m_" + data[0]).html(data[1]);

			if (data[0] == "ciudad_residencia") {
				$("#m_" + data[0]).text(data[2]);
			}

			if (data[0] == "monto_pago") {
				$("#m_" + data[0]).html(data[1] + " Bs.");
			}

			if (data[0] == "tipo_certificado_solicitado") {
				if (data[1] == "AMBOS") {
					$("#m_" + data[0]).html("DIGITAL Y FÍSICO");
				} else {
					$("#m_" + data[0]).html(data[1]);
				}
			}

			if (data[0] == "certificacion") {
				if (data[1] == "MÓDULOS") {
					$("#m_" + data[0]).html(data[1] + " " + $("#span-modulos").text());
				} else {
					$("#m_" + data[0]).html(data[1]);
				}
			}
		});
	};

	$("#frm_curso_inscripcion").change(function (e) {
		listar_datos_usuario();
	});

	const limpiar_formulario = () => {
		$("#expedido").val("").trigger("change");
		$("#correo").val("");
		$("#nombre").val("");
		$("#paterno").val("");
		$("#materno").val("");
		$("input[name=genero][value='M']").prop("checked", true);
		$("#celular").val("");
		$("#anio1").val("").trigger("change");
		$("#mes1").val("").trigger("change");
		$("#dia1").val("").trigger("change");
		$("#ciudad_residencia").val("").trigger("change");
	};

	const verificar_cupones = (ci) => {
		if (ci.length >= 4) {
			$.post("/cupon/buscar_cupones_usuario", { ci }, function (response) {
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
						// console.log(element);
						$("#card-cupon-body").append(
							' <label class="radio mb-2 p-2"><input type="radio" name="cupon_participante" id="cupon_participante" value="' +
								element +
								'" /><span style="margin-right: 6px;"></span> ' +
								element +
								"</label>"
						);
					});
					$("#card-cupon-body").append(
						'<label class="radio mb-2 p-2"><input type="radio" name="cupon_participante" checked="checked" id="cupon_participante" value="ninguno" /><span style="margin-right: 6px;"></span>Ninguno</label>'
					);
					$("#card-cupon-body").append("</div>");
				} else {
					$("#card-cupon").hide();
				}
			});
		}
	};

	const format_dia = (dia) => {
		if (dia >= 1 && dia <= 9) {
			return "0" + dia;
		} else {
			return dia;
		}
	};

	$("#padding-container").on(
		"change",
		"input[name=cupon_participante][type='radio']",
		function (e) {
			let valor = $(this).val();
			if (valor != "ninguno") {
				$("#costo_curso").css("text-decoration", "line-through");
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
					let precio_con_descuento =
						costo_curso - costo_curso * (response.porcentaje / 100);
					$(".form-text-costo").text(
						"Total a pagar con el descuento por tu cupón: " +
							precio_con_descuento +
							" Bs."
					);
					$(".form-text-costo").fadeTo(500);
					$("#monto_pago").focus();
				});
			} else {
				$("#costo_curso").removeAttr("style");
				$(".form-text-costo").text("");
				$("#monto_pago").val();
				$("#monto_pago").focus();
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

	$("#banco").hide();
	$("input[type=radio][name=modalidad_inscripcion]").change(function () {
		if (this.value == "TIGO MONEY" || this.value == "PAGO EFECTIVO") {
			$("#id_banco").append('<option value="BANCO" selected>BANCO</option>');
			$("#banco").hide();
		} else {
			$("#id_banco option[value='BANCO']").remove();
			$("#banco").show();
		}
	});
});
