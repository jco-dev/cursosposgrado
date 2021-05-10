"use strict";
var KTDatatablesVerInscritos = (function () {
	var init = function () {
		var tbl_ver_inscripcion = $("#tbl_ver_inscripcion");

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
	KTDatatablesVerInscritos.init();
});
