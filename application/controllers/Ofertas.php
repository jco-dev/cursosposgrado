<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ofertas extends CI_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ofertas_model');
	}

	public function index()
	{
		$this->data['proximo_curso'] = $this->ofertas_model->verificar_proximos_cursos();
		$cursos_proximos = $this->ofertas_model->actualizar_proximo_curso();
		// return var_dump($cursos_proximos);
		if ($cursos_proximos != NULL) {
			foreach ($cursos_proximos as $c) {
				$res = $this->sql_ssl->modificar_tabla(
					'configuracion_curso',
					[
						'proximo_curso' => 'no'
					],
					[
						'id_configuracion_curso' => $c->id_configuracion_curso
					]
				);
			}
		}

		$this->load->view('ofertas/index', $this->data);
	}

	public function cursos()
	{
		$tarjeta = '';
		$cursos = $this->ofertas_model->listado_cursos();
		if ($cursos != NULL) {
			foreach ($cursos as $key => $curso) {
				$this->data['curso'] = $curso;
				$tarjeta .= $this->load->view('ofertas/tarjeta/tarjeta_curso', $this->data, true);
			}
			echo $tarjeta;
		} else {
			echo "No existen cursos";
		}
	}

	public function proximos_cursos($data)
	{
		$tarjeta = '';
		$cursos = $this->ofertas_model->verificar_proximos_cursos();
		if ($cursos != NULL) {
			foreach ($cursos as $key => $curso) {
				$this->data['curso'] = $curso;
				$tarjeta .= $this->load->view('ofertas/tarjeta/tarjeta_curso_proximo', $this->data, true);
			}
			echo $tarjeta;
		} else {
			echo "No existen cursos próximos";
		}
	}

	public function cursos_proximos()
	{
		$this->data['proximo_curso'] = $this->ofertas_model->verificar_proximos_cursos();
		$card_proximo = $this->proximos_cursos($this->data['proximo_curso']);
		echo $card_proximo;
	}

	public function guardar_suscripcion()
	{
		// return var_dump($_REQUEST);
		$this->load->library('form_validation');
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
			$id_evento = $this->input->post('id_evento');

			// Verificamos si el número de celular está registrados
			$respuesta_v = $this->ofertas_model->buscar_por_celular($celular)->result();

			if (count($respuesta_v) == 0) {
				// Insertar contacto
				$respuesta = $this->ofertas_model->insertar_contacto(['nombre' => $nombre, 'celular' => $celular]);
				if ($respuesta) {
					// insertar area interes contacto
					$respuesta1 = $this->ofertas_model->insertar_area(['id_evento' => $id_evento, 'id_contacto' => $respuesta, 'fecha_registro' => date("Y-m-d H:i:s"), 'estado_suscripcion' => 'ACTIVO']);
					if ($respuesta1) {
						$this->output->set_content_type('application/json')->set_output(json_encode(
							[
								'exito' => "exito",
								'id_evento' => $id_evento,
								'nombre' => $nombre,
								'celular' => $celular
							]
						));
					}
				}
			} else {
				// solo enviar mensaje
				$id_contacto = $respuesta_v[0]->id_contacto;
				$respuesta1 = $this->ofertas_model->insertar_area(['id_evento' => $id_evento, 'id_contacto' => $id_contacto, 'fecha_registro' => date("Y-m-d H:i:s"), 'estado_suscripcion' => 'ACTIVO']);
				if ($respuesta1) {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'exito' => "exito",
							'id_evento' => $id_evento,
							'nombre' => $nombre,
							'celular' => $celular
						]
					));
				}
			}
		}
	}
}
