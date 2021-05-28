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

	// $("#kt_content").on("click", "a#descargar_pdf_curso", function () {
	// 	let id = $(this).attr("data-id");
	// 	let data = new FormData();
	// 	data.append("id", id);
	// 	$.ajax({
	// 		url: "/cursos/descargar_pdf_curso",
	// 		method: "POST",
	// 		//dataType: 'JSON',
	// 		data: data,
	// 		// cache: false,
	// 		contentType: false,
	// 		processData: false,
	// 	}).done(function (regreso) {
	// 		window.open(regreso, "_blank");
	// 	});
	// });
});
