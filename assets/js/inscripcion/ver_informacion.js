"use strict";
var KTDatatablesVerInformacion = (function () {
	var init = function () {
		var tbl_ver_informacion = $("#tbl_ver_informacion");

		// begin first tbl_ver_informacion
		tbl_ver_informacion
			.DataTable({
				processing: true,
				serverSide: true,
				ajax: "/inscripcionadmin/ajax_ver_informacion",
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
			.on("click", "#btn_enviar_informacion", function () {
				let id = $(this).attr("data-id");
				let nombre = "";
				let curso = "";
				// traer datos del estudiante y curso para mostrar
				$.post(
					"/inscripcion/datos_estudiante_curso",
					{
						id,
					},
					function (response) {
						let correo = response.exito[0].estado_correo;
						if (typeof response.exito != "undefined") {
							nombre = response.exito[0].nombre_completo;
							curso = response.exito[0].curso;
							let msg =
								correo == "1"
									? "¿Confirme si desea enviar el correo nuevamente?"
									: "¿Si todo esta bien?. Por favor confirme el envio del correo";
							Swal.fire({
								title: `${msg}`,
								html: `<strong>PRE-INSCRITO:</strong> ${nombre} <br><strong>AL CURSO:</strong> ${curso}`,
								icon: "warning",
								showCancelButton: true,
								buttonsStyling: false,
								confirmButtonText: "Si, enviar!",
								cancelButtonText: "No, cancelar",
								customClass: {
									confirmButton: "btn font-weight-bold btn-primary",
									cancelButton: "btn font-weight-bold btn-default",
								},
							}).then(function (result) {
								if (result.value) {
									$.post(
										"/inscripcion/enviar_correo_personal",
										{ id: id },
										function (response) {
											if (typeof response.exito != "undefined") {
												Swal.fire("Exito!", response.exito, "success");
												tbl_ver_informacion.DataTable().ajax.reload();
											}
											if (typeof response.error != "undefined") {
												Swal.fire("Error!", response.error, "error");
											}
											if (typeof response.warning != "undefined") {
												Swal.fire("Advertencia!", response.warning, "info");
											}
										}
									);
								} else if (result.dismiss === "cancel") {
									Swal.fire({
										text: "No se ha enviado el correo!.",
										icon: "error",
										buttonsStyling: false,
										confirmButtonText: "Ok",
										customClass: {
											confirmButton: "btn font-weight-bold btn-primary",
										},
									});
								}
							});
						}
					}
				);

				// console.log(id + " confirmar inscripcion");
			})
			.on("change", "select#estado_contacto", function () {
				let id = $(this).attr("data-id");
				let data = $(this).val();
				let nombre = "";
				let curso = "";
				// traer datos del estudiante y curso para mostrar
				$.post(
					"/inscripcion/datos_estudiante_curso",
					{
						id,
					},
					function (response) {
						if (typeof response.exito != "undefined") {
							nombre = response.exito[0].nombre_completo;
							curso = response.exito[0].curso;
							Swal.fire({
								title:
									"¿Si todo esta bien ?. Por favor confirme el cambio de estado!",
								html: `<strong>NOMBRE: </strong> ${nombre} <br><strong>AL CURSO:</strong> ${curso}<br>¡Esta acción no se puede deshacer!`,
								icon: "warning",
								showCancelButton: true,
								buttonsStyling: false,
								confirmButtonText: "Si, confirmar!",
								cancelButtonText: "No, cancelar",
								customClass: {
									confirmButton: "btn font-weight-bold btn-primary",
									cancelButton: "btn font-weight-bold btn-default",
								},
							}).then(function (result) {
								if (result.value) {
									$.post(
										"/inscripcionadmin/confirmar_cambio_estado_contacto",
										{ id: id, data: data },
										function (response) {
											if (typeof response.exito != "undefined") {
												Swal.fire("Exito!", response.exito, "success");
												tbl_ver_informacion.DataTable().ajax.reload();
											}
											if (typeof response.error != "undefined") {
												tbl_ver_informacion.DataTable().ajax.reload();
												Swal.fire("Error!", response.error, "error");
											}
										}
									);
								} else if (result.dismiss === "cancel") {
									tbl_ver_informacion.DataTable().ajax.reload();
									Swal.fire({
										text: "No se ha confirmado el cambio de estado!.",
										icon: "error",
										buttonsStyling: false,
										confirmButtonText: "Ok",
										customClass: {
											confirmButton: "btn font-weight-bold btn-primary",
										},
									});
								}
							});
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
	KTDatatablesVerInformacion.init();
});
