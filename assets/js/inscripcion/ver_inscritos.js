"use strict";
let tbl_ver_inscripcion;
var KTDatatablesVerInscritos = (function () {
	var init = function () {
		tbl_ver_inscripcion = $("#tbl_ver_inscripcion");
		// begin first tbl_ver_inscripcion
		tbl_ver_inscripcion
			.DataTable({
				processing: true,
				serverSide: true,
				ajax: "/inscripcionadmin/ajax_ver_inscritos",
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

				// column sorting
				sortable: true,
				pagination: true,
				columns: [
					{
						field: "id_participante",
						title: "#",
						width: 15,
						textAlign: "center",
					},
					{
						field: "ci",
						title: "ci",
						width: 70,
					},
					{
						field: "nombre_completo",
						title: "Nombres",
						width: 250,
					},
					{
						field: "municipio_enviar",
						title: "Enviar a",
						width: 150,
					},
					{
						field: "celular",
						title: "celular",
					},
					{
						field: "curso",
						title: "curso",
						width: 150,
					},
					{
						field: "tipo_pago",
						title: "tipo pago",
					},
					{
						field: "monto_pago",
						title: "monto pago",
					},
					{
						field: "id_transaccion",
						title: "transaccion",
					},
					{
						field: "tipo_certificacion",
						title: "certificacion",
					},
					{
						field: "estado",
						title: "estado,",
					},
					{
						field: "respaldo_pago",
						title: "respaldo pago",
					},
					{
						field: "id_preinscripcion_curso",
						title: "Cambiar estado",
					},
				],
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

				// console.log(id + " confirmar inscripcion");
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
		placeholder: "-- Descargar CSV --",
		minimumResultsForSearch: Infinity,
	});

	$("#cursos").on("change", function (e) {
		if ($(this).val() != "all") {
			let id = $(this).val();
			tbl_ver_inscripcion.dataTable().fnClearTable();
			tbl_ver_inscripcion.dataTable().fnDestroy();

			tbl_ver_inscripcion.DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "/inscripcionadmin/ajax_ver_inscritos",
					data: { id },
					type: "post",
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

				// column sorting
				sortable: true,
				pagination: true,
				columns: [
					{
						field: "id_participante",
						title: "#",
						width: 15,
						textAlign: "center",
					},
					{
						field: "ci",
						title: "ci",
						width: 70,
					},
					{
						field: "nombre_completo",
						title: "Nombres",
						width: 250,
					},
					{
						field: "municipio_enviar",
						title: "Enviar a",
						width: 150,
					},
					{
						field: "celular",
						title: "celular",
					},
					{
						field: "curso",
						title: "curso",
						width: 150,
					},
					{
						field: "tipo_pago",
						title: "tipo pago",
					},
					{
						field: "monto_pago",
						title: "monto pago",
					},
					{
						field: "id_transaccion",
						title: "transaccion",
					},

					{
						field: "tipo_certificacion",
						title: "certificacion",
					},
					{
						field: "estado",
						title: "estado",
					},
					{
						field: "respaldo_pago",
						title: "respaldo pago",
					},
					{
						field: "id_preinscripcion_curso",
						title: "Cambiar estado",
					},
				],
			});

			// descargar csv
			if (id != "") {
				window.open("/inscripcionadmin/descargar_csv/" + id, "_blank");
			} else {
				console.log("error al descargar csv");
			}

			// console.log("Descargar csv: " + id);
		} else {
			tbl_ver_inscripcion.dataTable().fnClearTable();
			tbl_ver_inscripcion.dataTable().fnDestroy();

			tbl_ver_inscripcion.DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "/inscripcionadmin/ajax_ver_inscritos",
					data: { id: null },
					type: "post",
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

				// column sorting
				sortable: true,
				pagination: true,
				columns: [
					{
						field: "id_participante",
						title: "#",
						width: 15,
						textAlign: "center",
					},
					{
						field: "ci",
						title: "ci",
						width: 70,
					},
					{
						field: "nombre_completo",
						title: "Nombres",
						width: 250,
					},
					{
						field: "municipio_enviar",
						title: "Enviar a",
						width: 150,
					},
					{
						field: "celular",
						title: "celular",
					},
					{
						field: "curso",
						title: "curso",
						width: 150,
					},
					{
						field: "tipo_pago",
						title: "tipo pago",
					},
					{
						field: "monto_pago",
						title: "monto pago",
					},
					{
						field: "id_transaccion",
						title: "transaccion",
					},
					{
						field: "tipo_certificacion",
						title: "certificacion",
					},
					{
						field: "estado",
						title: "estado",
					},
					{
						field: "respaldo_pago",
						title: "respaldo pago",
					},
					{
						field: "id_preinscripcion_curso",
						title: "Cambiar estado",
					},
				],
			});
		}
	});
	KTDatatablesVerInscritos.init();
});
