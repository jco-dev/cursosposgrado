<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificacion extends CI_Controller
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
		$this->load->view('ofertas/certificacion', $this->data);
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

		if ($this->input->post('code') != null && $this->input->post('result') != null) {
			$sentCode = $this->input->post('code');
			$result = (int) $this->input->post('result');
			if ($this->getExpressionResult($sentCode) === $result) {
				// Mostrar los certificados si ya estan disponible
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
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
}
