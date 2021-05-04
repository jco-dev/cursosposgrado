jQuery(document).ready(function () {
	$("#imprimir").on("click", function () {
		$.post("/inscripcion/imprimir_recibo", {}, function (resp) {
			$("#modal-body-inscripcion").children().remove();
			$("#modal-body-inscripcion").html(
				'<embed src="data:application/pdf;base64,' +
					resp +
					'#toolbar=1&navpanes=1&scrollbar=1&zoom=67,100,100" type="application/pdf" width="100%" height="600px" style="border: none;"/>'
			);
			$("#modal_imprimir_inscripcion").modal({
				backdrop: "static",
				keyboard: true,
			});
		});
	});
});
