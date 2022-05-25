const cupon = (year, month, day, hour, minute) => {
	simplyCountdown("#cupon-fecha-fin", {
		year: year,
		month: month,
		day: day,
		hours: hour,
		minutes: minute,
		seconds: 00,
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
};

fecha_fin = $("#fecha_final").val();
fecha_fin = fecha_fin.split(" ");
fecha = fecha_fin[0].split("-");
hora = fecha_fin[1].split(":");

cupon(fecha[0], fecha[1], fecha[2], hora[0], hora[1]);

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
	$("#id_participante_cupon").val("");
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

// $("#modal-cupon").on("hidden.bs.modal", function () {
// 	$("#frm_inscripcion_cupon").trigger("reset");
// });

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

const agregar_animacion_icono = (name, clase) => {
	$("#btn-inscribir-cupon").prop("disabled", true);

	$(".button-cupon-submit").html(
		"<i class='fa fa-spin fa-spinner text-white button-reservar-cupon-icono' style='margin-bottom: 5px;'></i> GENERANDO PDF ..."
	);
	$("." + name).removeClass(clase);
};

const quitar_animacion_icono = (name, clase) => {
	$("#btn-inscribir-cupon").prop("disabled", false);

	$(".button-cupon-submit").html(
		"<i class='fas fa-save text-white button-reservar-cupon-icono' style='margin-bottom: 5px;'></i> RESERVAR MI CUPÓN"
	);
	$("." + name).removeClass(clase);
};

let btnActualizar = "button-reservar-cupon";

$("#frm_inscripcion_cupon").ajaxForm({
	url: $(this).attr("action"),
	type: "post",
	data: $(this).serialize(),
	dataType: "json",
	beforeSend: function () {
		parametrosEnvio(false, `${btnActualizar}-icono`);
	},
	uploadProgress: function (event, position, total, percentComplete) {
		agregar_animacion_icono("button-reservar-cupon-icono", "fas fa-save");
	},
	success: function (response) {
		console.log(response);
		if (typeof response.warning != "undefined") {
			Swal.fire("Advertencia!", response.warning, "warning");
			$("#frm_inscripcion_cupon").trigger("reset");
			$("#modal-cupon").modal("hide");
		}

		if (typeof response.numero != "undefined") {
			agregar_animacion_icono("button-reservar-cupon-icono", "fas fa-save ");
			$("#numero").val(response.numero);
			$("#codigo").val(response.codigo);

			generar_pdf(response.numero, response.codigo);

			$("#whatsapp").attr("celular", response.celular);
			$("#whatsapp").attr("cupon", response.cupon);
			$("#whatsapp").attr("nombre", response.nombre);
		}

		// $("#modal").modal("hide");
		// swal({ html: true, title: "INFORMACIÓN", text: r.exito, type: "success" });
	},
	error: function (jqXHR, textStatus, errorThrown) {
		parametrosEnvio(true, `${btnActualizar}-icono`);
		Swal.fire("Advertencia!", jqXHR.responseJSON.error, "error");
	},
	complete: function () {
		// $("#frm_inscripcion_cupon").trigger("reset");
	},
});

const generar_pdf = (numero, codigo) => {
	$.post(
		"/cupon/cupon_pdf",
		{
			numero: numero,
			codigo: codigo,
		},
		function (response) {
			quitar_animacion_icono(
				"button-reservar-cupon-icono",
				"fa fa-spin fa-spinner"
			);
			$("#modal-cupon").modal("hide");
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			} else {
				$("#modal-body-cupon").children().remove();
				$("#modal-body-cupon").html(
					'<embed src="data:application/pdf;base64,' +
						response +
						'#toolbar=1&navpanes=1&scrollbar=1&zoom=67,100,100" type="application/pdf" width="100%" height="500px" style="border: none;"/>'
				);

				$("#descargar-cupon").attr(
					"href",
					`data:application/pdf;base64, ${response}`
				);

				$("#modal_imprimir_cupon").modal({
					backdrop: "static",
					keyboard: true,
				});
			}
		}
	);
};

$("#whatsapp").on("click", function (e) {
	e.preventDefault();
	e.stopPropagation();

	let celular = $(this).attr("celular");
	let cupon = $(this).attr("cupon");
	let nombre = $(this).attr("nombre");
	window.open(
		`https://api.whatsapp.com/send?phone=+591${celular}&text=${encodeURI(`Te damos la bienvenida ${nombre}
🎓𝐂𝐔𝐑𝐒𝐎𝐒 𝐂𝐎𝐑𝐓𝐎𝐒 - 𝐏𝐎𝐒𝐆𝐑𝐀𝐃𝐎 𝐔𝐏𝐄𝐀🏢
Su cupón de descuento es: ${cupon} y puede ser utilizado en la inscripción de cualquiera de nuestros cursos hasta el 31/12/2022.
═══════════════
Nuestros cursos:
✅ CURSO DE PHOTOSHOP BÁSICO.
✅ CURSO DE PHOTOSHOP AVANZADO.
✅ CURSO DE ELABORACIÓN DE MATERIAL EDUCATIVO, DIDÁCTICO, ANIMADO E INTERACTIVO.
✅ CURSO DE COMPUTACIÓN.
✅ CURSO DE OFIMÁTICA.
✅ CURSO DE EXCEL BÁSICO.
✅ CURSO DE EXCEL AVANZADO.
✅ CURSO DE INTERNET DOMICILIARIO DESDE CERO.
✅ CURSO DE AUTOCAD 2D.
✅ CURSO DE AUTOCAD 3D.
✅ CURSO DE HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL.
✅ CURSO DE ADMINISTRACIÓN DE PLATAFORMAS VIRTUALES MOODLE.
═══════════════
🔖 Certificación emitida por la Dirección de POSGRADO - UPEA.
🔐 Contiene un código QR de verificación de datos en línea.
Revisa las características de nuestros certificados en 👇
https://cursosposgrado.upea.bo/videoCertificados
═══════════════
Comparte con sus amig@s el siguiente enlace:
https://cursosposgrado.upea.bo/cupon
═══════════════
Mira como puedes inscribirte en línea en 👇
https://cursosposgrado.upea.bo/videoInscripcion
- 𝕀ℕ𝕊ℂℝ𝕀ℙℂ𝕀𝕆ℕ𝔼𝕊 𝔸 ℕ𝕀𝕍𝔼𝕃 ℕ𝔸ℂ𝕀𝕆ℕ𝔸𝕃 -
ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
▀▄▀▄▀▄ 𝙿𝙾𝚁𝚀𝚄𝙴 𝚃𝚄́ 𝙵𝙾𝚁𝙼𝙰𝙲𝙸Ó𝙽
𝙰𝙲𝙰𝙳𝙴́𝙼𝙸𝙲𝙰 𝙽𝙾𝚂 𝙸𝙽𝚃𝙴𝚁𝚂𝙰 ▄▀▄▀▄▀
		`)}`,
		"_blank"
	);
});

$(".close-modal-cupon").on("click", function (e) {
	$("#modal-cupon").modal({
		backdrop: "static",
		keyboard: true,
	});
	$("#form-inscripcion").show();
});

$(".cerrar-formulario-registro").on("click", function (e) {
	$("#frm_inscripcion_cupon").trigger("reset");
});
