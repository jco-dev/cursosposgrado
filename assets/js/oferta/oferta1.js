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

	$("#btn-expo, #btn-libro, #btn-fipaz").on("click", function (e) {
		let id = $(this).attr("data-id");
		let titulo = $(this).attr("data-titulo");
		$("#id_evento").val(id);
		$("#titulo_suscripcion").html("SuscripciΓ³n: " + titulo);
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
			// console.log(response);
			if (typeof response.exito != "undefined") {
				if (response.id_evento == "1") {
					// feria de libro
					window.open(
						`https://api.whatsapp.com/send?phone=+591${
							response.celular
						}&text=${encodeURI(`Te damos la bienvenida ${response.nombre}
πππππππ ππππππ - ππππππππ πππππ’ 
Te invita a ser parte de nuestros grupos de informaciΓ³n en WhatsApp, para que no te pierdas de nuestros cursos cortos 100% PRΓCTICOS.
π Dirigido a: Estudiantes, profesionales y pΓΊblico en general.
βββββββββββββββ
Para unirte al grupo de WhatsApp de la "FERIA DE LIBRO"
Haz click en el siguiente linkπ  
https://chat.whatsapp.com/GUipUt96AfkATqU3lFk3k9
βββββββββββββββ
Para informarte acerca de nuestros cursos de DISEΓO MULTIMEDIA : 
β CURSO DE PHOTOSHOP BΓSICO.
β CURSO DE PHOTOSHOP AVANZADO.
β CURSO DE ELABORACIΓN DE MATERIAL EDUCATIVO, DIDΓCTICO, ANIMADO E INTERACTIVO.
Haz click en el siguiente linkπ  
https://cursosposgrado.upea.bo/disenioMultimedia

Para informarte acerca de nuestros cursos de COMPUTACIΓN :
β CURSO DE COMPUTACIΓN.
β CURSO DE OFIMΓTICA.
β CURSO DE EXCEL BΓSICO.
β CURSO DE EXCEL AVANZADO.
β CURSO DE INTERNET DOMICILIARIO DESDE CERO.
Haz click en el siguiente link π  
https://cursosposgrado.upea.bo/computacion

Para informarte acerca de nuestros cursos de INGENIERΓA :
β CURSO DE AUTOCAD 2D.
β CURSO DE AUTOCAD 3D.
Haz click en el siguiente link π  
https://cursosposgrado.upea.bo/ingenieria

Para informarte acerca de nuestros cursos de EDUCACIΓN VIRTUAL :
β CURSO DE HERRAMIENTAS PARA LA EDUCACIΓN VIRTUAL.
β CURSO DE ADMINISTRACIΓN DE PLATAFORMAS VIRTUALES MOODLE.
Haz click en el siguiente linkπ  
https://cursosposgrado.upea.bo/educacionVirtual
ββββββββββββββ
CertifΓ­cate con Cursos Posgrado UPEA e incrementa tu productividad laboral y eficiencia acadΓ©mica.
π§βπ Certificado con valor curricular de hasta 240 Horas.
π Modalidad:  Virtual.
ποΈ DuraciΓ³n:  De dos a tres semanas. 
π¨βπ« Docentes: Especialistas en cada Γ‘rea.
ββββββββββββββ
π CertificaciΓ³n emitida por la DirecciΓ³n de POSGRADO - UPEA. 
π Contiene un cΓ³digo QR de verificaciΓ³n de datos en lΓ­nea. 
Revisa las caracterΓ­sticas de nuestros certificados en π  
https://cursosposgrado.upea.bo/videoCertificados
ββββββββββββββ
SΓ­guenos en nuestras redes sociales:
	
FACEBOOK π 
https://www.facebook.com/cursosposgradoupea/
TELEGRAM π 
https://t.me/joinchat/jeMsyzXxHDg4N2Ix
TIK TOK π 
https://www.tiktok.com/@cursosposgrado_upea
TWITTER π 
https://twitter.com/CursosPosgradoUpea
LINKEDIN π 
https://www.linkedin.com/in/cursosposgradoupea/
INSTAGRAM π 
https://instagram.com/cursosposgradoupea
YOUTUBE π 
https://www.youtube.com/c/CursosPosgradoUPEA
Visita nuestra pΓ‘gina web π 
https://cursosposgrado.upea.bo
βββββββββββββ
π MΓ‘s informaciΓ³n e inscripciones con los nΓΊmeros : 
	62332648  -  76209205 
	https://wa.link/2fcwgv 
	https://wa.link/ac2cw8
Mira como puedes inscribirte en lΓ­nea en π  
https://cursosposgrado.upea.bo/videoInscripcion
- πβπββπββππβπΌπ πΈ βπππΌπ βπΈβππβπΈπ -
ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
ββββββ πΏπΎππππ΄ ππΜ π΅πΎππΌπ°π²πΈπΎΜπ½ 
π°π²π°π³π΄ΜπΌπΈπ²π° π½πΎπ πΈπ½ππ΄πππ° ββββββ
					`)}`,
						"_blank"
					);
				} else if (response.id_evento == "2") {
					//fexpo cruz
					window.open(
						`https://api.whatsapp.com/send?phone=+591${
							response.celular
						}&text=${encodeURI(`Te damos la bienvenida ${response.nombre}
πππππππ ππππππ - ππππππππ πππππ’ 
Te invita a ser parte de nuestros grupos de informaciΓ³n en WhatsApp, para que no te pierdas de nuestros cursos cortos 100% PRΓCTICOS.
π Dirigido a: Estudiantes, profesionales y pΓΊblico en general.
βββββββββββββββ
Para unirte al grupo de WhatsApp de la "EXPOCRUZ 2021"
Haz click en el siguiente linkπ  
https://chat.whatsapp.com/KZhcfANCn8o20uVFVZMKbx
βββββββββββββββ
Para informarte acerca de nuestros cursos de DISEΓO MULTIMEDIA : 
β CURSO DE PHOTOSHOP BΓSICO.
β CURSO DE PHOTOSHOP AVANZADO.
β CURSO DE ELABORACIΓN DE MATERIAL EDUCATIVO, DIDΓCTICO, ANIMADO E INTERACTIVO.
Haz click en el siguiente linkπ  
https://cursosposgrado.upea.bo/disenioMultimedia

Para informarte acerca de nuestros cursos de COMPUTACIΓN :
β CURSO DE COMPUTACIΓN.
β CURSO DE OFIMΓTICA.
β CURSO DE EXCEL BΓSICO.
β CURSO DE EXCEL AVANZADO.
β CURSO DE INTERNET DOMICILIARIO DESDE CERO.
Haz click en el siguiente link π  
https://cursosposgrado.upea.bo/computacion

Para informarte acerca de nuestros cursos de INGENIERΓA :
β CURSO DE AUTOCAD 2D.
β CURSO DE AUTOCAD 3D.
Haz click en el siguiente link π  
https://cursosposgrado.upea.bo/ingenieria

Para informarte acerca de nuestros cursos de EDUCACIΓN VIRTUAL :
β CURSO DE HERRAMIENTAS PARA LA EDUCACIΓN VIRTUAL.
β CURSO DE ADMINISTRACIΓN DE PLATAFORMAS VIRTUALES MOODLE.
Haz click en el siguiente linkπ  
https://cursosposgrado.upea.bo/educacionVirtual
ββββββββββββββ
CertifΓ­cate con Cursos Posgrado UPEA e incrementa tu productividad laboral y eficiencia acadΓ©mica.
π§βπ Certificado con valor curricular de hasta 240 Horas.
π Modalidad:  Virtual.
ποΈ DuraciΓ³n:  De dos a tres semanas. 
π¨βπ« Docentes: Especialistas en cada Γ‘rea.
ββββββββββββββ
π CertificaciΓ³n emitida por la DirecciΓ³n de POSGRADO - UPEA. 
π Contiene un cΓ³digo QR de verificaciΓ³n de datos en lΓ­nea. 
Revisa las caracterΓ­sticas de nuestros certificados en π  
https://cursosposgrado.upea.bo/videoCertificados
ββββββββββββββ
SΓ­guenos en nuestras redes sociales:
	
FACEBOOK π 
https://www.facebook.com/cursosposgradoupea/
TELEGRAM π 
https://t.me/joinchat/jeMsyzXxHDg4N2Ix
TIK TOK π 
https://www.tiktok.com/@cursosposgrado_upea
TWITTER π 
https://twitter.com/CursosPosgradoUpea
LINKEDIN π 
https://www.linkedin.com/in/cursosposgradoupea/
INSTAGRAM π 
https://instagram.com/cursosposgradoupea
YOUTUBE π 
https://www.youtube.com/c/CursosPosgradoUPEA
Visita nuestra pΓ‘gina web π 
https://cursosposgrado.upea.bo
βββββββββββββ
π MΓ‘s informaciΓ³n e inscripciones con los nΓΊmeros : 
	62332648  -  76209205 
	https://wa.link/2fcwgv 
	https://wa.link/ac2cw8
Mira como puedes inscribirte en lΓ­nea en π  
https://cursosposgrado.upea.bo/videoInscripcion
- πβπββπββππβπΌπ πΈ βπππΌπ βπΈβππβπΈπ -
ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
ββββββ πΏπΎππππ΄ ππΜ π΅πΎππΌπ°π²πΈπΎΜπ½ 
π°π²π°π³π΄ΜπΌπΈπ²π° π½πΎπ πΈπ½ππ΄πππ° ββββββ
					`)}`,
						"_blank"
					);
				} else if (response.id_evento == "3") {
					//fexpo cruz
					window.open(
						`https://api.whatsapp.com/send?phone=+591${
							response.celular
						}&text=${encodeURI(`Te damos la bienvenida ${response.nombre}
πππππππ ππππππ - ππππππππ πππππ’ 
Te invita a ser parte de nuestros grupos de informaciΓ³n en WhatsApp, para que no te pierdas de nuestros cursos cortos 100% PRΓCTICOS.
π Dirigido a: Estudiantes, profesionales y pΓΊblico en general.
βββββββββββββββ
Para unirte al grupo de WhatsApp de la "FIPAZ 2021"
Haz click en el siguiente linkπ  
https://chat.whatsapp.com/GUipUt96AfkATqU3lFk3k9
βββββββββββββββ
Para informarte acerca de nuestros cursos de DISEΓO MULTIMEDIA : 
β CURSO DE PHOTOSHOP BΓSICO.
β CURSO DE PHOTOSHOP AVANZADO.
β CURSO DE ELABORACIΓN DE MATERIAL EDUCATIVO, DIDΓCTICO, ANIMADO E INTERACTIVO.
Haz click en el siguiente linkπ  
https://cursosposgrado.upea.bo/disenioMultimedia

Para informarte acerca de nuestros cursos de COMPUTACIΓN :
β CURSO DE COMPUTACIΓN.
β CURSO DE OFIMΓTICA.
β CURSO DE EXCEL BΓSICO.
β CURSO DE EXCEL AVANZADO.
β CURSO DE INTERNET DOMICILIARIO DESDE CERO.
Haz click en el siguiente link π  
https://cursosposgrado.upea.bo/computacion

Para informarte acerca de nuestros cursos de INGENIERΓA :
β CURSO DE AUTOCAD 2D.
β CURSO DE AUTOCAD 3D.
Haz click en el siguiente link π  
https://cursosposgrado.upea.bo/ingenieria

Para informarte acerca de nuestros cursos de EDUCACIΓN VIRTUAL :
β CURSO DE HERRAMIENTAS PARA LA EDUCACIΓN VIRTUAL.
β CURSO DE ADMINISTRACIΓN DE PLATAFORMAS VIRTUALES MOODLE.
Haz click en el siguiente linkπ  
https://cursosposgrado.upea.bo/educacionVirtual
ββββββββββββββ
CertifΓ­cate con Cursos Posgrado UPEA e incrementa tu productividad laboral y eficiencia acadΓ©mica.
π§βπ Certificado con valor curricular de hasta 240 Horas.
π Modalidad:  Virtual.
ποΈ DuraciΓ³n:  De dos a tres semanas. 
π¨βπ« Docentes: Especialistas en cada Γ‘rea.
ββββββββββββββ
π CertificaciΓ³n emitida por la DirecciΓ³n de POSGRADO - UPEA. 
π Contiene un cΓ³digo QR de verificaciΓ³n de datos en lΓ­nea. 
Revisa las caracterΓ­sticas de nuestros certificados en π  
https://cursosposgrado.upea.bo/videoCertificados
ββββββββββββββ
SΓ­guenos en nuestras redes sociales:
	
FACEBOOK π 
https://www.facebook.com/cursosposgradoupea/
TELEGRAM π 
https://t.me/joinchat/jeMsyzXxHDg4N2Ix
TIK TOK π 
https://www.tiktok.com/@cursosposgrado_upea
TWITTER π 
https://twitter.com/CursosPosgradoUpea
LINKEDIN π 
https://www.linkedin.com/in/cursosposgradoupea/
INSTAGRAM π 
https://instagram.com/cursosposgradoupea
YOUTUBE π 
https://www.youtube.com/c/CursosPosgradoUPEA
Visita nuestra pΓ‘gina web π 
https://cursosposgrado.upea.bo
βββββββββββββ
π MΓ‘s informaciΓ³n e inscripciones con los nΓΊmeros : 
	62332648  -  76209205 
	https://wa.link/2fcwgv 
	https://wa.link/ac2cw8
Mira como puedes inscribirte en lΓ­nea en π  
https://cursosposgrado.upea.bo/videoInscripcion
- πβπββπββππβπΌπ πΈ βπππΌπ βπΈβππβπΈπ -
ENVIO DE CERTIFICADOS A LOS NUEVE DEPARTAMENTOS
ββββββ πΏπΎππππ΄ ππΜ π΅πΎππΌπ°π²πΈπΎΜπ½ 
π°π²π°π³π΄ΜπΌπΈπ²π° π½πΎπ πΈπ½ππ΄πππ° ββββββ
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
	};

	// $("#btn-ofertas").hide();
	const generarCaptcha = () => {
		$.ajax({
			type: "POST",
			url: "/certificacion/generarCaptcha",
		}).done(function (response) {
			// console.log(response);
			$("#code").val(response.codigo);
			$("#img-captcha").attr("src", response.ruta);
		});
	};

	generarCaptcha();

	$("#frm-consulta-certificacion").submit(function (e) {
		$("#frm-consulta-certificacion").addClass("was-validated");
		$("#frm-consulta-certificacion").removeClass("needs-validation");
		e.preventDefault();
		let data = new FormData($(this)[0]);
		$.ajax({
			type: "POST",
			url: "/certificacion/verificacionCertificacion",
			data: $(this).serialize(),
		}).done(function (response) {
			// console.log(response);
			if (typeof response.message != "undefined") {
				if (response.recargar == true) {
					generarCaptcha();
				}
				$(".result").html(response.message);
				$("#code").val("");
				$("#result").val("");
				$("#result").focus();
			}

			if (typeof response.resp != "undefined") {
				$(".result").html("");
				$("#cursos-certificacion").html(response.resp);
				$("#carnet_identidad").val("");
				$("#nro_celular").val("");
				$("#result").val("");
				$("#carnet_identidad").focus();
				generarCaptcha();
			}
		});
	});
});
