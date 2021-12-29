<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/controllers/Reportes/CuponDescuento.php';

class Cupon extends CI_Controller
{
	public $data;
	public $alphabet, $alphabetsForNumbers;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cupon_model');
	}

	public function index()
	{
		$this->load->view('ofertas/cupon', $this->data);
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

	public function verificar_registro($ci)
	{
		$respuesta = $this->sql_ssl->listar_tabla(
			'mdl_participante',
			['ci' => $ci]
		);
		if (count($respuesta) != 0) {
			return $respuesta[0]->id_participante;
		} else {
			return false;
		}
	}

	public function inscripcion()
	{
		$id_participante = null;
		// Obtener id_participante del participante
		if ($this->input->post('id_participante_cupon') == "" && $this->input->post('id_participante_cupon') == null) {
			if ($this->verificar_registro($this->input->post('ci_cupon'))) {
				$id_participante = $this->verificar_registro(trim($this->input->post('ci_cupon')));
			} else {
				$id_participante = $this->sql_ssl->insertar_tabla(
					'mdl_participante',
					[
						'id_participante' => $this->input->post('id_participante_cupon'),
						'ci' => trim($this->input->post('ci_cupon')),
						'expedido' => $this->input->post('expedido_cupon'),
						'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($this->input->post('nombre_cupon'))), MB_CASE_UPPER),
						'paterno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($this->input->post('paterno_cupon'))), MB_CASE_UPPER),
						'materno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($this->input->post('materno_cupon'))), MB_CASE_UPPER),
						'id_municipio' => 34,
						'celular' => trim($this->input->post('celular_cupon')),
					]
				);
			}
		} else {
			$id_participante = $this->input->post('id_participante_cupon');
		}

		// obtener id_cupon del cupon
		$cupones = $this->sql_ssl->listar_tabla(
			'mdl_cupones',
			['estado' => 'REGISTRADO', 'fecha_inicio <=' => date('Y-m-d'), 'fecha_fin >=' => date('Y-m-d')]
		);

		if (count($cupones) > 0) {
			// verificar el registro de cantidad de cupones del participante
			if ($this->verificar_cantidad_registro($id_participante, $cupones[0]->id_cupones, intval($cupones[0]->cantidad)) === true) {
				$response = $this->cupon_model->get_id_last_number_cupon($cupones[0]->id_cupones);
				$numero = $this->numero_cupon($response, $cupones[0]->sigla_cupon);
				$response = $this->sql_ssl->insertar_tabla(
					'mdl_cupones_participante',
					[
						'id_participante' => $id_participante,
						'id_cupones' => $cupones[0]->id_cupones,
						'numero_cupon' => $cupones[0]->sigla_cupon . '-' . $numero,
						'fecha_registro' => date('Y-m-d H:i:s'),
						'estado' => 'REGISTRADO'
					]
				);

				$cupon = $this->sql_ssl->listar_tabla(
					'mdl_cupones_participante',
					['id_cupones_participante' => $response]
				);

				// averigurar numero de cupon y la descripcion del cupon el numero de celular y nombres
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'numero' => $response,
						'codigo' => $id_participante,
						"celular" => trim($this->input->post('celular_cupon')),
						'cupon' => $cupon[0]->numero_cupon,
						'nombre' => mb_convert_case(preg_replace('/\s+/', ' ', trim($this->input->post('nombre_cupon'))), MB_CASE_UPPER) . ' ' . mb_convert_case(preg_replace('/\s+/', ' ', trim($this->input->post('paterno_cupon'))), MB_CASE_UPPER)
					]
				));
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'warning' => 'Ya ha excedido la cantidad de cupones disponibles.'
					]
				));
			}
			// var_dump($cupones[0]->id_cupones, intval($cupones[0]->cantidad), $cupones[0]->sigla_cupon);
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'warning' => 'no hay cupones disponibles'
				]
			));
		}
	}

	public function numero_cupon($numero_cupon, $sigla)
	{
		if ($numero_cupon === NULL) {
			return '000001';
		} else {
			$response = $this->convertir_numero_string(intval(substr($numero_cupon[0]->numero_cupon, strlen($sigla) + 1), strlen($numero_cupon[0]->numero_cupon)) + 1);
			return $response;
		}
	}

	public function convertir_numero_string($valor)
	{
		if (intval(trim($valor)) >= 1 && intval(trim($valor)) <= 9) {
			return "00000" . intval($valor);
		} elseif (intval(trim($valor)) >= 10 && intval(trim($valor)) <= 99) {
			return "0000" . intval(trim($valor));
		} elseif (intval(trim($valor)) >= 100 && intval(trim($valor)) <= 999) {
			return "000" . intval(trim($valor));
		} elseif (intval(trim($valor)) >= 1000 && intval(trim($valor)) <= 9999) {
			return "00" . intval(trim($valor));
		} elseif (intval(trim($valor)) >= 10000 && intval(trim($valor)) <= 99999) {
			return "0" . intval(trim($valor));
		} elseif (intval(trim($valor)) >= 100000 && intval(trim($valor)) <= 999999) {
			return intval(trim($valor));
		}
	}

	public function verificar_cantidad_registro($id_participante, $id_cupones, $cantidad)
	{
		$respuesta = $this->sql_ssl->listar_tabla(
			'mdl_cupones_participante',
			['id_participante' => $id_participante, 'id_cupones' => $id_cupones]
		);

		if (count($respuesta) < $cantidad) {
			return true;
		} else {
			return false;
		}
	}

	public function cupon_pdf()
	{
		$id_cupones_participante = $this->input->post('numero');
		$id_participante = $this->input->post('codigo');
		$participante = $this->sql_ssl->listar_tabla(
			'mdl_participante',
			['id_participante' => $id_participante]
		);

		$cupones = $this->sql_ssl->listar_tabla(
			'mdl_cupones_participante',
			['id_cupones_participante' => $id_cupones_participante]
		);
		$rep = new CuponDescuento();
		$rep->imprimir_cupon($cupones, $participante);
	}

	public function verificar_cupon()
	{
		$ci = trim($this->input->post('ci'));
		$numero_cupon = trim($this->input->post('numero_cupon'));
		$data = $this->cupon_model->verificar_cupon_por_ci_cupon($ci, $numero_cupon);
		if ($data != NULL) {
			if ($data[0]->estado == 'REGISTRADO') {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'warning' => 'Cupón válido.',
						'tipo' => 'success'
					]
				));
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'warning' => 'El cupón ya ha sido utilizado.',
						'tipo' => 'danger'
					]
				));
			}
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'warning' => 'Número de cupón no válido.',
					'tipo' => 'warning'
				]
			));
		}
	}

	public function buscar_cupones_usuario()
	{
		$ci = $this->input->post('ci');
		$cupones = $this->cupon_model->buscar_cupones_usuario($ci);
		// var_dump($cupones);
		$data = array();

		if ($cupones != NULL) {
			foreach ($cupones as $key => $value) {
				array_push($data, $value->numero_cupon);
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(
			[
				'cupones' => $data
			]
		));
	}

	public function porcentaje_cupon()
	{
		$numero_cupon = $this->input->post('numero_cupon');
		$ci = $this->input->post('ci');
		$cupon  = $this->cupon_model->buscar_cupon_por_numero_cupon($ci, $numero_cupon);
		$this->output->set_content_type('application/json')->set_output(json_encode(
			[
				'porcentaje' => $cupon[0]->porcentaje
			]
		));
	}
}
