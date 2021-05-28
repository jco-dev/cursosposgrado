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

	public function index($id)
	{
		$id_curso = $this->encryption->decrypt(base64_decode($id));
		$this->data['data'] = $this->inscripcion_model->data_curso($id_curso);
		$this->data['municipios'] = $this->inscripcion_model->listar_municipios();
		$this->data['profesiones_ocupaciones'] = $this->informacion_model->listar_profesiones_oficios();
		$this->data['curso'] = $id;
		$this->load->view('informacion/index', $this->data);
	}

	public function guardar_informacion()
	{
		$this->load->library('form_validation');
		$this->load->helper('email');

		$this->form_validation->set_rules('ci', 'carnet de identidad', 'required');
		$this->form_validation->set_rules('expedido', 'expedido', 'required');
		$this->form_validation->set_rules('correo', 'correo', 'required|valid_email');
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('paterno', 'paterno', 'required');
		$this->form_validation->set_rules('fecha_nacimiento', 'fecha nacimiento', 'callback_date_valid|callback_fecha_vacio');
		$this->form_validation->set_rules('celular', 'celular', 'callback_validar_celular');

		if ($this->form_validation->run() == false) {
			// if(false){
			$this->output->set_content_type('application/json')->set_output(json_encode(array('warning' => validation_errors())));
		} else {

			$res = (array) $this->getRecaptcha($this->input->post('g-recaptcha-response'));

			if (isset($res['success']) && $res['success'] == true && isset($res['score']) && $res['score'] > 0.5) {
				// datos participante
				$ci = $this->input->post('ci');
				$expedido = $this->input->post('expedido');
				$correo = $this->input->post('correo');
				$id_curso = $this->encryption->decrypt(base64_decode($this->input->post('id')));
				$nombre = $this->input->post('nombre');
				$paterno = $this->input->post('paterno');
				$materno = $this->input->post('materno');
				$genero = $this->input->post('genero');
				$fecha_nacimiento = $this->input->post('fecha_nacimiento');
				$celular = $this->input->post('celular');
				$id_municipio = $this->input->post('ciudad_residencia');
				$id_profesion_oficio = $this->input->post('profesion_oficio');
				$estado = "INTERESADO";

				// verificar la inscripcion del curso con ci Y EL ESTADO INTERESADO
				$respuesta = $this->sql_ssl->listar_tabla(
					'mdl_participante_preinscripcion_curso',
					['ci' => $ci, 'id_course_moodle' => $id_curso, 'estado' => "INTERESADO"]
				);

				if (count($respuesta) == 0) {
					//inscribir
					//verificamos si ya esta inscrito en participante

					// inscribir en participante y preinscripcion
					$resp = $this->sql_ssl->insertar_tabla(
						'mdl_participante',
						[
							'ci' => $ci,
							'expedido' => $expedido,
							'nombre' => ucwords(strtoupper(trim($nombre))),
							'paterno' => ucwords(strtoupper(trim($paterno))),
							'materno' => ucwords(strtoupper(trim($materno))),
							'genero' => $genero,
							'id_municipio' => $id_municipio,
							'id_profesion_oficio' => $id_profesion_oficio,
							'fecha_nacimiento' => $fecha_nacimiento,
							'correo' => $correo,
							'celular' => $celular
						]
					);

					if (is_numeric($resp)) {
						$res = $this->sql_ssl->insertar_tabla(
							'mdl_preinscripcion_curso',
							[
								'id_participante' => $resp,
								'id_course_moodle' => $id_curso,
								'estado' => $estado
							]

						);

						if (is_numeric($res)) {
							$this->output->set_content_type('application/json')->set_output(
								json_encode(['exito' => "Registrado correctamente le enviaremos la información a su correo registrado"])
							);
						} else {
							$this->output->set_content_type('application/json')->set_output(
								json_encode(['error' => "Error al registrarse por favor intente de nuevo"])
							);
						}
					}
				} else {

					// actualizar datos en participante y insertar la preinscripcion
					$respuesta = $this->sql_ssl->listar_tabla(
						'mdl_participante',
						['ci' => $ci]
					);

					$id_participante = $respuesta[0]->id_participante;
					$respuesta = $this->sql_ssl->modificar_tabla(
						'mdl_participante',
						[
							'expedido' => $expedido,
							'nombre' => ucwords(strtoupper(trim($nombre))),
							'paterno' => ucwords(strtoupper(trim($paterno))),
							'materno' => ucwords(strtoupper(trim($materno))),
							'genero' => $genero,
							'id_municipio' => $id_municipio,
							'id_profesion_oficio' => $id_profesion_oficio,
							'fecha_nacimiento' => $fecha_nacimiento,
							'correo' => $correo,
							'celular' => $celular
						],
						['id_participante' => $id_participante]
					);


					if ($respuesta) {
						$this->output->set_content_type('application/json')->set_output(
							// json_encode(['exito' => "Datos actualizados correctamente"])
							json_encode(['exito' => "Ya se encuentra registrado"])
						);
					} else {
						$this->output->set_content_type('application/json')->set_output(
							json_encode(['error' => "Error al registrarse al curso"])
						);
					}
				}
			} else {
				$this->output->set_content_type('application/json')->set_output(
					json_encode(['warning' => "No puede enviar muchas veces el formulario.!!!"])
				);
			}
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
			$this->form_validation->set_message('fecha', 'El campo {field} no es una fecha válida');
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
			$this->form_validation->set_message('celular', 'El campo {field} debe tener 8 dígitos');
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

	public function enviar_certificados()
	{
		$idcurso = $this->input->post('id');

		// generar certificados del curso en el directorio  assets/certificados_enviar/ en la carpeta id_curso
		$directorio = "assets/certificados_enviar/$idcurso/";
		if (!is_dir($directorio)) {
			if (mkdir($directorio, 0777, true)) {
				chmod($directorio, 0777);
				$estudiantes = $this->cursos_model->get_estudiantes_curso($idcurso);
				if (!empty($estudiantes)) {
					$datos_curso = $this->cursos_model->get_datos_curso($estudiantes[0]->id);
					if ($datos_curso == NULL) {
						$this->output->set_content_type('application/json')->set_output(json_encode(
							[
								'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
							]
						));
					} else {
						if ($datos_curso[0]->imagen_curso == NULL) {
							$this->output->set_content_type('application/json')->set_output(json_encode(
								[
									'error' => 'Por favor suba la imagen del certificado del curso'
								]
							));
							return;
						} else {
							$rep = new ImprimirCertificado();
							$respuesta = $rep->guardar_certificados($datos_curso, $estudiantes);

							// enviar email 
							$respuesta1 = $this->cursos_model->get_estudiantes_send($idcurso);
							$send = new SendEmail();
							$res = $send->enviar_correos($respuesta1);
							var_dump($res);
						}
					}
				} else {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'error' => 'No existen estudiantes inscritos en el curso'
						]
					));
				}
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'error' => 'Error al crear el directorio'
					]
				));
			}
		}
	}
}
