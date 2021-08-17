"use strict";
let tbl_entrega_certificdo;
var KTDatatablesVerModulos = (function () {
	var init = function () {
		tbl_entrega_certificdo = $("#tbl_entrega_certificado");
		// begin first tbl_entrega_certificdo
		tbl_entrega_certificdo
			.DataTable({
				ajax: "/entrega/ajax_listado_estudiantes",
				lengthMenu: [
					[10, 20, 30, 50, 100, -1],
					[10, 20, 30, 50, 100, "Todos"],
				],
				retrieve: true,
				paging: true,
				responsive: true,
			})
			.on("click", "a#btn_entregar", function (e) {
				let id = $(this).attr("data-id");
				let curso = $(this).attr("curso");
				let estudiante = $(this).attr("nombre");

				$.post("/entrega/editar", { id }, function (response) {
					// console.log();
					$("#id_inscripcion_curso_e").val(
						response.exito[0].id_inscripcion_curso
					);
					$("#certificado_recogido_e").val(
						response.exito[0].certificado_recogido
					);
					if (response.exito[0].fecha_entrega != null) {
						$("#fecha_entrega_e").val(
							response.exito[0].fecha_entrega.split(" ")[0]
						);
					}

					$("#entregado_a_e").val(response.exito[0].entregado_a);
					$("#observacion_entrega_e").val(
						response.exito[0].observacion_entrega
					);

					$("#modal-title-entrega").html(
						"Entregar a: " + estudiante + " del curso: " + curso
					);

					$("#modal_entrega").modal({
						backdrop: "static",
						keyboard: false,
					});
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
	$("#frm_entrega").submit(function (e) {
		e.preventDefault();
		let data = new FormData($(this)[0]);

		$.ajax({
			type: "POST",
			url: "/entrega/actualizar_entrega",
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
				tbl_entrega_certificdo.DataTable().ajax.reload();
				limpiar_campos();
				$("#modal_entrega").modal("hide");
			}
			if (typeof response.error != "undefined") {
				Swal.fire({
					title: response.error,
					icon: "error",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
				$("#modal_entrega").modal("hide");
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
		$("#id_inscripcion_curso_e").val("");
		$("#certificado_recogido_e").val("");
		$("#fecha_entrega_e").val("");
		$("#entregado_a_e").val("");
		$("#observacion_entrega_e").val("");
	};

	KTDatatablesVerModulos.init();
});
