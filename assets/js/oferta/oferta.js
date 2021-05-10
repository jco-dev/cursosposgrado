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
});
