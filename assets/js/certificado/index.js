let tbl_certificate_type = $("#tbl_certificate_type");
// begin first tbl_certificate_type
tbl_certificate_type.DataTable({
	processing: true,
	ajax: "/certificado/ajax_certificate_type_listing",
	lengthMenu: [
		[10, 20, 30, 50, 100, -1],
		[10, 20, 30, 50, 100, "Todos"],
	],
	iDisplayLength: 10,
	sortable: true,
	retrieve: true,
	paging: true,
	responsive: true,
});
// .on("click", "a#btn_editar", function (e) {
// 	let id = $(this).attr("data-id");
// 	$.post("/modulos/editar", { id }, function (response) {
// 		$("#id_certificacion").val(response[0].id_certificacion);
// 		$("#id_curso").val(response[0].id_course).trigger("change");
// 		$("#nombre").val(response[0].nombre);
// 		$("#fecha_inicial").val(response[0].fecha_inicial);
// 		$("#fecha_final").val(response[0].fecha_final);
// 		$("#carga_horaria").val(response[0].carga_horaria);
// 		$("#posx_imagen_modulo").val(response[0].posx_imagen_modulo);
// 		$("#posy_imagen_modulo").val(response[0].posy_imagen_modulo);
// 		$("#fecha_certificacion").val(response[0].fecha_certificacion);

// 		if (response[0].color_titulo != null) {
// 			let colores = response[0].color_titulo.split(", ");
// 			$("#color_titulo").val(RGB2Color(colores[0], colores[1], colores[2]));
// 		} else {
// 			$("#color_titulo").val("#000000");
// 		}

// 		function RGB2Color(r, g, b) {
// 			return "#" + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
// 		}

// 		function byte2Hex(n) {
// 			var nybHexString = "0123456789ABCDEF";
// 			return (
// 				String(nybHexString.substr((n >> 4) & 0x0f, 1)) +
// 				nybHexString.substr(n & 0x0f, 1)
// 			);
// 		}

// 		$("#title_modulo").html("Editar Módulo");
// 		$("#btn_title").html("Editar");
// 		$("#modal_modulos").modal({
// 			backdrop: "static",
// 			keyboard: false,
// 		});
// 	});
// })
// .on("click", "a#btn_eliminar", function (e) {
// 	let id = $(this).attr("data-id");
// 	Swal.fire({
// 		title: "¿Estas seguro de eliminar?",
// 		text: "Esta accion no se puede revertir",
// 		icon: "warning",
// 		showCancelButton: true,
// 		buttonsStyling: false,
// 		confirmButtonText: "Si, Eliminar!",
// 		cancelButtonText: "No, cancelar",
// 		customClass: {
// 			confirmButton: "btn font-weight-bold btn-primary",
// 			cancelButton: "btn font-weight-bold btn-default",
// 		},
// 	}).then(function (result) {
// 		if (result.value) {
// 			$.post("/modulos/eliminar", { id }, function (response) {
// 				if (typeof response.exito != "undefined") {
// 					Swal.fire("Exito!", response.exito, "success");
// 					tbl_certificate_type.DataTable().ajax.reload();
// 				}
// 				if (typeof response.error != "undefined") {
// 					tbl_certificate_type.DataTable().ajax.reload();
// 					Swal.fire("Error!", response.error, "error");
// 				}
// 			});
// 		} else if (result.dismiss === "cancel") {
// 			Swal.fire({
// 				text: "No se ha eliminado el modulo",
// 				icon: "error",
// 				buttonsStyling: false,
// 				confirmButtonText: "Ok",
// 				customClass: {
// 					confirmButton: "btn font-weight-bold btn-primary",
// 				},
// 			});
// 		}
// 	});
// });
