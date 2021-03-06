"use strict";
let tbl_modulos;
var KTDatatablesVerModulos = (function () {
	var init = function () {
		tbl_modulos = $("#tbl_modulos");
		// begin first tbl_modulos
		tbl_modulos
			.DataTable({
				processing: true,
				ajax: "/modulos/ajax_ver_modulos",
				lengthMenu: [
					[10, 20, 30, 50, 100, -1],
					[10, 20, 30, 50, 100, "Todos"],
				],
				iDisplayLength: 10,
				sortable: true,
				retrieve: true,
				paging: true,
				responsive: true,
			})
			.on("click", "a#btn_editar", function (e) {
				let id = $(this).attr("data-id");
				$.post("/modulos/editar", { id }, function (response) {
					$("#id_certificacion").val(response[0].id_certificacion);
					$("#id_curso").val(response[0].id_course).trigger("change");
					$("#nombre").val(response[0].nombre);
					$("#fecha_inicial").val(response[0].fecha_inicial);
					$("#fecha_final").val(response[0].fecha_final);
					$("#carga_horaria").val(response[0].carga_horaria);
					$("#posx_imagen_modulo").val(response[0].posx_imagen_modulo);
					$("#posy_imagen_modulo").val(response[0].posy_imagen_modulo);
					$("#fecha_certificacion").val(response[0].fecha_certificacion);

					if (response[0].color_titulo != null) {
						let colores = response[0].color_titulo.split(", ");
						$("#color_titulo").val(
							RGB2Color(colores[0], colores[1], colores[2])
						);
					} else {
						$("#color_titulo").val("#000000");
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

					$("#title_modulo").html("Editar Módulo");
					$("#btn_title").html("Editar");
					$("#modal_modulos").modal({
						backdrop: "static",
						keyboard: false,
					});
				});
			})
			.on("click", "a#btn_eliminar", function (e) {
				let id = $(this).attr("data-id");
				Swal.fire({
					title: "¿Estas seguro de eliminar?",
					text: "Esta accion no se puede revertir",
					icon: "warning",
					showCancelButton: true,
					buttonsStyling: false,
					confirmButtonText: "Si, Eliminar!",
					cancelButtonText: "No, cancelar",
					customClass: {
						confirmButton: "btn font-weight-bold btn-primary",
						cancelButton: "btn font-weight-bold btn-default",
					},
				}).then(function (result) {
					if (result.value) {
						$.post("/modulos/eliminar", { id }, function (response) {
							if (typeof response.exito != "undefined") {
								Swal.fire("Exito!", response.exito, "success");
								tbl_modulos.DataTable().ajax.reload();
							}
							if (typeof response.error != "undefined") {
								tbl_modulos.DataTable().ajax.reload();
								Swal.fire("Error!", response.error, "error");
							}
						});
					} else if (result.dismiss === "cancel") {
						Swal.fire({
							text: "No se ha eliminado el modulo",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok",
							customClass: {
								confirmButton: "btn font-weight-bold btn-primary",
							},
						});
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
	$("#id_curso").select2({
		placeholder: "-- seleccione curso --",
		width: "100%",
	});

	$("#btn_agregar_modulo").on("click", function () {
		$("#title_modulo").html("Agregar Módulo");
		$("#btn_title").html("Guardar");
		$("#modal_modulos").modal({
			backdrop: "static",
			keyboard: false,
		});
	});

	var arrayfiles4 = [];
	$(".multimediaFisica4").dropzone({
		url: "/configuracion/subir_imagen_curso",
		addRemoveLinks: true,
		acceptedFiles: "image/jpeg, image/png",
		maxFilesize: 10, //2mb
		maxFiles: 1,
		init: function () {
			this.on("addedfile", function (file) {
				arrayfiles4.push(file);
				// console.log(arrayfiles4);
			});

			this.on("removedfile", function (file) {
				var index = arrayfiles4.indexOf(file);
				arrayfiles4.splice(index, 1);
				// console.log(arrayfiles4);
			});
		},
	});

	$("#frm_agregar_modulo").submit(function (e) {
		e.preventDefault();
		let data = new FormData($(this)[0]);
		if (arrayfiles4.length == 1) {
			data.append("imagen_modulo", arrayfiles4[0].dataURL);
		}
		$.ajax({
			type: "POST",
			url: "/modulos/guardar_modulo",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
		}).done(function (response) {
			if (typeof response.exito != "undefined") {
				Swal.fire({
					title: response.exito,
					icon: "success",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
				tbl_modulos.DataTable().ajax.reload();
				limpiar_campos();
				$("#modal_modulos").modal("hide");
			}
			if (typeof response.error != "undefined") {
				Swal.fire({
					title: response.error,
					icon: "error",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
				$("#modal_modulos").modal("hide");
			}
			if (typeof response.warning != "undefined") {
				Swal.fire({
					title: response.warning,
					icon: "info",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
			}
		});
	});

	const limpiar_campos = () => {
		$("#id_certificacion").val("");
		$("#id_course").val("");
		$("#nombre").val("");
		$("#fecha_inicial").val("");
		$("#fecha_final").val("");
		$("#carga_horaria").val("");
		$("#fecha_certificacion").val("");
		$("#posx_imagen_modulo").val("");
		$("#posy_imagen_modulo").val("");
		$("#color_titulo").val("");
	};

	KTDatatablesVerModulos.init();
});
