"use strict";
let tbl_configuracion_curso;
var KTDatatablesConfiguracion = (function () {
	var init = function () {
		tbl_configuracion_curso = $("#tbl_configuracion_curso");

		// begin first tbl_configuracion_curso
		tbl_configuracion_curso
			.DataTable({
				processing: true,
				ajax: { url: "/configuracion/ajax_configuracion_curso", type: "POST" },
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
				// order by datatables
				order: [[0, "desc"]],
			})
			.on("click", "#btn_editar_conf", function () {
				let id = $(this).attr("data-id");
				let titulo = $(this).attr("titulo");

				$.post(
					"/configuracion/editar_configuracion",
					{
						id,
					},
					function (response) {
						// console.log(response);
						if (typeof response.exito != "undefined") {
							$("#modal-title-conf").html(titulo);
							/** falta imagen */
							$("#id_configuracion_curso").val(
								response.exito[0].id_configuracion_curso
							);
							$("#nota_aprobacion").val(response.exito[0].nota_aprobacion);
							$("#fecha_inicial").val(response.exito[0].fecha_inicial);
							$("#limite_inscripcion").val(
								response.exito[0].limite_inscripcion
							);
							$("#fecha_final").val(response.exito[0].fecha_final);
							$("#carga_horaria").val(response.exito[0].carga_horaria);
							$("#fecha_certificacion").val(
								response.exito[0].fecha_certificacion
							);
							$("#fecha_creacion").val(response.exito[0].fecha_creacion);
							$("#posx_nombre_participante").val(
								response.exito[0].posx_nombre_participante
							);
							$("#posy_nombre_participante").val(
								response.exito[0].posy_nombre_participante
							);
							$("#posx_bloque_texto").val(response.exito[0].posx_bloque_texto);
							$("#posy_bloque_texto").val(response.exito[0].posy_bloque_texto);
							$("#posx_nombre_curso").val(response.exito[0].posx_nombre_curso);
							$("#posy_nombre_curso").val(response.exito[0].posy_nombre_curso);
							$("#posx_qr").val(response.exito[0].posx_qr);
							$("#posy_qr").val(response.exito[0].posy_qr);
							$("#posx_tipo_participacion").val(
								response.exito[0].posx_tipo_participacion
							);
							$("#posy_tipo_participacion").val(
								response.exito[0].posy_tipo_participacion
							);
							$("#fuente_pdf").val(response.exito[0].fuente_pdf);
							$("#tamano_titulo").val(response.exito[0].tamano_titulo);
							$("#tamano_subtitulo").val(response.exito[0].tamano_subtitulo);
							$("#tamano_texto").val(response.exito[0].tamano_texto);

							$("#detalle_curso").val(response.exito[0].detalle_curso);
							$("#horario").val(response.exito[0].horario);
							$("#inversion").val(response.exito[0].inversion);
							$("#descuento").val(response.exito[0].descuento);
							$("#proximo_curso").val(response.exito[0].proximo_curso);
							$("#orientacion").val(response.exito[0].orientacion);
							$("#fecha_inicio_lanzamiento").val(
								response.exito[0].fecha_inicio_lanzamiento
							);
							$("#fecha_fin_lanzamiento").val(
								response.exito[0].fecha_fin_lanzamiento
							);
							$("#fecha_inicio_descuento").val(
								response.exito[0].fecha_inicio_descuento
							);
							$("#fecha_fin_descuento").val(
								response.exito[0].fecha_fin_descuento
							);
							$("#celular_referencia").val(
								response.exito[0].celular_referencia
							);

							let colores = null;
							if (response.exito[0].color_nombre_participante != null) {
								colores =
									response.exito[0].color_nombre_participante.split(", ");
								$("#color_nombre_participante").val(
									RGB2Color(colores[0], colores[1], colores[2])
								);
							} else {
								$("#color_nombre_participante").val("#000000");
							}

							if (response.exito[0].color_subtitulo != null) {
								colores = response.exito[0].color_subtitulo.split(", ");
								$("#color_subtitulo").val(
									RGB2Color(colores[0], colores[1], colores[2])
								);
							} else {
								$("#color_subtitulo").val("#000000");
							}

							function RGB2Color(r, g, b) {
								return "#" + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
							}

							function byte2Hex(n) {
								var nybHexString = "0123456789ABCDEF";
								return (
									String(nybHexString.substr((n >> 4) & 0x0f, 1)) +
									nybHexString.substr(n & 0x0f, 1)
								);
							}

							$("#modal_editar_conf").modal({
								backdrop: "static",
								keyboard: false,
							});
						} else if (typeof response.error != "undefined") {
							Swal.fire("Error!", response.error, "error");
						}
					}
				);
			})
			.on("click", "#btn_eliminar_conf", function () {
				let id = $(this).attr("data-id");

				Swal.fire({
					title: "Estas seguro de eliminar la configuracion del curso?",
					text: "Esta accion no puede ser revertido",
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: "Si, Eliminar!",
					cancelButtonText: "No, Cancelar!",
					reverseButtons: true,
				}).then(function (result) {
					if (result.value) {
						$.post(
							"/configuracion/eliminar_configuracion",
							{
								id,
							},
							function (response) {
								if (typeof response.exito != "undefined") {
									Swal.fire("Exito!", response.exito, "success");
									tbl_configuracion_curso.DataTable().ajax.reload();
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
			.on("click", "#btn_agregar_img_sub", function () {
				let id = $(this).attr("data-id");
				let titulo = $(this).attr("titulo");

				$.post(
					"/configuracion/edit_agregar_imagen_personalizado",
					{
						id,
					},
					function (response) {
						// console.log(response);
						if (typeof response.exito != "undefined") {
							$("#modal-title-agregar").html(
								"Agregar Imagen Personalizado al curso: " + titulo
							);
							/** falta imagen */
							$("#id").val(response.exito[0].id_configuracion_curso);

							$("#posx_imagen_personalizado").val(
								response.exito[0].posx_imagen_personalizado
							);
							$("#posy_imagen_personalizado").val(
								response.exito[0].posy_imagen_personalizado
							);

							if (response.exito[0].imprimir_subtitulo == "1") {
								$("#imprimir_subtitulo").prop("checked", true);
								$("#subtitulo").val(response.exito[0].subtitulo);
								$("#subtitulo").show();
							} else {
								$("#imprimir_subtitulo").prop("checked", false);
								$("#subtitulo").val(response.exito[0].subtitulo);
								$("#subtitulo").hide();
							}

							$("#modal_agregar_imagen_per").modal({
								backdrop: "static",
								keyboard: false,
							});
						} else if (typeof response.error != "undefined") {
							Swal.fire("Error!", response.error, "error");
						}
					}
				);
			})
			.on("click", "#btn_terminar", function () {
				let id = $(this).attr("data-id");

				Swal.fire({
					title: "Estas seguro de terminar la configuracion del curso?",
					text: "Esta accion solo el administrador lo puede revertir",
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: "Si, terminar!",
					cancelButtonText: "No, Cancelar!",
					reverseButtons: true,
				}).then(function (result) {
					if (result.value) {
						$.post(
							"/configuracion/terminar_configuracion",
							{
								id,
							},
							function (response) {
								if (typeof response.exito != "undefined") {
									Swal.fire("Exito!", response.exito, "success");
									tbl_configuracion_curso.DataTable().ajax.reload();
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
	var arrayfiles = [];
	$(".multimediaFisica").dropzone({
		url: "/configuracion/subir_imagen_curso",
		addRemoveLinks: true,
		acceptedFiles: "image/jpeg, image/png",
		maxFilesize: 10, //2mb
		maxFiles: 1,
		init: function () {
			this.on("addedfile", function (file) {
				arrayfiles.push(file);
				// console.log(arrayfiles);
			});

			this.on("removedfile", function (file) {
				var index = arrayfiles.indexOf(file);
				arrayfiles.splice(index, 1);
				// console.log(arrayfiles);
			});
		},
	});

	var arrayfiles1 = [];
	$(".multimediaFisica1").dropzone({
		url: "/configuracion/subir_imagen_curso",
		addRemoveLinks: true,
		acceptedFiles: "image/jpeg, image/png",
		maxFilesize: 5, //2mb
		maxFiles: 1,
		init: function () {
			this.on("addedfile", function (file) {
				arrayfiles1.push(file);
				// console.log(arrayfiles1);
			});

			this.on("removedfile", function (file) {
				var index = arrayfiles1.indexOf(file);
				arrayfiles1.splice(index, 1);
				// console.log(arrayfiles1);
			});
		},
	});

	var arrayfiles3 = [];
	let img3 = $(".multimediaFisica3").dropzone({
		url: "/configuracion/subir_imagen_curso",
		addRemoveLinks: true,
		acceptedFiles: "image/jpeg, image/png",
		maxFilesize: 10, //2mb
		maxFiles: 1,
		init: function () {
			this.on("addedfile", function (file) {
				arrayfiles3.push(file);
				// console.log(arrayfiles3);
			});

			this.on("removedfile", function (file) {
				var index = arrayfiles3.indexOf(file);
				arrayfiles3.splice(index, 1);
				// console.log(arrayfiles3);
			});
		},
	});

	$("#actualizar_configuracion").on("submit", function (e) {
		e.preventDefault();
		let formData = new FormData($("#actualizar_configuracion")[0]);
		if (arrayfiles.length == 1) {
			formData.append("imagen_curso", arrayfiles[0].dataURL);
		}

		if (arrayfiles1.length == 1) {
			formData.append("banner_curso", arrayfiles1[0].dataURL);
		}
		$.ajax({
			type: "POST",
			url: "/configuracion/actualizar_configuracion_curso",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
		}).done(function (response) {
			$("#modal_editar_conf").modal("hide");

			if (typeof response.exito != "undefined") {
				Swal.fire("Exito!", response.exito, "success");
				tbl_configuracion_curso.DataTable().ajax.reload();
			}
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			}
		});
	});

	// cambio de imprimir checkbox
	$("#subtitulo").hide();
	let imp_sub = 0;
	$("input[name=imprimir_subtitulo]").change(function () {
		if ($(this).prop("checked")) {
			$("#subtitulo").show();
			imp_sub = 1;
		} else {
			$("#subtitulo").hide();
			imp_sub = 0;
		}
	});

	// GUARDAR IMG PERSONALIZADO
	$("#agregar_img_personalizado").on("submit", function (e) {
		e.preventDefault();
		let formData = new FormData($("#agregar_img_personalizado")[0]);
		formData.append("imprimir", imp_sub);
		if (arrayfiles3.length == 1) {
			formData.append("imagen_personalizado", arrayfiles3[0].dataURL);
		}

		$.ajax({
			type: "POST",
			url: "/configuracion/update_agregar_imagen_personalizado",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
		}).done(function (response) {
			$("#modal_agregar_imagen_per").modal("hide");

			if (typeof response.exito != "undefined") {
				Swal.fire("Exito!", response.exito, "success");
				limpiar2();
				tbl_configuracion_curso.DataTable().ajax.reload();
			}
			if (typeof response.error != "undefined") {
				Swal.fire("Error!", response.error, "error");
			}
		});
	});

	KTDatatablesConfiguracion.init();

	const limpiar2 = () => {
		$("#id").val("");
		$("#posx_imagen_personalizado").val("");
		$("#posy_imagen_personalizado").val("");
		$("#imprimir_subtitulo").prop("checked", false);
		$("#subtitulo").hide();
		$("#subtitulo").val("");
		arrayfiles3 = [];
	};
});
