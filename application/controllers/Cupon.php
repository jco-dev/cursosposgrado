<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cupon extends CI_Controller
{
	public $data;
	public $alphabet, $alphabetsForNumbers;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('certificacion_model');

		$this->alphabet = array('K', 'g', 'A', 'D', 'R', 'V', 's', 'L', 'Q', 'w');
		$this->alphabetsForNumbers = array(
			array('K', 'g', 'A', 'D', 'R', 'V', 's', 'L', 'Q', 'w'),
			array('M', 'R', 'o', 'F', 'd', 'X', 'z', 'a', 'K', 'L'),
			array('H', 'Q', 'O', 'T', 'A', 'B', 'C', 'D', 'e', 'F'),
			array('T', 'A', 'p', 'H', 'j', 'k', 'l', 'z', 'x', 'v'),
			array('f', 'b', 'P', 'q', 'w', 'e', 'K', 'N', 'M', 'V'),
			array('i', 'c', 'Z', 'x', 'W', 'E', 'g', 'h', 'n', 'm'),
			array('O', 'd', 'q', 'a', 'Z', 'X', 'C', 'b', 't', 'g'),
			array('p', 'E', 'J', 'k', 'L', 'A', 'S', 'Q', 'W', 'T'),
			array('f', 'W', 'C', 'G', 'j', 'I', 'O', 'P', 'Q', 'D'),
			array('A', 'g', 'n', 'm', 'd', 'w', 'u', 'y', 'x', 'r')
		);
	}

	public function index()
	{
		$this->load->view('ofertas/cupon', $this->data);
	}

	// Generar Captcha
	public function generarCaptcha()
	{

		$expression = (object) array(
			"n1" => rand(0, 9),
			"n2" => rand(0, 9)
		);

		$captchaImage = 'assets/img/captcha/captcha' . time() . '.png';

		$this->generateImage($expression->n1 . ' + ' . $expression->n2 . ' =', $captchaImage);

		$usedAlphabet = rand(0, 9);

		$code = $this->alphabet[$usedAlphabet] .
			$this->alphabetsForNumbers[$usedAlphabet][$expression->n1] .
			$this->alphabetsForNumbers[$usedAlphabet][$expression->n2];

		$this->output->set_content_type('application/json')->set_output(json_encode(
			[
				'ruta' => $captchaImage,
				'codigo' => $code,
			]
		));
	}

	function generateImage($text, $file)
	{
		$im = @imagecreate(84, 37) or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($im, 200, 200, 200);
		$text_color = imagecolorallocate($im, 0, 0, 0);
		imagestring($im, 5, 12, 12,  $text, $text_color);
		imagepng($im, $file);
		imagedestroy($im);
	}

	public function getIndex($alphabet, $letter)
	{
		for ($i = 0; $i < count($alphabet); $i++) {
			$l = $alphabet[$i];
			if ($l === $letter) return $i;
		}
	}

	public function getExpressionResult($code)
	{

		$userAlphabetIndex =  $this->getIndex($this->alphabet, substr($code, 0, 1));
		$number1 = (int) $this->getIndex($this->alphabetsForNumbers[$userAlphabetIndex], substr($code, 1, 1));
		$number2 = (int) $this->getIndex($this->alphabetsForNumbers[$userAlphabetIndex], substr($code, 2, 1));
		return $number1 + $number2;
	}

	public function verificacionCertificacion()
	{
		$html = '';
		if ($this->input->post('code') != null && $this->input->post('result') != null) {
			$sentCode = $this->input->post('code');
			$result = (int) $this->input->post('result');
			if ($this->getExpressionResult($sentCode) === $result) {
				// Mostrar los certificados si ya estan disponible
				$cursos_persona = $this->certificacion_model->buscar_persona_por_ci($this->input->post('carnet_identidad'), $this->input->post('nro_celular'));

				if ($cursos_persona != null) {
					$html .= '<div class="card card-custom bg-radial-gradient-primary card-stretch gutter-b">
						<div class="card-header border-0 py-5">
							<h3 class="card-title font-weight-bolder text-white">Estimad@: ' . $cursos_persona[0]->nombre . ' ' . $cursos_persona[0]->paterno . '</h3>
							<p class="text-white">La disponibilidad de entrega de sus cursos aprobados se detalla acontinuacion:</p>
						</div>
						<div class="card card-custom card-stretch gutter-b" style="border-radius: 5px 5px 0px 0px;">
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label font-weight-bolder text-dark">Cursos</span>
									<span class="text-muted mt-3 font-weight-bold font-size-sm">Más de 30 cursos registrados</span>
								</h3>
								<div class="card-toolbar">
									<ul class="nav nav-pills nav-pills-sm nav-dark-75">
										<li class="nav-item">
											<a class="py-2 px-4 btn btn-secondary" href="javascript:;">hoy: ' . date('d-m-Y') . '</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body pt-2 mt-n3">
								<div class="tab-content mt-5">
									<div class="tab-pane fade show active">
										<div class="table-responsive">
											<table class="table table-borderless table-vertical-center table-bordered">
												<thead>
													<tr>
														<th class="p-0 w-40px"></th>
														<th class="p-0 min-w-200px text-center">CURSO</th>
														<th class="p-0 min-w-100px text-center">NOTA</th>
														<th class="p-0 min-w-225px text-center">DISPONIBILIDAD DE ENTREGA</th>
													</tr>
												</thead>
												<tbody>';
					foreach ($cursos_persona as $key => $value) {
						$d = $value->certificacion_disponible == "SI" ? 'DISPONIBLE' : 'NO DISPONIBLE';
						$c = $value->certificacion_disponible == "SI" ? 'label-light-success' : 'label-light-danger';
						$c_nota =  ($value->calificacion_final >= $value->nota_aprobacion) ? 'label-success' : 'label-danger';
						$fecha = '';

						if ($value->certificacion_disponible_inicio != "") {
							$fecha .= '<span class="label label-xl label-inline ' . $c . '">' . $d . '</span>
							<p>' . $value->certificacion_disponible_inicio . ' hasta ' . $value->certificacion_disponible_fin . ' </p>';
						} else {
							$fecha .= '<span class="label label-xl label-inline ' . $c . '">' . $d . '</span>';
						}

						$html .= '<tr>
						<td class="pl-0 py-4">
							<div class="symbol symbol-50 symbol-light mr-1">
								<span class="symbol-label">
									<img src="assets/img/img_send_certificate/cursos.png" class="h-50 align-self-center" alt="" />
								</span>
							</div>
						</td>
						<td class="pl-0">
							<a href="javascript:;" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">' . $value->fullname . '</a>
							<div>
								<span class="font-weight-bolder">Carga horaria:</span>
								<a class="text-muted font-weight-bold text-hover-primary" href="#">' . $value->carga_horaria . ' horas académicas</a>
							</div>
						</td>
						<td class="text-center">
							<span class="label ' . $c_nota . ' label-lg">' . $value->calificacion_final . '</span>
						</td>
						<td class="text-center">
							<span class="text-muted font-weight-500">
								' . $fecha . '
							</span>
						</td>
					</tr>';
					}
					$html .= '</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					</div>';
				} else {
					$html = '<div class="card card-custom bg-radial-gradient-primary card-stretch gutter-b">
					<div class="card-header border-0 py-5">
						<h3 class="card-title font-weight-bolder text-white">No se encontraron resultados</h3>
						<p class="text-white"></p>
					</div>
				</div>';
				}

				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'resp' => $html,
						'recargar' => false
					]
				));
			} else {
				// echo "error";
				// generar un nuevo captcha y mostrar mensaje
				$message = '<div class="alert alert-custom alert-danger fade show" role="alert">
					<div class="alert-icon"><i class="flaticon-warning"></i></div>
					<div class="alert-text">Error de captcha. Intente de nuevo por favor !!</div>
					<div class="alert-close">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true"><i class="ki ki-close"></i></span>
						</button>
					</div>
				</div>';

				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'message' => $message,
						'recargar' => true
					]
				));
			}
		} else {
		}
	}

	public function buscar_por_ci()
	{
		$ci = $this->input->post('ci');
		$respuesta = $this->sql_ssl->listar_tabla(
			'mdl_participante',
			['ci' => $ci]
		);
		if (count($respuesta) != 0) {
			$this->output->set_content_type('application/json')->set_output(
				json_encode(['datos' => $respuesta])
			);
		}
	}

	public function inscripcion()
	{
		var_dump($_REQUEST);
	}
}
