"use strict";
var tbl_cursos;
var KTDatatablesCursos = (function () {
	var init = function () {
		tbl_cursos = $("#tbl_cursos");

		// begin first tbl_cursos
		tbl_cursos
			.DataTable({
				processing: true,
				serverSide: true,
				ajax: "/cursos/ajax_listado_cursos",
				lengthMenu: [
					[10, 20, 30, 50, 100, -1],
					[10, 20, 30, 50, 100, "Todos"],
				],
				iDisplayLength: -1,
				columnDefs: [
					{
						searchable: true,
						orderable: true,
						visible: true,
						targets: 2,
					},
				],
				responsive: true,
			})
			.on("click", "#btn_configuracion", function () {
					
			})
			.on("click", "#btn_inscripcion", function (e) {

			})
			.on("click", "#btn_imprimir_todos", function (e) {
				
			})
			.on("click", "#btn_imprimir_blanco", function (e) {
				let id = $(this).attr("data-id");
				Swal.fire({
					title: "Seleccione tipo de participacion",
					input: "select",
					inputOptions: {
						tipo: {
							PARTICIPADO: "PARTICIPADO",
							EXPUESTO: "EXPUESTO",
							ORGANIZADO: "ORGANIZADO",
							APROBADO: "APROBADO",
						},
					},
					showCancelButton: true,
					inputValidator: (value) => {
						return new Promise((resolve) => {
							resolve();
							Swal.fire({
								title:
									"Seleccione si para que lleve la letra A delante del nombre del participante",
								input: "select",
								inputOptions: {
									tipo: {
										SI: "SI",
										NO: "NO",
									},
								},
								showCancelButton: true,
								inputValidator: (tipo) => {
									return new Promise((resolve) => {
										resolve();
										$.post(
											"/cursos/imprimir_certificado_blanco",
											{
												id,
												value,
												tipo,
											},
											function (response) {
												if (typeof response.error != "undefined") {
													Swal.fire("Error!", response.error, "error");
												} else {
													$("#modal-body-certificado").children().remove();
													$("#modal-body-certificado").html(
														'<embed src="data:application/pdf;base64,' +
															response +
															'#toolbar=1&navpanes=1&scrollbar=1&zoom=67,100,100" type="application/pdf" width="100%" height="600px" style="border: none;"/>'
													);
													$("#modal_imprimir_certificado").modal({
														backdrop: "static",
														keyboard: true,
													});
												}
											}
										);
									});
								},
							});
						});
					},
				});
			})
			.on("click", "#btn_enviar_por_correo", function (e) {
				let id = $(this).attr("data-id");
				$.post(
					"/cursos/enviar_certificados",
					{
						id,
					},
					function (response) {
						if (typeof response.error != "undefined") {
							Swal.fire("Error!", response.error, "error");
						}
						if (typeof response.exito != "undefined") {
							Swal.fire("Exito!", response.exito, "success");
						}
						if (typeof response.warning != "undefined") {
							Swal.fire("Advertencia!", response.warning, "success");
						}
					}
				);
			});

		$("#kt_datatable_search_status").on("change", function () {
			datatable.search($(this).val().toLowerCase(), "Status");
		});

		$("#kt_datatable_search_type").on("change", function () {
			datatable.search($(this).val().toLowerCase(), "Type");
		});

		$("#kt_datatable_search_status, #kt_datatable_search_type").selectpicker();
		
	};

	return {
		//main function to initiate the module
		init: function () {
			init();
		},
	};

})();

KTDatatablesCursos.init();

jQuery(document).ready(function () {
	// INGRESAR EL CURSO A LA CONFIGURACION
	jQuery(".dropdown #btn_configuracion").click(function () {
		jQuery(".navi").toggleClass("visible");
		let id = $(this).attr("data-id");
		$.post(
			"/cursos/ingresar_configuracion",
			{
				id,
			},
			function (response) {
				if (typeof response.exito != "undefined") {
					Swal.fire("Exito!", response.exito, "success");
				}

				if (typeof response.warning != "undefined") {
					Swal.fire("Advertencia!", response.warning, "warning");
				}

				if (typeof response.error != "undefined") {
					Swal.fire("Error!", response.error, "error");
				}
			}
		);
	});

	// INSCRIPCION DE ESTUDIANTES DESDE LA PLATAFORMA MOODLE
	jQuery(".dropdown #btn_inscripcion").click(function () {
		jQuery(".navi").toggleClass("visible");
		let id = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			url: "/cursos/inscribir_estudiantes",
			data: {
				id,
			},
			dataType: "JSON",
		}).done(function (response) {
			if (typeof response.exito != "undefined") {
				// tbl_cursos.draw("page");
				Swal.fire("Exito!", response.exito, "success");
			}
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			}

			if (typeof response.warning != "undefined") {
				Swal.fire("Advertencia!", response.warning, "warning");
			}
		});
	});

	// IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO
	jQuery(".dropdown #btn_imprimir_todos").click(function () {
		let id = $(this).attr("data-id");

		Swal.fire({
			title:
				"Seleccione si para que lleve la letra A delante del nombre del participante",
			input: "select",
			inputOptions: {
				tipo: {
					SI: "SI",
					NO: "NO",
				},
			},
			showCancelButton: true,
			inputValidator: (value) => {
				return new Promise((resolve) => {
					resolve();
					$.post(
						"/cursos/imprimir_certificado_todos",
						{
							id,
							value,
						},
						function (response) {
							if (typeof response.error != "undefined") {
								Swal.fire("Error!", response.error, "error");
							} else {
								// console.log("ingreso");
								let ruta =
									location.origin +
									"/assets/" +
									response +
									"#toolbar=0&navpanes=0&scrollbar=0";
								$("#modal-body-certificado").children().remove();
								$("#modal-body-certificado").html(
									'<embed src="' +
										ruta +
										'" type="application/pdf" width="100%" height="600px" />'
								);
								$("#modal_imprimir_certificado").modal({
									backdrop: "static",
									keyboard: true,
								});
							}
						}
					);
				});
			},
		});
	});

});

