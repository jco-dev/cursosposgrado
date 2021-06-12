<?php defined('BASEPATH') or exit('No direct script access allowed');

class Modulos extends PSG_Controller
{
	public $cn = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modulos_model');
		$this->load->model('cursos_model');
		$this->cn = 1;
	}

	public function index()
	{
		$this->data['cursos'] = $this->sql_ssl->listar_tabla(
			'mdl_listado_cursos'
		);
		$this->templater->view('modulos/index', $this->data);
	}

	public function ajax_ver_modulos()
	{
		if ($this->input->is_ajax_request()) {
			$table = "mdl_ver_modulos";
			$primaryKey = 'id_certificacion';
			$columns = array(
				array('dt' => 0, 'db' => 'id_certificacion', 'formatter' => function($id){
					return $this->cn++;
				}),
				array('dt' => 1, 'db' => 'fullname', 'formatter' => function ($fullname) {
					return '' . $fullname . '';
				}),
				array('dt' => 2, 'db' => 'nombre'),
				array('dt' => 3, 'db' => 'fecha_inicial'),
				array('dt' => 4, 'db' => 'fecha_final'),
				array('dt' => 5, 'db' => 'carga_horaria', 'formatter' => function($carga){
					return "<span class='label label-light-success label-inline mr-2'>" . $carga . "</span>";
				}),
				array('dt' => 6, 'db' => 'fecha_certificacion'),
				array('dt' => 7, 'db' => 'fecha_creacion'),
				array('dt' => 8, 'db' => 'estado', 'formatter' => function ($estado) {
					return "<span class='label label-light-primary label-inline mr-2'>" . $estado . "</span>";
				}),
				array('dt' => 9, 'db' => 'id_certificacion', 'formatter' => function ($id) {
					return '
					<a id="btn_editar" data-id=' . $id . ' href="javascript:;" class="btn btn-warning btn-sm btn-clean btn-icon" title="Editar">
						<i class="nav-icon la la-edit"></i>
					</a>
					<a id="btn_eliminar" data-id=' . $id . ' href="javascript:;" class="btn btn-danger btn-sm btn-clean btn-icon" title="Eliminar">
						<i class="nav-icon la la-trash"></i>
					</a>
					
					';
				})
			);
			$sql_details = array(
				'driver' => $this->db->dbdriver,
				'user' => $this->db->username,
				'pass' => $this->db->password,
				'db' => $this->db->database,
				'host' => $this->db->hostname
			);

			$this->output->set_content_type('application/json')->set_output(json_encode(
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, NULL)
			));

			return;
		}
	}

	public function guardar_modulo()
	{
		$this->load->library('form_validation');
		$this->load->helper('email');

		$this->form_validation->set_rules('id_curso', 'curso', 'required');
		$this->form_validation->set_rules('nombre', 'nombre del curso', 'required');
		$this->form_validation->set_rules('fecha_inicial', 'fecha inicial', 'required');
		$this->form_validation->set_rules('fecha_final', 'fecha final', 'required');
		$this->form_validation->set_rules('carga_horaria', 'carga horaria', 'required');
		$this->form_validation->set_rules('fecha_certificacion', 'fecha certificacion', 'required');

		if ($this->form_validation->run() == false) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('warning' => validation_errors())));
		} else {
			// datos modulo
			$id_certificacion = $this->input->post('id_certificacion');
			$id_course = $this->input->post('id_curso');
			$nombre = $this->input->post('nombre');
			$fecha_inicial = $this->input->post('fecha_inicial');
			$fecha_final = $this->input->post('fecha_final');
			$carga_horaria = $this->input->post('carga_horaria');
			$fecha_certificacion = $this->input->post('fecha_certificacion');

			if ($id_certificacion == "") { // insetar
				// inscribir en participante y preinscripcion
				$resp = $this->sql_ssl->insertar_tabla(
					'mdl_certificacion',
					[
						'id_course' => $id_course,
						'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER),
						'fecha_inicial' => $fecha_inicial,
						'fecha_final' => $fecha_final,
						'carga_horaria' => $carga_horaria,
						'fecha_certificacion' => $fecha_certificacion
					]
				);

				if (is_numeric($resp)) {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['exito' => "Modulo del curso registrado correctamente"])
					);
				} else {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['error' => "Error al registrar el modulo del curso"])
					);
				}

			} else { // editar
				$respuesta = $this->sql_ssl->modificar_tabla(
					'mdl_certificacion',
					[
						'id_course' => $id_course,
						'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER),
						'fecha_inicial' => $fecha_inicial,
						'fecha_final' => $fecha_final,
						'carga_horaria' => $carga_horaria,
						'fecha_certificacion' => $fecha_certificacion
					],
					['id_certificacion' => $id_certificacion]
				);

				if ($respuesta) {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['exito' => "Modulo editado correctamente"])
					);
				} else {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['error' => "Error al editar el curso"])
					);
				}
			}
		}
	}

	public function editar()
	{
		$id_certificacion = $this->input->post('id');
		$respuesta = $this->sql_ssl->listar_tabla(
			"mdl_certificacion",
			['id_certificacion' => $id_certificacion]
		);
		$this->output->set_content_type('application/json')->set_output(json_encode(
			$respuesta
		));
	}

	public function eliminar()
	{
		$id_certificacion = $this->input->post('id');
		$respuesta = $this->sql_ssl->modificar_tabla(
			"mdl_certificacion",
			['estado' => "ELIMINADO"],
			['id_certificacion' => $id_certificacion]
		);

		if ($respuesta) {
			$this->output->set_content_type('application/json')->set_output(
				json_encode(['exito' => "Modulo eliminado correctamente"])
			);
		} else {
			$this->output->set_content_type('application/json')->set_output(
				json_encode(['error' => "Error al eliminar el modulo del curso"])
			);
		}
	}
}
