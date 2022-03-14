"use strict";
let tbl_ver_inscripcion;
var KTDatatablesVerInscritos = (function () {
	var init = function () {
		tbl_ver_inscripcion = $("#tbl_ver_inscripcion");
		// begin first tbl_ver_inscripcion
		tbl_ver_inscripcion
			.DataTable({
				paging: true,
				ajax: {
					type: "POST",
					url: "/inscripcionadmin/ajax_ver_inscritos",
					data: { id: $("#id_c").val() },
				},
				lengthMenu: [
					[10, 20, 30, 50, 100, -1],
					[10, 20, 30, 50, 100, "Todos"],
				],
				iDisplayLength: 20,
				responsive: true,
				sortable: true,
				// layout definition
				layout: {
					scroll: false,
					footer: false,
				},
				pagination: true,
			})
			.on("change", "select#estado_preinscrito", function () {
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
								html: `<strong>PRE-INSCRITO:</strong> ${nombre} <br><strong>AL CURSO:</strong> ${curso}<br>¡Esta acción no se puede deshacer!`,
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
										"/inscripcionadmin/confirmar_cambio_estado",
										{ id: id, data: data },
										function (response) {
											if (typeof response.exito != "undefined") {
												Swal.fire("Exito!", response.exito, "success");
												tbl_ver_inscripcion.DataTable().ajax.reload();
											}
											if (typeof response.error != "undefined") {
												tbl_ver_inscripcion.DataTable().ajax.reload();
												Swal.fire("Error!", response.error, "error");
											}
										}
									);
								} else if (result.dismiss === "cancel") {
									tbl_ver_inscripcion.DataTable().ajax.reload();
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
			})
			.on("click", ".btn-imprimir-pdf", function (e) {
				let id = $(this).attr("id-preinscripcion-curso");
				window.open("/inscripcionadmin/imprimir/" + id, "_blank");
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
	$("#cursos").select2({
		placeholder: "-- seleccione curso --",
		width: "100%",
	});

	$("#btn_descargar_csv").on("click", function () {
		$("#modal_descargar_csv").modal({
			backdrop: "static",
			keyboard: false,
		});
	});

	let id_cc = $("#id_c").val();

	if (id_cc != null) {
		$("#cursos").val(id_cc).trigger("change");
	}

	$("#descagar_usuarios_moodle").on("click", function () {
		let id = $("#cursos").val();
		let estado = $("#estado").val();
		if (id == "") {
			Swal.fire({
				title: "Por favor, seleccione un curso !!!",
				icon: "warning",
				showCancelButton: false,
				confirmButtonText: "Ok",
			});
		} else if (estado == "") {
			Swal.fire({
				title: "Por favor, seleccione un estado !!!",
				icon: "warning",
				showCancelButton: false,
				confirmButtonText: "Ok",
			});
		} else {
			$.post(
				"/inscripcionadmin/ver_estudiantes",
				{ id, estado },
				function (response) {
					if (response.data > 0) {
						if (parseInt(response.data) > 0) {
							window.open(
								"/inscripcionadmin/descargar_csv/?id=" +
									id +
									"&estado=" +
									estado,
								"_blank"
							);
						}
					} else {
						Swal.fire({
							title: "No existe usuarios en el curso !!!",
							icon: "warning",
							showCancelButton: false,
							confirmButtonText: "Ok",
						});
					}
				}
			);
		}
	});

	$("#descargar_contactos_curso").on("click", function () {
		let id = $("#cursos").val();
		let estado = $("#estado").val();
		if (id == "") {
			Swal.fire({
				title: "Por favor, seleccione un curso !!!",
				icon: "warning",
				showCancelButton: false,
				confirmButtonText: "Ok",
			});
		} else if (estado == "") {
			Swal.fire({
				title: "Por favor, seleccione un estado !!!",
				icon: "warning",
				showCancelButton: false,
				confirmButtonText: "Ok",
			});
		} else {
			$.post(
				"/inscripcionadmin/ver_estudiantes",
				{ id, estado },
				function (response) {
					if (response.data > 0) {
						if (parseInt(response.data) > 0) {
							window.open(
								"/inscripcionadmin/descargar_contacto/?id=" +
									id +
									"&estado=" +
									estado,
								"_blank"
							);
						}
					} else {
						Swal.fire({
							title: "No existe usuarios en el curso !!!",
							icon: "warning",
							showCancelButton: false,
							confirmButtonText: "Ok",
						});
					}
				}
			);
		}
	});
	$("#cerrar_modal").on("click", function () {
		$("#cursos").val("").trigger("change");
		$("#estado").val("");
	});

	KTDatatablesVerInscritos.init();
});
