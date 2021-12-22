simplyCountdown("#cupon-fecha-fin", {
	year: 2021, // required
	month: 12, // required
	day: 22, // required
	hours: 17, // Default is 0 [0-23] integer
	minutes: 19, // Default is 0 [0-59] integer
	seconds: 0, // Default is 0 [0-59] integer
	words: {
		//words displayed into the countdown
		days: "Día",
		hours: "Hora",
		minutes: "Minuto",
		seconds: "Segundo",
		pluralLetter: "s",
	},
	plural: true, //use plurals
	inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
	inlineClass: "simply-countdown-inline", //inline css span class in case of inline = true
	// in case of inline set to false
	enableUtc: false, //Use UTC as default
	onEnd: function () {
		return;
	}, //Callback on countdown end, put your own function here
	refresh: 1000, // default refresh every 1s
	sectionClass: "simply-section", //section css class
	amountClass: "simply-amount", // amount css class
	wordClass: "simply-word", // word css class
	zeroPad: false,
	countUp: false,
});

$(".button-cupon").click(function () {
	$("#modal-cupon").modal("show");
});

$("#frm_inscripcion_cupon").submit(function (e) {
	e.preventDefault();
	e.stopPropagation();
});

$("#ci_cupon").on("change", function (e) {
	$.post("/cupon/buscar_por_ci", { ci: $(this).val() }, function (response) {
		if (typeof response.datos != "undefined") {
			$("#expedido_cupon").val(response.datos[0].expedido).trigger("change");
			$("#correo_cupon").val(response.datos[0].correo);
			$("#nombre_cupon").val(response.datos[0].nombre);
			$("#paterno_cupon").val(response.datos[0].paterno);
			$("#materno_cupon").val(response.datos[0].materno);
			$("#celular_cupon").val(response.datos[0].celular);
		}
	});
});

$("#frm_inscripcion_cupon").submit(function (e) {
	e.preventDefault();
	e.stopPropagation();
	var form = $(this);
	var url = form.attr("action");
	var data = form.serialize();
	$.post(url, data, function (response) {
		if (response.status == "success") {
			$("#modal-cupon").modal("hide");
			$("#modal-cupon-success").modal("show");
		} else {
			$("#modal-cupon-error").modal("show");
		}
	});
});
