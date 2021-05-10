"use strict";
let tbl_configuracion_curso;
var KTDatatablesConfiguracion = (function () {
	var init = function () {
		tbl_configuracion_curso = $("#tbl_configuracion_curso");

		// begin first tbl_configuracion_curso
		tbl_configuracion_curso
			.DataTable({
				processing: true,
				serverSide: true,
				ajax: "/configuracion/ajax_configuracion_curso",
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
							$("#inversion").val(response.exito[0].inversion);
							$("#celular_referencia").val(
								response.exito[0].celular_referencia
							);

							let colores = null;
							if (response.exito[0].color_nombre_participante != null) {
								colores = response.exito[0].color_nombre_participante.split(
									", "
								);
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
	KTDatatablesConfiguracion.init();
});
