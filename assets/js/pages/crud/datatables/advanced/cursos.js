"use strict";
let inscripcion_curso;
var KTDatatablesCursos = (function () {
	var init = function () {
		var tbl_cursos = $("#tbl_cursos");

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
			})
			.on("click", "#btn_inscripcion", function (e) {
				// console.log("inscripcion");
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
						Swal.fire("Exito!", response.exito, "success");
					}
					if (typeof response.error != "undefined") {
						Swal.fire("Error!", response.error, "error");
					}

					if (typeof response.warning != "undefined") {
						Swal.fire("Advertencia!", response.warning, "warning");
					}
				});
			})
			.on("click", "#btn_ver_inscritos", function (e) {
				let id = $(this).attr("data-id");
				inscripcion_curso = $("#ver_inscripcion_curso");
				inscripcion_curso
					.DataTable({
						scrollX: true,
						responsive: true,
						ajax: {
							url: "/cursos/ajax_listado_estudiantes_curso",
							type: "POST",
							data: {
								id,
							},
						},
						lengthMenu: [
							[10, 20, 30, 50, 100, -1],
							[10, 20, 30, 50, 100, "Todos"],
						],
						iDisplayLength: 10,
						order: [[1, "asc"]],
					})
					.on("click", "#editar_inscripcion_curso", function () {
						let id = $(this).attr("data-id");
						let nombre = $(this).attr("data-nombre");
						$("#modal-title-editar").html("Estudiante: " + nombre);
						$.post(
							"/cursos/editar_conf_curso",
							{
								id,
							},
							function (response) {
								// console.log(response);
								$("#id_inscripcion_curso").val(
									response.exito[0].id_inscripcion_curso
								);
								$("#usuario").val(response.exito[0].usuario);
								$("#calificacion_final").val(
									response.exito[0].calificacion_final
								);
								$("#tipo_pago").val(response.exito[0].tipo_pago);
								$("#nro_transaccion").val(response.exito[0].nro_transaccion);
								$("#monto_pago").val(response.exito[0].monto_pago);
								$("#tipo_certificacion_solicitado").val(
									response.exito[0].tipo_certificacion_solicitado
								);
								$("#img-preview").attr(
									"src",
									window.location.origin + "/" + response.exito[0].respaldo_pago
								);
								// $('#respaldo_pago').val(response.exito[0].respaldo_pago);
								$("#tipo_participacion").val(
									response.exito[0].tipo_participacion
								);
								if (response.exito[0].fecha_entrega !== null) {
									$("#fecha_entrega").val(
										response.exito[0].fecha_entrega.split(" ")[0]
									);
								}
								$("#entregado_a").val(response.exito[0].entregado_a);
								$("#observacion_entrega").val(
									response.exito[0].observacion_entrega
								);
								$("#modal_editar_inscripcion").modal({
									backdrop: "static",
									keyboard: false,
								});
							}
						);
					})
					.on("change", "#estado_inscripcion_curso", function () {
						let id = $(this).attr("data-id");
						let valor = $(this).val();
						Swal.fire({
							title: "Estas seguro de cambiar de estado?",
							text: "Esta accion no puede ser revertido",
							icon: "warning",
							showCancelButton: true,
							confirmButtonText: "Si, Cambiar!",
							cancelButtonText: "No, Cancelar!",
							reverseButtons: true,
						}).then(function (result) {
							if (result.value) {
								$.post(
									"/cursos/estado_inscripcion_curso",
									{
										id,
										valor,
									},
									function (response) {
										if (typeof response.exito != "undefined") {
											Swal.fire("Exito!", response.exito, "success");
											inscripcion_curso.DataTable().ajax.reload();
										}
										if (typeof response.error != "undefined") {
											Swal.fire("Error!", response.error, "error");
										}
									}
								);
							} else if (result.dismiss === "cancel") {
								Swal.fire(
									"Cancelado",
									"La configuracion del curso esta a salvo :)",
									"error"
								);
							}
						});
					})
					.on("click", "#imprimir_certificado", function () {
						let id = $(this).attr("data-id");
						let idcurso = $(this).attr("data-curso");
						$.post(
							"/cursos/imprimir_certificado",
							{
								id,
								idcurso,
							},
							function (resp) {
								if (typeof resp.error != "undefined") {
									Swal.fire("Error!", resp.error, "error");
								} else {
									$("#modal-body-certificado").children().remove();
									$("#modal-body-certificado").html(
										'<embed src="data:application/pdf;base64,' +
											resp +
											'#toolbar=1&navpanes=1&scrollbar=1&zoom=67,100,100" type="application/pdf" width="100%" height="600px" style="border: none;"/>'
									);
									$("#modal_imprimir_certificado").modal({
										backdrop: "static",
										keyboard: true,
									});
								}
							}
						);
					})
					.on("change", "#certificacion_unica", function () {
						let id = $(this).attr("data-id");
						let valor = $(this).val();
						Swal.fire({
							title: "Estas seguro de cambiar de estado de certificacion unica?",
							text: "Esta accion no puede ser revertido",
							icon: "warning",
							showCancelButton: true,
							confirmButtonText: "Si, Cambiar!",
							cancelButtonText: "No, Cancelar!",
							reverseButtons: true,
						}).then(function (result) {
							if (result.value) {
								$.post(
									"/cursos/certificacion_unica",
									{
										id,
										valor,
									},
									function (response) {
										if (typeof response.exito != "undefined") {
											Swal.fire("Exito!", response.exito, "success");
											// inscripcion_curso.DataTable().ajax.reload();
										}
										if (typeof response.error != "undefined") {
											Swal.fire("Error!", response.error, "error");
										}
									}
								);
							} else if (result.dismiss === "cancel") {
								Swal.fire(
									"Cancelado",
									"No se ha cambiado el estado de certificacion unica :)",
									"error"
								);
							}
						});
					})

				//mostrar modal
				$("#modal_inscripcion").modal({
					backdrop: "static",
					keyboard: false,
				});
			})
			.on("click", "#btn_imprimir_todos", function (e) {
				let id = $(this).attr("data-id");

				$.post(
					"/cursos/imprimir_certificado_todos",
					{
						id,
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
			})
			.on("click", "#btn_imprimir_blanco", function (e) {
				let id = $(this).attr("data-id");

				$.post(
					"/cursos/imprimir_certificado_blanco",
					{
						id,
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

jQuery(document).ready(function () {
	$("#frm_editar_inscripcion").on("submit", function (e) {
		e.preventDefault();
		let formData = new FormData($("#frm_editar_inscripcion")[0]);
		$.ajax({
			type: "POST",
			url: "/cursos/actualizar_conf_curso",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
		}).done(function (response) {
			$("#modal_editar_inscripcion").modal("hide");
			if (typeof response.exito != "undefined") {
				Swal.fire("Exito!", response.exito, "success");
				inscripcion_curso.DataTable().ajax.reload();
			}
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			}
		});
	});

	$("#cerrar_modal_inscripcion").on("click", function (e) {
		let inscripcion_curso = $("#ver_inscripcion_curso").DataTable();
		inscripcion_curso.destroy();
	});

	$("#respaldo_pago").on("change", function (event) {
		var output = document.getElementById("img-preview");
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function () {
			URL.revokeObjectURL(output.src); // free memory
		};
	});

	KTDatatablesCursos.init();
});
