simplyCountdown("#cupon-fecha-fin", {
	year: 2021,
	month: 12,
	day: 31,
	hours: 23,
	minutes: 59,
	seconds: 0,
	words: {
		days: "Día",
		hours: "Hora",
		minutes: "Minuto",
		seconds: "Segundo",
		pluralLetter: "s",
	},
	plural: true,
	inline: false,
	inlineClass: "simply-countdown-inline",

	enableUtc: false,
	onEnd: function () {
		return;
	},
	refresh: 1000,
	sectionClass: "simply-section",
	amountClass: "simply-amount",
	wordClass: "simply-word",
	zeroPad: false,
	countUp: false,
});

const ocultar_boton_buscar = () => {
	$(".btn-buscar-ci").attr("mdb-animation", "fade-in-left");
	$(".btn-buscar-ci").parent().hide();
	$("#ci_cupon").parent().addClass("col-lg-12");
	$("#ci_cupon").parent().removeClass("col-lg-9");
};

const mostrar_boton_buscar = () => {
	$(".btn-buscar-ci").attr("mdb-toggle", "animation");
	$(".btn-buscar-ci").attr("mdb-animation-reset", "true");
	$(".btn-buscar-ci").attr("mdb-animation", "fade-in-right");
	$(".btn-buscar-ci").parent().show();
	$("#ci_cupon").parent().addClass("col-lg-9");
	$("#ci_cupon").parent().removeClass("col-lg-12");
};

const mostrar_formulario = () => {
	$("#form-inscripcion").show();
	$("#form-inscripcion").attr("mdb-toggle", "animation");
	$("#form-inscripcion").attr("mdb-animation-reset", "true");
	$("#form-inscripcion").attr("mdb-animation", "fade-in-right");
};

const ocultar_formulario = () => {
	$("#form-inscripcion").attr("mdb-animation", "fade-in-left");
	$("#form-inscripcion").hide();
};

const limpiar_formulario = (ci) => {
	$("#frm_inscripcion_cupon").trigger("reset");
	$("#ci_cupon").val(ci);
};

$(".button-cupon").click(function () {
	ocultar_boton_buscar();
	$("#form-inscripcion").hide();
	$("#modal-cupon").modal({
		backdrop: "static",
		keyboard: true,
	});
});

$("#modal-cupon").on("shown.bs.modal", function () {
	$("#ci_cupon").focus();
});

$("#ci_cupon").on("keyup change", function (e) {
	e.preventDefault();
	if ($(this).val().length > 3) {
		mostrar_boton_buscar();
	} else {
		ocultar_boton_buscar();
		ocultar_formulario();
	}
	ocultar_formulario();
});

//buscar usuario
$(".btn-buscar-ci").click(function () {
	const ci = $("#ci_cupon").val();
	if (ci.length > 3) {
		$.ajax({
			url: "/cupon/buscar_por_ci",
			type: "POST",
			data: {
				ci: ci,
			},
		}).done(function (response) {
			if (response != "") {
				if (typeof response.datos != "undefined") {
					$("#id_participante_cupon").val(response.datos[0].id_participante);
					$("#expedido_cupon")
						.val(response.datos[0].expedido)
						.trigger("change");
					$("#correo_cupon").val(response.datos[0].correo);
					$("#nombre_cupon").val(response.datos[0].nombre);
					$("#paterno_cupon").val(response.datos[0].paterno);
					$("#materno_cupon").val(response.datos[0].materno);
					$("#celular_cupon").val(response.datos[0].celular);
				}
			} else {
				limpiar_formulario(ci);
			}
			mostrar_formulario();
			ocultar_boton_buscar();
		});
	}
});

$("#modal-cupon").on("hidden.bs.modal", function () {
	$("#frm_inscripcion_cupon").trigger("reset");
});

const parametrosEnvio = (activarDesactivar, iconoEnviarFormulario) => {
	e = $(`#${iconoEnviarFormulario}`);
	e.removeClass();
	if (activarDesactivar) {
		e.addClass("mdi mdi-plus-circle");
		e.parent().attr("disabled", false);
	} else {
		e.addClass("fa fa-spin fa-spinner");
		e.parent().attr("disabled", true);
	}
};

$("#frm_inscripcion_cupon").ajaxForm({
	url: $(this).attr("action"),
	type: "post",
	data: $(this).serialize(),
	dataType: "json",
	beforeSend: function () {
		console.log("beforeSend");
		// parametrosEnvio(false, `${btnActualizar}-icono`);
	},
	uploadProgress: function (event, position, total, percentComplete) {
		console.log("uploadProgress");
		// $(`#${btnActualizar}-porcentaje`).html(`${percentComplete}%`);
	},
	success: function (r) {
		console.log(r);
		console.log("success");
		// $("#modal").modal("hide");
		// swal({ html: true, title: "INFORMACIÓN", text: r.exito, type: "success" });
	},
	error: function (jqXHR, textStatus, errorThrown) {
		console.log("terminado");
		// parametrosEnvio(true, `${btnActualizar}-icono`);
		// swal({
		// 	html: true,
		// 	title: "INFORMACIÓN",
		// 	text: jqXHR.responseJSON.error,
		// 	type: "error",
		// });
	},
	complete: function () {
		console.log("Completado");
		// $(`#${btnActualizar}-porcentaje`).html(``);
		// $("#tbl-listar-publicacion").DataTable().ajax.reload(false);
	},
});

//add a 5 second counter to a button with js
// $(".btn-buscar-ci").click(function () {
// 	$("#ci_cupon").focus();
// var counter = 4;
// var interval = setInterval(function () {
// 	counter--;
// 	if (counter < 0) {
// 		clearInterval(interval);
// 		$(".btn-buscar-ci").html('<i class="fas fa-search"></i>');
// 		console.log("termino");
// 		return;
// 	}
// 	$(".btn-buscar-ci").html("Buscando ..." + counter);
// 	$(".btn-buscar-ci").html(
// 		'<i class="fa fa-spinnerfas fa-spin" " aria-hidden="true"></i>'
// 	);
// }, 1000);
// 	let ci = null;
// 	if ($("#ci_cupon").val().length >= 4) {
// 		$.post(
// 			"/cupon/buscar_por_ci",
// 			{ ci: $("#ci_cupon").val() },
// 			function (response) {
// 				if (response != "") {
// 					// $("#form-inscripcion").show();
// 					if (typeof response.datos != "undefined") {
// 						$("#id_participante_cupon").val(response.datos[0].id_participante);
// 						$("#expedido_cupon")
// 							.val(response.datos[0].expedido)
// 							.trigger("change");
// 						$("#correo_cupon").val(response.datos[0].correo);
// 						$("#nombre_cupon").val(response.datos[0].nombre);
// 						$("#paterno_cupon").val(response.datos[0].paterno);
// 						$("#materno_cupon").val(response.datos[0].materno);
// 						$("#celular_cupon").val(response.datos[0].celular);
// 					}
// 				} else {
// 					ci = $("#ci_cupon").val();
// 					$("#frm_inscripcion_cupon").trigger("reset");
// 					$("#ci_cupon").val(ci);
// 				}
// 				$("#form-inscripcion").show();
// 				$(".btn-buscar-ci").parent().hide();
// 				$("#ci_cupon").parent().addClass("col-lg-12");
// 				$("#ci_cupon").parent().removeClass("col-lg-9");
// 			}
// 		);
// 	}
// });

// $("#ci_cupon").on("keyup", function (e) {
// 	$.post(
// 		"/cupon/buscar_por_ci",
// 		{ ci: $("#ci_cupon").val() },
// 		function (response) {
// 			$("#id_participante_cupon").val("");
// 			if (response != "") {
// 				if (typeof response.datos != "undefined") {
// 					$("#id_participante_cupon").val(response.datos[0].id_participante);
// 					$("#expedido_cupon")
// 						.val(response.datos[0].expedido)
// 						.trigger("change");
// 					$("#correo_cupon").val(response.datos[0].correo);
// 					$("#nombre_cupon").val(response.datos[0].nombre);
// 					$("#paterno_cupon").val(response.datos[0].paterno);
// 					$("#materno_cupon").val(response.datos[0].materno);
// 					$("#celular_cupon").val(response.datos[0].celular);
// 				}
// 			} else {
// 				ci = $("#ci_cupon").val();
// 				$("#frm_inscripcion_cupon").trigger("reset");
// 				$("#ci_cupon").val(ci);
// 				$("#form-inscripcion").hide();
// 				$(".btn-buscar-ci").parent().show();
// 				$("#ci_cupon").parent().addClass("col-lg-9");
// 				$("#ci_cupon").parent().removeClass("col-lg-12");
// 			}
// 		}
// 	);
// });

// $("#frm_inscripcion_cupon").submit(function (e) {
// 	e.preventDefault();
// 	e.stopPropagation();
// 	var form = $(this);
// 	var url = form.attr("action");
// 	var data = form.serialize();
// 	$.post(url, data, function (response) {
// 		if (typeof response.warning != "undefined") {
// 			Swal.fire("Advertencia!", response.warning, "warning");
// 			$("#frm_inscripcion_cupon").trigger("reset");
// 			$("#modal-cupon").modal("hide");
// 		}

// 		if (typeof response.numero != "undefined") {
// 			$.post(
// 				"/cupon/cupon_pdf",
// 				{
// 					numero: response.numero,
// 					codigo: response.codigo,
// 				},
// 				function (response) {
// 					$("#modal-cupon").modal("hide");
// 					if (typeof response.error != "undefined") {
// 						Swal.fire("Error!", response.error, "error");
// 					} else {
// 						$("#modal-body-cupon").children().remove();
// 						$("#modal-body-cupon").html(
// 							'<embed src="data:application/pdf;base64,' +
// 								response +
// 								'#toolbar=1&navpanes=1&scrollbar=1&zoom=67,100,100" type="application/pdf" width="100%" height="500px" style="border: none;"/>'
// 						);

// 						$("#descargar-cupon").attr(
// 							"href",
// 							`data:application/pdf;base64, ${response}`
// 						);

// 						$("#modal_imprimir_cupon").modal({
// 							backdrop: "static",
// 							keyboard: true,
// 						});
// 					}
// 				}
// 			);

// 			$("#whatsapp").attr("celular", response.celular);
// 			$("#whatsapp").attr("cupon", response.cupon);
// 			$("#whatsapp").attr("nombre", response.nombre);
// 		}
// 	});

// 	$("#whatsapp").on("click", function (e) {
// 		e.preventDefault();
// 		e.stopPropagation();

// 		let celular = $(this).attr("celular");
// 		let cupon = $(this).attr("cupon");
// 		let nombre = $(this).attr("nombre");
// 		window.open(
// 			`https://api.whatsapp.com/send?phone=+591${celular}&text=${encodeURI(`Te damos la bienvenida ${nombre}
// 🎓𝐂𝐔𝐑𝐒𝐎𝐒 𝐂𝐎𝐑𝐓𝐎𝐒 - 𝐏𝐎𝐒𝐆𝐑𝐀𝐃𝐎 𝐔𝐏𝐄𝐀🏢
// Su cupón de descuento es: ${cupon} y puede ser utilizado en la inscripción de cualquiera de nuestros cursos hasta el 31/12/2022.
// ═══════════════
// Nuestros cursos:
// ✅ CURSO DE PHOTOSHOP BÁSICO.
// ✅ CURSO DE PHOTOSHOP AVANZADO.
// ✅ CURSO DE ELABORACIÓN DE MATERIAL EDUCATIVO, DIDÁCTICO, ANIMADO E INTERACTIVO.
// ✅ CURSO DE COMPUTACIÓN.
// ✅ CURSO DE OFIMÁTICA.
// ✅ CURSO DE EXCEL BÁSICO.
// ✅ CURSO DE EXCEL AVANZADO.
// ✅ CURSO DE INTERNET DOMICILIARIO DESDE CERO.
// ✅ CURSO DE AUTOCAD 2D.
// ✅ CURSO DE AUTOCAD 3D.
// ✅ CURSO DE HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL.
// ✅ CURSO DE ADMINISTRACIÓN DE PLATAFORMAS VIRTUALES MOODLE.
// ═══════════════
// 🔖 Certificación emitida por la Dirección de POSGRADO - UPEA.
// 🔐 Contiene un código QR de verificación de datos en línea.
// Revisa las características de nuestros certificados en 👇
// https://cursosposgrado.upea.bo/videoCertificados
// ═══════════════
// Comparte con sus amig@s el siguiente enlace:
// https://cursosposgrado.upea.bo/cupon
// ═══════════════
// Mira como puedes inscribirte en línea en 👇
// https://cursosposgrado.upea.bo/videoInscripcion
// - 𝕀ℕ𝕊ℂℝ𝕀ℙℂ𝕀𝕆ℕ𝔼𝕊 𝔸 ℕ𝕀𝕍𝔼𝕃 ℕ𝔸ℂ𝕀𝕆ℕ𝔸𝕃 -
// ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
// ▀▄▀▄▀▄ 𝙿𝙾𝚁𝚀𝚄𝙴 𝚃𝚄́ 𝙵𝙾𝚁𝙼𝙰𝙲𝙸Ó𝙽
// 𝙰𝙲𝙰𝙳𝙴́𝙼𝙸𝙲𝙰 𝙽𝙾𝚂 𝙸𝙽𝚃𝙴𝚁𝚂𝙰 ▄▀▄▀▄▀
// 		`)}`,
// 			"_blank"
// 		);
// 	});

// 	$(".close-modal-cupon").on("click", function (e) {
// 		$("#modal-cupon").modal({
// 			backdrop: "static",
// 			keyboard: true,
// 		});
// 		$("#form-inscripcion").show();
// 	});

// 	$("#cerrar-formulario-cupon").on("click", function (e) {
// 		$("#frm_inscripcion_cupon").trigger("reset");
// 	});
// });
