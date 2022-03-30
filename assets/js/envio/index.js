var tbl_envios;
var KTDatatableEnvio = (function () {
	var init = function () {
		tbl_envios = $("#tbl_envios");

		// begin first tbl_envios
		tbl_envios
			.DataTable({
				paging: true,
				ajax: {
					type: "POST",
					url: "/cursos/ajax_envio_curso",
					data: { id: $("#id_curso_envio").val() },
				},
				lengthMenu: [
					[10, 20, 30, 50, 100, -1],
					[10, 20, 30, 50, 100, "Todos"],
				],
				iDisplayLength: -1,
				responsive: true,
				sortable: true,
				// layout definition
				layout: {
					scroll: false,
					footer: false,
				},
				pagination: true,
			})
			.on("change", "#estado_envio", function (e) {
				let id = $(this).attr("data-id");
				let valor = $(this).val();
				$.post(
					"/cursos/ajax_estado_envio",
					{
						id,
						valor,
					},
					function (response) {
						if (response.exito) {
							Swal.fire("Exito!", response.exito, "success");
							tbl_envios.DataTable().ajax.reload();
						}
						if (response.error) {
							Swal.fire("Error!", response.error, "error");
						}
					}
				);
			})
			.on("click", "#btn_editar_envio", function (e) {
				let id = $(this).attr("data-id");
				let remitente = $(this).attr("data-remitente");
				let nombre = $(this).attr("data-nombre");
				let celular = $(this).attr("data-celular");
				let direccion = $(this).attr("data-direccion");
				let departamento = $(this).attr("data-departamento");

				$("#editar_id").val(id);
				$("#editar_remitente").val(remitente);
				$("#editar_nombre").val(nombre);
				$("#editar_celular").val(celular);
				$("#editar_direccion").val(direccion);
				$("#editar_departamento").val(departamento);

				$("#modal_editar_envio").modal("show");
			});
		// .on("click", "#btn_enviar_informacion", function () {
		// 	let id = $(this).attr("data-id");
		// 	let nombre = "";
		// 	let curso = "";
		// 	// traer datos del estudiante y curso para mostrar
		// 	$.post(
		// 		"/inscripcion/datos_estudiante_curso",
		// 		{
		// 			id,
		// 		},
		// 		function (response) {
		// 			let correo = response.exito[0].estado_correo;
		// 			if (typeof response.exito != "undefined") {
		// 				nombre = response.exito[0].nombre_completo;
		// 				curso = response.exito[0].curso;
		// 				let msg =
		// 					correo == "1"
		// 						? "¿Confirme si desea enviar el correo nuevamente?"
		// 						: "¿Si todo esta bien?. Por favor confirme el envio del correo";
		// 				Swal.fire({
		// 					title: `${msg}`,
		// 					html: `<strong>PRE-INSCRITO:</strong> ${nombre} <br><strong>AL CURSO:</strong> ${curso}`,
		// 					icon: "warning",
		// 					showCancelButton: true,
		// 					buttonsStyling: false,
		// 					confirmButtonText: "Si, enviar!",
		// 					cancelButtonText: "No, cancelar",
		// 					customClass: {
		// 						confirmButton: "btn font-weight-bold btn-primary",
		// 						cancelButton: "btn font-weight-bold btn-default",
		// 					},
		// 				}).then(function (result) {
		// 					if (result.value) {
		// 						$.post(
		// 							"/inscripcion/enviar_correo_personal",
		// 							{
		// 								id: id,
		// 							},
		// 							function (response) {
		// 								if (typeof response.exito != "undefined") {
		// 									Swal.fire("Exito!", response.exito, "success");
		// 									tbl_envios.DataTable().ajax.reload();
		// 								}
		// 								if (typeof response.error != "undefined") {
		// 									Swal.fire("Error!", response.error, "error");
		// 								}
		// 								if (typeof response.warning != "undefined") {
		// 									Swal.fire("Advertencia!", response.warning, "info");
		// 								}
		// 							}
		// 						);
		// 					} else if (result.dismiss === "cancel") {
		// 						Swal.fire({
		// 							text: "No se ha enviado el correo!.",
		// 							icon: "error",
		// 							buttonsStyling: false,
		// 							confirmButtonText: "Ok",
		// 							customClass: {
		// 								confirmButton: "btn font-weight-bold btn-primary",
		// 							},
		// 						});
		// 					}
		// 				});
		// 			}
		// 		}
		// 	);

		// 	// console.log(id + " confirmar inscripcion");
		// })
		// .on("change", "select#estado_contacto", function () {
		// 	let id = $(this).attr("data-id");
		// 	let data = $(this).val();
		// 	let nombre = "";
		// 	let curso = "";
		// 	// traer datos del estudiante y curso para mostrar
		// 	$.post(
		// 		"/inscripcion/datos_estudiante_curso",
		// 		{
		// 			id,
		// 		},
		// 		function (response) {
		// 			if (typeof response.exito != "undefined") {
		// 				nombre = response.exito[0].nombre_completo;
		// 				curso = response.exito[0].curso;
		// 				Swal.fire({
		// 					title:
		// 						"¿Si todo esta bien ?. Por favor confirme el cambio de estado!",
		// 					html: `<strong>NOMBRE: </strong> ${nombre} <br><strong>AL CURSO:</strong> ${curso}<br>¡Esta acción no se puede deshacer!`,
		// 					icon: "warning",
		// 					showCancelButton: true,
		// 					buttonsStyling: false,
		// 					confirmButtonText: "Si, confirmar!",
		// 					cancelButtonText: "No, cancelar",
		// 					customClass: {
		// 						confirmButton: "btn font-weight-bold btn-primary",
		// 						cancelButton: "btn font-weight-bold btn-default",
		// 					},
		// 				}).then(function (result) {
		// 					if (result.value) {
		// 						$.post(
		// 							"/inscripcionadmin/confirmar_cambio_estado_contacto",
		// 							{
		// 								id: id,
		// 								data: data,
		// 							},
		// 							function (response) {
		// 								if (typeof response.exito != "undefined") {
		// 									Swal.fire("Exito!", response.exito, "success");
		// 									tbl_envios.DataTable().ajax.reload();
		// 								}
		// 								if (typeof response.error != "undefined") {
		// 									tbl_envios.DataTable().ajax.reload();
		// 									Swal.fire("Error!", response.error, "error");
		// 								}
		// 							}
		// 						);
		// 					} else if (result.dismiss === "cancel") {
		// 						tbl_envios.DataTable().ajax.reload();
		// 						Swal.fire({
		// 							text: "No se ha confirmado el cambio de estado!.",
		// 							icon: "error",
		// 							buttonsStyling: false,
		// 							confirmButtonText: "Ok",
		// 							customClass: {
		// 								confirmButton: "btn font-weight-bold btn-primary",
		// 							},
		// 						});
		// 					}
		// 				});
		// 			}
		// 		}
		// 	);
		// });

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

jQuery(document).ready(function () {
	KTDatatableEnvio.init();

	$("#agregar_participantes").on("click", function (e) {
		e.preventDefault();
		let id = $(this).attr("data-id");
		// console.log(id);

		// datatable
		let tbl_envios_certificados = $("#tbl_estudiantes_envio");
		tbl_envios_certificados
			.DataTable({
				ajax: {
					type: "GET",
					url: "/cursos/listar_participantes_curso",
					data: { id: id },
				},
				lengthMenu: [
					[5, 10, 20, 30, 50, 100, -1],
					[5, 10, 20, 30, 50, 100, "Todos"],
				],
				iDisplayLength: -1,
				sortable: true,
				layout: {
					scroll: true,
					footer: true,
				},
				pagination: true,
				destroy: true,
			})
			.on("click", "button.add", function (e) {
				$("#id_envio_preinscripcion").val(
					$(this).attr("data-id-preinscripcion")
				);
				$("#nombre_persona_envio").val(
					$(this).attr("data-participante-preinscripcion")
				);
				$("#celular_persona_envio").val(
					$(this).attr("data-celular-preinscripcion")
				);
				$("#departamento_persona_envio").val(
					$(this).attr("data-departamento-preinscripcion")
				);
				$("#modal_agregar_envio").modal("show");
			});

		$("#modal_estudiantes").modal("show");
	});

	$("#frm-guardar-envio").on("submit", function (e) {
		e.preventDefault();
		let form = $(this);
		let url = form.attr("action");
		let data = form.serialize();
		$.post(url, data, function (response) {
			if (typeof response.exito != "undefined") {
				Swal.fire("Exito!", response.exito, "success");
				$("#modal_agregar_envio").modal("hide");
				tbl_envios.DataTable().ajax.reload();
			}
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			}
			limpiar_campos();
		});
	});

	const limpiar_campos = () => {
		$("#nombre_persona_envio").val("");
		$("#id_envio_preinscripcion").val("");
		$("#celular_persona_envio").val("");
		$("#direccion_persona_envio").val("");
		$("#departamento_persona_envio").val("");
	};

	$("#clear-envio").on("click", function (e) {
		e.preventDefault();
		limpiar_campos();
		$("#modal_agregar_envio").modal("hide");
	});

	$("#frm-editar-envio").on("submit", function (e) {
		e.preventDefault();
		let form = $(this);
		let url = form.attr("action");
		let data = form.serialize();
		$.post(url, data, function (response) {
			if (typeof response.exito != "undefined") {
				Swal.fire("Exito!", response.exito, "success");
				$("#modal_editar_envio").modal("hide");
				tbl_envios.DataTable().ajax.reload();
			}
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			}
		});
	});

	$("#imprimir_envios").on("click", function (e) {
		let id = $(this).attr("data-id");
		if (id != null || id != "") {
			window.open("/cursos/reporte_envios/" + id, "_blank");
		} else {
			swal({
				html: true,
				title: "Adventencia!!!",
				text: "Error al descargar el archivo para envíos",
				type: "warning",
			});
		}
	});
});
