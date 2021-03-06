<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . '/controllers/SendEmail.php';

class Informacion extends CI_Controller
{
	public $data;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('informacion_model');
		$this->load->model('inscripcion_model');
	}

	public function index()
	{
		$id = $this->input->get('id');
		$estado = $this->input->get('uijkikij');
		$id_curso = $this->encryption->decrypt(base64_decode($id));
		$this->data['data'] = $this->inscripcion_model->data_curso($id_curso);
		$this->data['municipios'] = $this->inscripcion_model->listar_municipios();
		$this->data['profesiones_ocupaciones'] = $this->informacion_model->listar_profesiones_oficios();
		$this->data['curso'] = $id;
		$this->data['estado'] = $estado;
		$this->load->view('informacion/index', $this->data);
	}

	public function proximo($id)
	{
		$id_curso = $this->encryption->decrypt(base64_decode($id));
		$this->data['data'] = $this->inscripcion_model->data_curso($id_curso);
		$this->data['municipios'] = $this->inscripcion_model->listar_municipios();
		$this->data['curso'] = $id;
		$this->load->view('informacion/proximo', $this->data);
	}

	public function guardar_informacion()
	{
		// return var_dump($_REQUEST);
		$this->load->library('form_validation');
		$this->load->helper('email');
		$this->config->set_item('language', 'spanish');
		// $this->form_validation->set_rules('ci', 'carnet de identidad', 'required');
		// $this->form_validation->set_rules('expedido', 'expedido', 'required');
		// $this->form_validation->set_rules('correo', 'correo', 'required|valid_email');
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('celular', 'celular', 'required');

		if ($this->form_validation->run() == false) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('warning' => validation_errors())));
		} else {

			$id_curso = $this->encryption->decrypt(base64_decode($this->input->post('id')));
			$nombre = strtoupper($this->input->post('nombre'));
			$celular = $this->input->post('celular');

			// Verificamos si el n??mero de celular est?? registrados
			$respuesta = $this->informacion_model->buscar_por_celular($celular)->result();

			if (count($respuesta) == 0) {
				// Insertar contacto
				$respuesta = $this->informacion_model->insertar_contacto(['nombre' => $nombre, 'celular' => $celular]);
				if ($respuesta) {
					$response = $this->informacion_model->informacion_curso($id_curso);
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'exito' => $response,
							'celular' => $celular
						]
					));
				}
			} else {
				// solo enviar mensaje
				$response = $this->informacion_model->informacion_curso($id_curso);
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'exito' => $response,
						'celular' => $celular
					]
				));
			}
		}
	}

	public function buscar_contacto()
	{
		$celular = $this->input->post('celular');
		$buscar = $this->informacion_model->buscar_por_celular($celular)->result();
		$this->output->set_content_type('application/json')->set_output(json_encode(
			$buscar
		));
	}

	public function enviar_correo_personal($idcurso, $id_preinscripcion_curso)
	{
		$respuesta1 = $this->inscripcion_model->get_data_informacion($id_preinscripcion_curso);

		$send = new SendEmail();
		$res = $send->enviar_correo_personal($respuesta1);
		if ($res) {
			if (is_numeric($id_preinscripcion_curso)) {
				$respuesta = $this->sql_ssl->modificar_tabla(
					'mdl_preinscripcion_curso',
					['estado_correo' => 1],
					['id_preinscripcion_curso' => $id_preinscripcion_curso]
				);
			}
			return true;
		} else {
			return false;
		}
	}

	public function getRecaptcha($secret_key)
	{
		$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeBuM4aAAAAAGPHI5DQT6oIZWjHozRoSojbWxlL&response={$secret_key}");
		$retorno = json_decode($respuesta);
		return $retorno;
	}

	public function date_valid($date)
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		if ($d && $d->format('Y-m-d') == $date) {
			return true;
		} else {
			$this->form_validation->set_message('fecha', 'El campo {field} no es una fecha v??lida');
			return false;
		}
	}

	public function fecha_vacio($date)
	{
		if ($date != '') {
			return true;
		} else {
			$this->form_validation->set_message('fecha', 'El campo {field} es requerido');
			return false;
		}
	}

	public function validar_celular($numero_celular)
	{
		if (strlen($numero_celular) == 8) {
			return true;
		} else {
			$this->form_validation->set_message('celular', 'El campo {field} debe tener 8 d??gitos');
			return false;
		}
	}

	public function monto_valid($monto)
	{
		if (intval($monto) >= 100 && intval($monto) <= 1000) {
			return true;
		} else {
			$this->form_validation->set_message('monto pago', 'El campo {field} debe estar entre 100 y 1000');
			return false;
		}
	}

	// public function enviar_certificados()
	// {
	// 	$idcurso = $this->input->post('id');

	// 	// generar certificados del curso en el directorio  assets/certificados_enviar/ en la carpeta id_curso
	// 	$directorio = "assets/certificados_enviar/$idcurso/";
	// 	if (!is_dir($directorio)) {
	// 		if (mkdir($directorio, 0777, true)) {
	// 			chmod($directorio, 0777);
	// 			$estudiantes = $this->cursos_model->get_estudiantes_curso($idcurso);
	// 			if (!empty($estudiantes)) {
	// 				$datos_curso = $this->cursos_model->get_datos_curso($estudiantes[0]->id);
	// 				if ($datos_curso == NULL) {
	// 					$this->output->set_content_type('application/json')->set_output(json_encode(
	// 						[
	// 							'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
	// 						]
	// 					));
	// 				} else {
	// 					if ($datos_curso[0]->imagen_curso == NULL) {
	// 						$this->output->set_content_type('application/json')->set_output(json_encode(
	// 							[
	// 								'error' => 'Por favor suba la imagen del certificado del curso'
	// 							]
	// 						));
	// 						return;
	// 					} else {
	// 						$rep = new ImprimirCertificado();
	// 						$respuesta = $rep->guardar_certificados($datos_curso, $estudiantes);

	// 						// enviar email 
	// 						$respuesta1 = $this->cursos_model->get_estudiantes_send($idcurso);
	// 						$send = new SendEmail();
	// 						$res = $send->enviar_correos($respuesta1);
	// 						// var_dump($res);
	// 					}
	// 				}
	// 			} else {
	// 				$this->output->set_content_type('application/json')->set_output(json_encode(
	// 					[
	// 						'error' => 'No existen estudiantes inscritos en el curso'
	// 					]
	// 				));
	// 			}
	// 		} else {
	// 			$this->output->set_content_type('application/json')->set_output(json_encode(
	// 				[
	// 					'error' => 'Error al crear el directorio'
	// 				]
	// 			));
	// 		}
	// 	}
	// }

	public function format_dia($dia)
	{
		if ($dia >= 1 && $dia <= 9) {
			return "0" + $dia;
		} else {
			return $dia;
		}
	}
}
