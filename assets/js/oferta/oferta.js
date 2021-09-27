jQuery(document).ready(function () {
	const listado_cursos = () => {
		$.ajax({
			type: "POST",
			url: "/ofertas/cursos",
			contentType: "html",
		}).done(function (response) {
			$("#contenido_cursos").children().remove();
			$("#contenido_cursos").append(response);
		});
	};

	listado_cursos();

	const listado_cursos_proximos = () => {
		$.ajax({
			type: "POST",
			url: "/ofertas/cursos_proximos",
			contentType: "html",
		}).done(function (response) {
			$("#contenido_cursos_proximos").children().remove();
			$("#contenido_cursos_proximos").append(response);
		});
	};
	listado_cursos_proximos();

	$("#btn-expo, #btn-libro").on("click", function (e) {
		let id = $(this).attr("data-id");
		let titulo = $(this).attr("data-titulo");
		$("#id_evento").val(id);
		$("#titulo_suscripcion").html("Suscripción: " + titulo);
		$("#modal-suscribirse").modal("show");
	});

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

	$("#frm_suscripcion").on("submit", function (e) {
		e.preventDefault();
		let data = new FormData($(this)[0]);
		$.ajax({
			type: "POST",
			url: "/ofertas/guardar_suscripcion",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
		}).done(function (response) {
			if (typeof response.exito != "undefined") {
				if (response.id_evento == 1) {
					// feria de libro
					window.open(
						`https://api.whatsapp.com/send?phone=+591${
							response.celular
						}&text=${encodeURI(`Te damos la bienvenida ${response.nombre}
🎓𝐂𝐔𝐑𝐒𝐎𝐒 𝐂𝐎𝐑𝐓𝐎𝐒 - 𝐏𝐎𝐒𝐆𝐑𝐀𝐃𝐎 𝐔𝐏𝐄𝐀🏢 
Te invita a ser parte de nuestros grupos de información en WhatsApp, para que no te pierdas de nuestros cursos cortos 100% PRÁCTICOS.
👉 Dirigido a: Estudiantes, profesionales y público en general.
═══════════════
Para unirte al grupo de WhatsApp de la "FERIA DE LIBRO"
Haz click en el siguiente link👇  
https://chat.whatsapp.com/GUipUt96AfkATqU3lFk3k9
═══════════════
Para informarte acerca de nuestros cursos de DISEÑO MULTIMEDIA : 
✅ CURSO DE PHOTOSHOP BÁSICO.
✅ CURSO DE PHOTOSHOP AVANZADO.
✅ CURSO DE ELABORACIÓN DE MATERIAL EDUCATIVO, DIDÁCTICO, ANIMADO E INTERACTIVO.
Haz click en el siguiente link👇  
https://cursosposgrado.upea.bo/disenioMultimedia

Para informarte acerca de nuestros cursos de COMPUTACIÓN :
✅ CURSO DE COMPUTACIÓN.
✅ CURSO DE OFIMÁTICA.
✅ CURSO DE EXCEL BÁSICO.
✅ CURSO DE EXCEL AVANZADO.
✅ CURSO DE INTERNET DOMICILIARIO DESDE CERO.
Haz click en el siguiente link 👇  
https://cursosposgrado.upea.bo/computacion

Para informarte acerca de nuestros cursos de INGENIERÍA :
✅ CURSO DE AUTOCAD 2D.
✅ CURSO DE AUTOCAD 3D.
Haz click en el siguiente link 👇  
https://cursosposgrado.upea.bo/ingenieria

Para informarte acerca de nuestros cursos de EDUCACIÓN VIRTUAL :
✅ CURSO DE HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL.
✅ CURSO DE ADMINISTRACIÓN DE PLATAFORMAS VIRTUALES MOODLE.
Haz click en el siguiente link👇  
https://cursosposgrado.upea.bo/educacionVirtual
══════════════
Certifícate con Cursos Posgrado UPEA e incrementa tu productividad laboral y eficiencia académica.
🧑‍🎓 Certificado con valor curricular de hasta 240 Horas.
🌐 Modalidad:  Virtual.
🗓️ Duración:  De dos a tres semanas. 
👨‍🏫 Docentes: Especialistas en cada área.
══════════════
🔖 Certificación emitida por la Dirección de POSGRADO - UPEA. 
🔐 Contiene un código QR de verificación de datos en línea. 
Revisa las características de nuestros certificados en 👇  
https://cursosposgrado.upea.bo/videoCertificados
══════════════
Síguenos en nuestras redes sociales:
	
FACEBOOK 👇 
https://www.facebook.com/cursosposgradoupea/
TELEGRAM 👇 
https://t.me/joinchat/jeMsyzXxHDg4N2Ix
TIK TOK 👇 
https://www.tiktok.com/@cursosposgrado_upea
TWITTER 👇 
https://twitter.com/CursosPosgradoUpea
LINKEDIN 👇 
https://www.linkedin.com/in/cursosposgradoupea/
INSTAGRAM 👇 
https://instagram.com/cursosposgradoupea
YOUTUBE 👇 
https://www.youtube.com/c/CursosPosgradoUPEA
Visita nuestra página web 👇 
https://cursosposgrado.upea.bo
═════════════
📞 Más información e inscripciones con los números : 
	62332648  -  76209205 
	https://wa.link/2fcwgv 
	https://wa.link/ac2cw8
Mira como puedes inscribirte en línea en 👇  
https://cursosposgrado.upea.bo/videoInscripcion
- 𝕀ℕ𝕊ℂℝ𝕀ℙℂ𝕀𝕆ℕ𝔼𝕊 𝔸 ℕ𝕀𝕍𝔼𝕃 ℕ𝔸ℂ𝕀𝕆ℕ𝔸𝕃 -
ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
▀▄▀▄▀▄ 𝙿𝙾𝚁𝚀𝚄𝙴 𝚃𝚄́ 𝙵𝙾𝚁𝙼𝙰𝙲𝙸𝙾́𝙽 
𝙰𝙲𝙰𝙳𝙴́𝙼𝙸𝙲𝙰 𝙽𝙾𝚂 𝙸𝙽𝚃𝙴𝚁𝚂𝙰 ▄▀▄▀▄▀
					`)}`,
						"_blank"
					);
				} else {
					//fexpo cruz
					window.open(
						`https://api.whatsapp.com/send?phone=+591${
							response.celular
						}&text=${encodeURI(`Te damos la bienvenida ${response.nombre}
🎓𝐂𝐔𝐑𝐒𝐎𝐒 𝐂𝐎𝐑𝐓𝐎𝐒 - 𝐏𝐎𝐒𝐆𝐑𝐀𝐃𝐎 𝐔𝐏𝐄𝐀🏢 
Te invita a ser parte de nuestros grupos de información en WhatsApp, para que no te pierdas de nuestros cursos cortos 100% PRÁCTICOS.
👉 Dirigido a: Estudiantes, profesionales y público en general.
═══════════════
Para unirte al grupo de WhatsApp de la "EXPOCRUZ 2021"
Haz click en el siguiente link👇  
https://chat.whatsapp.com/KZhcfANCn8o20uVFVZMKbx
═══════════════
Para informarte acerca de nuestros cursos de DISEÑO MULTIMEDIA : 
✅ CURSO DE PHOTOSHOP BÁSICO.
✅ CURSO DE PHOTOSHOP AVANZADO.
✅ CURSO DE ELABORACIÓN DE MATERIAL EDUCATIVO, DIDÁCTICO, ANIMADO E INTERACTIVO.
Haz click en el siguiente link👇  
https://cursosposgrado.upea.bo/disenioMultimedia

Para informarte acerca de nuestros cursos de COMPUTACIÓN :
✅ CURSO DE COMPUTACIÓN.
✅ CURSO DE OFIMÁTICA.
✅ CURSO DE EXCEL BÁSICO.
✅ CURSO DE EXCEL AVANZADO.
✅ CURSO DE INTERNET DOMICILIARIO DESDE CERO.
Haz click en el siguiente link 👇  
https://cursosposgrado.upea.bo/computacion

Para informarte acerca de nuestros cursos de INGENIERÍA :
✅ CURSO DE AUTOCAD 2D.
✅ CURSO DE AUTOCAD 3D.
Haz click en el siguiente link 👇  
https://cursosposgrado.upea.bo/ingenieria

Para informarte acerca de nuestros cursos de EDUCACIÓN VIRTUAL :
✅ CURSO DE HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL.
✅ CURSO DE ADMINISTRACIÓN DE PLATAFORMAS VIRTUALES MOODLE.
Haz click en el siguiente link👇  
https://cursosposgrado.upea.bo/educacionVirtual
══════════════
Certifícate con Cursos Posgrado UPEA e incrementa tu productividad laboral y eficiencia académica.
🧑‍🎓 Certificado con valor curricular de hasta 240 Horas.
🌐 Modalidad:  Virtual.
🗓️ Duración:  De dos a tres semanas. 
👨‍🏫 Docentes: Especialistas en cada área.
══════════════
🔖 Certificación emitida por la Dirección de POSGRADO - UPEA. 
🔐 Contiene un código QR de verificación de datos en línea. 
Revisa las características de nuestros certificados en 👇  
https://cursosposgrado.upea.bo/videoCertificados
══════════════
Síguenos en nuestras redes sociales:
	
FACEBOOK 👇 
https://www.facebook.com/cursosposgradoupea/
TELEGRAM 👇 
https://t.me/joinchat/jeMsyzXxHDg4N2Ix
TIK TOK 👇 
https://www.tiktok.com/@cursosposgrado_upea
TWITTER 👇 
https://twitter.com/CursosPosgradoUpea
LINKEDIN 👇 
https://www.linkedin.com/in/cursosposgradoupea/
INSTAGRAM 👇 
https://instagram.com/cursosposgradoupea
YOUTUBE 👇 
https://www.youtube.com/c/CursosPosgradoUPEA
Visita nuestra página web 👇 
https://cursosposgrado.upea.bo
═════════════
📞 Más información e inscripciones con los números : 
	62332648  -  76209205 
	https://wa.link/2fcwgv 
	https://wa.link/ac2cw8
Mira como puedes inscribirte en línea en 👇  
https://cursosposgrado.upea.bo/videoInscripcion
- 𝕀ℕ𝕊ℂℝ𝕀ℙℂ𝕀𝕆ℕ𝔼𝕊 𝔸 ℕ𝕀𝕍𝔼𝕃 ℕ𝔸ℂ𝕀𝕆ℕ𝔸𝕃 -
ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
▀▄▀▄▀▄ 𝙿𝙾𝚁𝚀𝚄𝙴 𝚃𝚄́ 𝙵𝙾𝚁𝙼𝙰𝙲𝙸𝙾́𝙽 
𝙰𝙲𝙰𝙳𝙴́𝙼𝙸𝙲𝙰 𝙽𝙾𝚂 𝙸𝙽𝚃𝙴𝚁𝚂𝙰 ▄▀▄▀▄▀
					`)}`,
						"_blank"
					);
				}
				limpiarCampos();
			}

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
		$("#id_evento").val("");
	};
});
