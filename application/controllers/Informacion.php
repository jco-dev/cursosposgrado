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
		$this->data['curso'] = $id;
		$this->load->view('informacion/index', $this->data);
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

							// enviar por email 
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
