<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/controllers/SendEmail.php';

class Contactos extends PSG_Controller
{
    public $cn = 1;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contactos_model');
        $this->cn = 1;
    }

    public function index()
    {
        $this->templater->view('contactos/index', $this->data);
    }

    public function enviar($id)
	{
		$this->data['id'] = $id;
		$respuesta = $this->contactos_model->count_contacts();
		$this->data['cantidad'] = $respuesta[0]->cantidad;
		$this->templater->view('contactos/enviar', $this->data);
	}

    public function ajax_listado_contactos()
    {
        if ($this->input->is_ajax_request()) {
            $table = "mdl_contactos";
            $primaryKey = 'id_contacto';
            $condicion = "estado = 'REGISTRADO'";
            $columns = array(
                array('dt' => 0, 'db' => 'id_contacto', 'formatter' => function($id){
                    return $this->cn++;
                }),
                array('dt' => 1, 'db' => 'nombre', 'formatter' => function ($nombre) {
                    return '' . $nombre . '';
                }),
                array('dt' => 2, 'db' => 'paterno'),
                array('dt' => 3, 'db' => 'materno'),
                array('dt' => 4, 'db' => 'celular'),
                array('dt' => 5, 'db' => 'email'),
                array('dt' => 6, 'db' => 'fecha_registro'),
                array('dt' => 7, 'db' => 'id_contacto', 'formatter' => function ($id, $row) {
                    return "
                        <a id='btn_editar_contacto' titulo='" . $row['nombre'] . "' data-id=" . $id . " href='javascript:;' class='btn btn-light-warning btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Editar contacto'>
                        <i class='nav-icon la la-edit'></i>
                        </a>
                        <a id='btn_eliminar_contacto' data-id=" . $id . " href='javascript:;' class='btn btn-light-danger btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Eliminar contacto'>
                            <i class='nav-icon la la-trash'></i>
                        </a>
                    ";
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
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condicion, NULL)
            ));
            return;
        }
    }

	public function guardar_contacto()
	{
		$this->load->library('form_validation');
		$this->load->helper('email');

		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('paterno', 'paterno', 'required');
		$this->form_validation->set_rules('email', 'correo', 'required');

		if ($this->form_validation->run() == false) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('warning' => validation_errors())));
		} else {
			// datos contacto
			$id_contacto = $this->input->post('id_contacto');
			$nombre = trim($this->input->post('nombre'));
			$paterno = trim($this->input->post('paterno'));
			$materno = trim($this->input->post('materno'));
			$paterno = trim($this->input->post('paterno'));
			$celular = trim($this->input->post('celular'));
			$email = trim($this->input->post('email'));

			if ($id_contacto == "" || $id_contacto == NULL) { // insetar
				// inscribir contacto
				$resp = $this->sql_ssl->insertar_tabla(
					'mdl_contactos',
					[
						'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER),
						'paterno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($paterno)), MB_CASE_UPPER),
						'materno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($materno)), MB_CASE_UPPER),
						'celular' => $celular,
						'email' => $email
					]
				);

				if (is_numeric($resp)) {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['exito' => "Contacto registrado correctamente"])
					);
				} else {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['error' => "Error al registrar el contacto"])
					);
				}

			} else { // editar
				$respuesta = $this->sql_ssl->modificar_tabla(
					'mdl_contactos',
					[
						'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER),
						'paterno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($paterno)), MB_CASE_UPPER),
						'materno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($materno)), MB_CASE_UPPER),
						'celular' => $celular,
						'email' => $email
					],
					['id_contacto' => $id_contacto]
				);

				if ($respuesta) {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['exito' => "Contacto editado correctamente"])
					);
				} else {
					$this->output->set_content_type('application/json')->set_output(
						json_encode(['error' => "Error al editar el contacto"])
					);
				}
			}
		}
	}

	public function editar()
	{
		$id_contacto = $this->input->post('id');
		$respuesta = $this->sql_ssl->listar_tabla(
			"mdl_contactos",
			['id_contacto' => $id_contacto]
		);
		$this->output->set_content_type('application/json')->set_output(json_encode(
			$respuesta
		));
	}

	public function eliminar()
	{
		$id_contacto = $this->input->post('id');
		$respuesta = $this->sql_ssl->modificar_tabla(
			"mdl_contactos",
			['estado' => "ELIMINADO"],
			['id_contacto' => $id_contacto]
		);

		if ($respuesta) {
			$this->output->set_content_type('application/json')->set_output(
				json_encode(['exito' => "Contacto eliminado correctamente"])
			);
		} else {
			$this->output->set_content_type('application/json')->set_output(
				json_encode(['error' => "Error al eliminar el contacto"])
			);
		}
	}

	public function enviar_correo()
	{
		$data_contacts = null;
		$id_course = $this->input->post('id_curso_enviar');
		$start = $this->input->post('inicio');
		$end = $this->input->post('final');
		if($start == null || $start == "" && $end == null || $end == "")
		{
			$data_contacts = $this->contactos_model->list_contacts("", "");
		}else{
			$data_contacts = $this->contactos_model->list_contacts($start, $end);
		}

		$data_course = $this->contactos_model->course_data($id_course);
		$last_courses = $this->contactos_model->list_last_courses($id_course);
		var_dump($last_courses);
//		$send = new SendEmail();
//		$response = $send->send_email_course($data_course, $data_contacts);
//		if(count($response) > 0)
//		{
//			$this->output->set_content_type('application/json')->set_output(json_encode(
//				['exito' => "Se han enviado {$response[0]} correos, {$response[1]} correos no se ha enviado y {$response[2]} contactos no tienen correo registrado"]
//			));
//		}else{
//			$this->output->set_content_type('application/json')->set_output(json_encode(
//				['error' => "Error al enviar los correos"]
//			));
//		}
	}
}
