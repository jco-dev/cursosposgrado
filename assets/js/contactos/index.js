"use strict";
var tbl_contactos
var KTDatatablesContactos = (function () {
	var init = function () {
		tbl_contactos = $("#tbl_contactos");

		tbl_contactos
			.DataTable({
				processing: true,
				serverSide: true,
				ajax: "/contactos/ajax_listado_contactos",
				lengthMenu: [
					[10, 20, 30, 50, 100, -1],
					[10, 20, 30, 50, 100, "Todos"],
				],
				iDisplayLength: 30,
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
			.on("click", "a#btn_editar_contacto", function (e) {
				let id = $(this).attr("data-id");
				$.post("/contactos/editar", { id }, function (response) {
					$("#id_contacto").val(response[0].id_contacto);
					$("#nombre").val(response[0].nombre);
					$("#paterno").val(response[0].paterno);
					$("#materno").val(response[0].materno);
					$("#celular").val(response[0].celular);
					$("#email").val(response[0].email);

					$("#modal-title-contacto").html("Editar Contacto");
					$("#btn_contacto_form").html("Editar");
					$("#modal_contacto").modal({
						backdrop: "static",
						keyboard: false,
					});
				});
			})
			.on("click", "a#btn_eliminar_contacto", function (e) {
				let id = $(this).attr("data-id");
				Swal.fire({
					title:"¿Estas seguro de eliminar al contacto?",
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
						$.post("/contactos/eliminar", { id }, function (response) {
							if (typeof response.exito != "undefined") {
								Swal.fire("Exito!", response.exito, "success");
								tbl_contactos.DataTable().ajax.reload();
							}
							if (typeof response.error != "undefined") {
								tbl_contactos.DataTable().ajax.reload();
								Swal.fire("Error!", response.error, "error");
							}
						});
					}else if (result.dismiss === "cancel") {
						Swal.fire({
							text: "No se ha eliminado el contacto",
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
	// Agregar un contacto
	$("#btn_agregar_contacto").on('click', function(e){
		$("#modal-title-contacto").html("Agregar Conctacto");
		$("#btn_contacto_form").html("Guardar");
		$("#modal_contacto").modal({
			backdrop: "static",
			keyboard: false,
		});
	});

	$("#frm_agregar_contacto").submit(function (e) {
		e.preventDefault();
		let data = new FormData($(this)[0]);
		$.ajax({
			type: "POST",
			url: "/contactos/guardar_contacto",
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
				tbl_contactos.DataTable().ajax.reload();
				limpiar_campos();
				$("#modal_contacto").modal("hide");
			}
			if (typeof response.error != "undefined") {
				Swal.fire({
					title: response.error,
					icon: "error",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
				$("#modal_contacto").modal("hide");
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
		$("#id_contacto").val("");
		$("#nombre").val("");
		$("#paterno").val("");
		$("#materno").val("");
		$("#celular").val("");
		$("#email").val("");
	};

	// Enviar correos
	$("#enviar_correo_curso").on('submit', function(e){
		e.preventDefault();
		let data = new FormData($(this)[0]);
		$.ajax({
			type: "POST",
			url: "/contactos/enviar_correo",
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
			}
			if (typeof response.error != "undefined") {
				Swal.fire({
					title: response.error,
					icon: "error",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
			}
		});

	})
	$("#envi")
	KTDatatablesContactos.init();
});
