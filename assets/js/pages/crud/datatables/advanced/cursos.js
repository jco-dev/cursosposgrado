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
				iDisplayLength: 10,
				columnDefs: [
					{
						searchable: true,
						orderable: true,
						visible: true,
						targets: 2,
					},
				],
				responsive: true,
				order: [[0, "desc"]],
			})
			.on("click", ".dropdown", function () {})
			.on("click", "#btn_inscripcion", function (e) {
				jQuery(".navi").toggleClass("visible");
			})
			.on("click", "#btn_imprimir_todos", function (e) {})
			.on("click", "#btn_imprimir_blanco", function (e) {})
			.on("click", "#btn_enviar_por_correo", function (e) {});

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

// INGRESAR EL CURSO A LA CONFIGURACION
const configuracion = (id) => {
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
};

// INSCRIPCION DE ESTUDIANTES DESDE LA PLATAFORMA MOODLE
const inscripcion_estudiantes = (id) => {
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
};

// IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO
const imprimir_certificados = (id) => {
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
};

// IMPRIMIR CERTIFICADOS EN BLANCO
const imprimir_certificado_blanco = (id) => {
	Swal.fire({
		title: "Seleccione tipo de participacion",
		input: "select",
		inputOptions: {
			tipo: {
				APROBADO: "APROBADO",
				EXPOSITOR: "EXPOSITOR",
				ORGANIZADOR: "ORGANIZADOR",
				PARTICIPADO: "PARTICIPADO",
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
};

// ENVIAR CORREO DE CERTIFICADOS
const enviar_certificados_correo = (id) => {
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
};

const reporte_economico = (id) => {
	if (id != null || id != "") {
		window.open("/cursos/reporte_economico/" + id, "_blank");
	} else {
		swal({
			html: true,
			title: "Adventencia!!!",
			text: "Error al imprimir el reporte económico del curso",
			type: "warning",
		});
	}
};

// IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO
const reporte_totales = (id) => {
	$.post(
		"/cursos/imprimir_certificado_todos",
		{
			id,
			value: "",
		},
		function (response) {
			generar_grafico(response);
			// console.log("ingreso");
			$("#modal-title-totales").html("REPORTE ECONÓMICO TOTAL");
			$("#modal_imprimir_totales").modal({
				backdrop: "static",
				keyboard: true,
			});
		}
	);
};

google.load("visualization", "1", { packages: ["corechart"] });
google.setOnLoadCallback(reporte_totales);

function generar_grafico(res) {
	// console.log(res);
	// let data = new google.visualization.DataTable();
	// data.addColumn("string", "Estado");
	// data.addColumn("number", "Cantidad");
	// $.each(res, function (i, res) {
	// 	var estado = res.estado;
	// 	var cantidad = parseInt($.trim(res.cantidad));
	// 	data.addRows([[estado, cantidad]]);
	// });
	var options = {
		title: "REPORTE ECONÓMICO TOTAL",
		// pieHole: 0.4,
		is3D: true,
		chartArea: {
			top: 20,
			bottom: 10,
			height: "100%",
			width: "100%",
		},
	};
	var data = google.visualization.arrayToDataTable([
		["Task", "Inscritos"],
		["TIGO MONEY", 7],
		["DEPÓSITO BANCARIO", 5],
		["PAGO EFECTIVO", 4],
		["TIGO MONEY1", 7],
		["DEPÓSITO BANCARIO1", 5],
		["PAGO EFECTIVO1", 4],
	]);

	var chart = new google.visualization.PieChart(
		document.getElementById("chart_div")
	);
	var chart_area = document.getElementById("chart_div");

	chart.draw(data, options);
}

jQuery(document).ready(function () {});
