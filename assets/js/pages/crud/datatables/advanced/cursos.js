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
			.on("click", ".estado_informe", function () {
				// console.log("click");
				var id = $(this).attr("id");
				let valor = $(this).attr("valor");
				let curso = $(this).attr("curso");
				let mensaje = "";
				if (valor == "SI") {
					mensaje =
						"¿Esta seguro de cambiar el estado 'NO ENTREGADO'  a 'ENTREGADO' del curso: " +
						curso +
						"?";
				} else {
					mensaje =
						"¿Esta seguro de cambiar el estado 'ENTREGADO'  a 'NO ENTREGADO' del curso: " +
						curso +
						"?";
				}

				Swal.fire({
					title: "CAMBIAR EL ESTADO DEL INFORME DEL CURSO",
					text: mensaje,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Si, cambiar!",
				}).then((result) => {
					if (result.isConfirmed) {
						$.post(
							"/cursos/cambiar_estado_informe",
							{ id, valor },
							function (response) {
								if (response.exito) {
									Swal.fire("Exito!", response.exito, "success");
									tbl_cursos.DataTable().ajax.reload();
								}
								if (response.error) {
									Swal.fire("Error!", response.error, "error");
								}
								if (response.warning) {
									Swal.fire("Advertencia!", response.warning, "warning");
								}
							}
						);
						Swal.fire("Deleted!", "Your file has been deleted.", "success");
					}
				});
			})
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
	//Check the dates of the printing of the course configuration
	$.post("/cursos/date_impresion", { id }, function (response) {
		if (
			response.exito[0].fecha_inicial === null ||
			response.exito[0].fecha_inicial === "0000-00-00" ||
			response.exito[0].fecha_final === null ||
			response.exito[0].fecha_final === "0000-00-00" ||
			response.exito[0].fecha_certificacion === null ||
			response.exito[0].fecha_certificacion === "0000-00-00"
		) {
			Swal.fire(
				"Advertencia!",
				"No se han configurado las fechas de impresion",
				"warning"
			);
		} else {
			if (
				new Date(response.exito[0].fecha_final).getTime() >
					new Date(response.exito[0].fecha_inicial).getTime() &&
				new Date(response.exito[0].fecha_certificacion).getTime() >
					new Date(response.exito[0].fecha_final).getTime()
			) {
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
			} else {
				Swal.fire(
					"Advertencia!",
					"La fecha inicial del curso debe ser mayor a la fecha final y la fecha final debe ser mayor o igual a la fecha de certificación del curso ",
					"warning"
				);
			}
		}
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

// DESCARGAR LISTADO DE ESTUDIANTES PDF
const reporte_estudiantes = (id) => {
	if (id != null || id != "") {
		window.open("/cursos/reporte_estudiantes/" + id, "_blank");
	} else {
		swal({
			html: true,
			title: "Adventencia!!!",
			text: "Error al imprimir el reporte de estudiantes del curso",
			type: "warning",
		});
	}
};

// IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO
google.charts.load("current", { packages: ["corechart"] });
// google.setOnLoadCallback(reporte_totales);
const reporte_totales = (id) => {
	$.post(
		"/cursos/reporte_totales_curso",
		{
			id,
		},
		function (response) {
			$("#descargar_recaudacion_total").removeAttr("id-course");
			$("#descargar_recaudacion_total").attr("id-course", id);
			generar_grafico(response);
			$("#modal-title-totales").html(response.nombre_curso);
			$("#modal_imprimir_totales").modal({
				backdrop: "static",
				keyboard: true,
			});
		}
	);
};

function generar_grafico(res) {
	// INSCRITOS
	let data = new google.visualization.DataTable();
	data.addColumn("string", "Tipo Pago");
	data.addColumn("number", "Monto");
	let total_inscritos = 0;
	$.each(res.inscritos, function (i, res) {
		var tipo_pago = res.tipo_pago;
		var monto_total = parseInt($.trim(res.monto_total));
		total_inscritos = total_inscritos + parseInt($.trim(res.monto_total));
		data.addRows([[tipo_pago, monto_total]]);
	});

	$("#total_reacudacion_inscritos").html(total_inscritos + " Bs.");

	var options = {
		title: "REPORTE ECONÓMICO TOTAL INSCRITOS",
		is3D: true,
		bar: {
			groupWidth: "100%",
		},
		height: "270",
		width: "370",
	};

	var chart = new google.visualization.PieChart(
		document.getElementById("piechart_3d_inscritos")
	);

	chart.draw(data, options);

	// PREINSCRITOS

	var options1 = {
		title: "REPORTE ECONÓMICO TOTAL PREINSCRITOS",
		is3D: true,
		bar: {
			groupWidth: "100%",
		},
		height: "270",
		width: "370",
	};
	// var data1 = google.visualization.arrayToDataTable([
	// 	["Tipo Pago", "Monto"],
	// 	["DEPÓSITO BANCARIO", 3000],
	// 	["PAGO EFECTIVO", 4500],
	// 	["TIGO MONEY", 0],
	// ]);
	let data1 = new google.visualization.DataTable();
	data1.addColumn("string", "Tipo Pago");
	data1.addColumn("number", "Monto");
	let total_preinscritos = 0;
	$.each(res.preinscritos, function (i, res) {
		var tipo_pago = res.tipo_pago;
		var monto_total = parseInt($.trim(res.monto_total));
		total_preinscritos = total_preinscritos + parseInt($.trim(res.monto_total));
		data1.addRows([[tipo_pago, monto_total]]);
	});

	$("#total_reacudacion_preinscritos").html(total_preinscritos + " Bs.");

	var chart1 = new google.visualization.PieChart(
		document.getElementById("piechart_3d_preinscritos")
	);

	chart1.draw(data1, options1);
}

jQuery(document).ready(function () {
	$("#descargar_recaudacion_total").on("click", function (e) {
		$("#modal_imprimir_totales").modal("hide");
		e.preventDefault();
		let id = $(this).attr("id-course");
		$.post(
			"/cursos/reporte_totales_pdf",
			{
				id,
			},
			function (response) {
				if (typeof response.error != "undefined") {
					Swal.fire("Error!", response.error, "error");
				} else {
					$("#modal-title-certificado").html("REPORTE DE RECAUDACIONES");
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
});
