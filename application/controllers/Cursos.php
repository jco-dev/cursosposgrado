<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');
require_once APPPATH . '/controllers/Reportes/ImprimirCertificado.php';
require_once APPPATH . '/controllers/SendEmail.php';
class Cursos extends PSG_Controller
{
	public $cn = 1;
	public $cnest = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cursos_model');
		$this->cn = 1;
		$this->cnest=1;
	}

	public function index()
	{
		$this->data['total_course'] = $this->cursos_model->total_course();
		$this->data['total_cursos'] = $this->cursos_model->total_cursos();
		$this->data['course'] = $this->cursos_model->lista_course(TRUE);
		$this->data['cursos'] = $this->cursos_model->lista_cursos(TRUE);
		$this->templater->view('cursos/index', $this->data);
	}

	public function insertar()
	{
		$course = $this->cursos_model->lista_course(current($this->input->post()));
		if (empty($course['code'])) {
			$id = $this->cursos_model->insertar_curso(array('nombre_curso' => $course['fullname'], 'nombre_corto' => $course['shortname'], 'imagen_certificado' => $course['id'], 'id_moodle' => $course['id']));
			if (empty($id['code'])) {
				$this->session->set_flashdata("success", "Registro insertado correctamente. [" . $id . "]");
			} else {
				$this->session->set_flashdata($id['code'], $id['message']);
			}
		} else {
			$this->session->set_flashdata($course['code'], $course['message']);
		}
		redirect(base_url('cursos'));
	}

	public function vincular()
	{
		if ($this->input->post('id_course') && $this->input->post('id_cursos')) {
			$id = $this->cursos_model->vincular_curso($this->input->post('id_cursos'), $this->input->post('id_course'));
			if (empty($id['code'])) {
				$this->session->set_flashdata("success", "Registro vinculado correctamente. [" . $id . "]");
			} else {
				$this->session->set_flashdata($id['code'], $id['message']);
			}
		} else {
			$this->session->set_flashdata("warning", "No se han enviado datos.");
		}
		redirect(base_url('cursos'));
	}

	public function desvincular()
	{
		if ($this->input->post()) {
			$id = $this->cursos_model->desvincular_curso(current($this->input->post()));
			if (empty($id['code'])) {
				$this->session->set_flashdata("success", "Registro desvinculado correctamente. [" . $id . "]");
			} else {
				$this->session->set_flashdata($id['code'], $id['message']);
			}
		} else {
			$this->session->set_flashdata("warning", "No se han enviado datos.");
		}
		redirect(base_url('cursos'));
	}

	/** CURSOS */
	public function ver_cursos()
	{
		$this->templater->view('cursos/cursos', $this->data);
	}

	public function ver_estudiantes($id)
	{
		$this->data['id'] = $id;
		$this->templater->view('cursos/estudiantes', $this->data);
	}

	public function ajax_listado_cursos()
	{
		if ($this->input->is_ajax_request()) {
			$table = "mdl_listado_cursos";
			$primaryKey = 'id';
			$columns = array(
				array('dt' => 0, 'db' => 'id', 'formatter' => function($id){
					return $this->cn++;
				}),
				array('dt' => 1, 'db' => 'fullname', 'formatter' => function ($fullname) {
					return '' . $fullname . '';
				}),
				array('dt' => 2, 'db' => 'shortname', 'formatter' => function ($shortname) {
					$numero = random_int(0, 6);
					$estados = [
						'success',
						'danger',
						'success',
						'warning',
						'dark',
						'primary',
						'info',
					];
					$estado = $estados[$numero];

					return "<span class='label label-light-$estado label-inline mr-2'>" . $shortname . "</span>";
				}),
				array('dt' => 3, 'db' => 'id', 'formatter' => function ($id) {
					$respuesta = $this->cursos_model->contar_estudiantes($id);
					return "<span class='label label-info label-inline mr-2'>" . $respuesta[0]->cantidad . "</span>";
				}),
				array('dt' => 4, 'db' => 'id', 'formatter' => function ($id) {
					$respuesta = $this->cursos_model->contar_modulos($id);
					return "<span class='label label-danger label-inline mr-2'>" . $respuesta[0]->cantidad . "</span>";
				}),
				array('dt' => 5, 'db' => 'id', 'formatter' => function ($id) {
					return '
					<a id="btn_configuracion" data-id=' . $id . ' href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Configuracion del curso para el certificado">
						<i class="nav-icon la la-cog"></i>
					</a>
					<a id="btn_inscripcion" data-id=' . $id . ' href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Inscripcion de estudiantes">
						<i class="nav-icon la la-list"></i>
					</a>
					<a id="btn_ver_inscritos" data-id=' . $id . ' href="' . base_url('cursos/ver_estudiantes/' . $id) . '" class="btn btn-sm btn-clean btn-icon" title="Listado estudiantes inscritos en el Curso">
						<i class="la la-users"></i>
					</a>
					<a id="btn_imprimir_todos" data-id=' . $id . ' href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Imprimir todos los certificados del Curso">
						<i class="nav-icon la la-print"></i>
					</a>

					<a id="btn_imprimir_blanco" data-id=' . $id . ' href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Imprimir certificado en blanco">
						<i class="nav-icon la la-print"></i>
					</a>

					<a id="btn_enviar_por_correo" data-id=' . $id . ' href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Enviar certificados">
						<i class="nav-icon la la-send"></i>
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

	/** INGRESAR CONFIGURACION DEL CURSO */
	public function ingresar_configuracion()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$respuesta = $this->cursos_model->verificar_configuracion($id);
			if ($respuesta) {
				$res = $this->sql_ssl->insertar_tabla(
					'configuracion_curso',
					[
						'id_course_moodle'          => $id,
						'carga_horaria'             => 180,
						'posx_nombre_participante'  => 62,
						'posy_nombre_participante'  => 82,
						'posx_bloque_texto' 	    => 27,
						'posy_bloque_texto'         => 105,
						'posx_qr' 				    => 231,
						'posy_qr' 				    => 30,
						'tamano_titulo'             => 23,
						'tamano_subtitulo' 		    => 15,
						'tamano_texto' 			    => 15,
						'color_nombre_participante' => "0, 0, 0",
						'color_subtitulo' 		   	=> "0, 0, 0",
						'fecha_creacion'   		   	=> date('Y-m-d H:i:s')
					]
				);
				if (is_numeric($res)) {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'exito' => 'Configuración ingresado correctamente'
						]
					));
				} else {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'error' => 'Error al ingresar la configuración'
						]
					));
				}
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'warning' => 'El curso ya esta registrado para la configuración'
					]
				));
			}
		}
	}

	/** INSCRIPCION ESTUDIANTES */
	public function inscribir_estudiantes()
	{
		$id = $this->input->post('id');
		$respuesta = $this->cursos_model->get_listado_estudiantes_curso($id);
		// var_dump($respuesta);
		if ($respuesta == null) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'warning' => 'No existen estudiantes en el curso'
				]
			));
		} else {
			// INSCRIBIR ESTUDIANTES
			$cn = 0;
			foreach ($respuesta as $key => $valor) {
				$res = $this->sql_ssl->listar_tabla('inscripcion_curso', ['id_user_moodle' => $valor->id_user_moodle, 'id_course_moodle' => $valor->id_course_moodle]);
				// var_dump($res);
				if (count($res) == 0) {
					$resp = $this->sql_ssl->insertar_tabla(
						'inscripcion_curso',
						[
							'id_user_moodle' => $valor->id_user_moodle,
							'id_course_moodle' => $valor->id_course_moodle,
							'calificacion_final' => $valor->nota
						]
					);
					if (is_numeric($resp)) {
						$cn++;
					}
				}
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'exito' => 'Cantidad de estudiantes incritos en el curso ' . $cn
				]
			));
		}
	}

	public function ajax_listado_estudiantes_curso()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$table = 'mdl_inscripcion_curso_vista';
			$primaryKey = 'id_inscripcion_curso';
			$condicion = 'id=' . $id;
			$columns = array(
				array('dt' => 0, 'db' => 'id_inscripcion_curso', 'formatter' => function($id){
					return $this->cnest++;
				}),
				array('dt' => 1, 'db' => 'usuario'),
				array('dt' => 2, 'db' => 'id'),
				array('dt' => 3, 'db' => 'calificacion_final', 'formatter' => function ($nota) {
					if ($nota <= 60) {
						return '<span class="label label-rounded label-danger mr-2">' . $nota . '</span>';
					} elseif ($nota > 60 && $nota <= 80) {
						return '<span class="label label-rounded label-warning mr-2">' . $nota . '</span>';
					} else {
						return '<span class="label label-rounded label-success mr-2">' . $nota . '</span>';
					}
				}),
				array('dt' => 4, 'db' => 'tipo_pago'),
				array('dt' => 5, 'db' => 'nro_transaccion'),
				array('dt' => 6, 'db' => 'monto_pago'),
				array('dt' => 7, 'db' => 'respaldo_pago', 'formatter' => function ($img) {
					if ($img == "") {
						return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
					} else {
						return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url("$img") . '" alt="foto curso" />';
					}
				}),
				array('dt' => 8, 'db' => 'tipo_participacion', 'formatter' => function ($tipo) {
					if ($tipo == "PARTICIPANTE") {
						return '<span class="label label-info label-inline mr-2">' . $tipo . '</span>';
					} else {
						return '<span class="label label-success label-inline mr-2">' . $tipo . '</span>';
					}
				}),
				array('dt' => 9, 'db' => 'fecha_entrega'),
				array('dt' => 10, 'db' => 'entregado_a'),
				array('dt' => 11, 'db' => 'observacion_entrega'),
				array('dt' => 12, 'db' => 'fecha_registro'),
				array('dt' => 13, 'db' => 'tipo_certificacion_solicitado'),
				array('dt' => 14, 'db' => 'certificacion_unica', 'formatter' => function ($cert, $row) {
					$opcion = '';
					foreach (['', 'CURSO', 'MODULO', 'AMBOS'] as $key => $value) {
						$opcion .= "<option value='" . $value . "' " . ($cert == $value ? 'selected' : '') . " >$value</option>";
					}

					return '<select id="certificacion_unica" data-id=' . $row["id_inscripcion_curso"] . '  name="certificacion_unica" class="form-control">
						' . $opcion . '
					</select>';
				}),

				array('dt' => 15, 'db' => 'estado_inscripcion_curso', 'formatter' => function ($estado, $row) {
					$opcion = '';
					if ($estado == "REGISTRADO") {
						$opcion .= '<option selected value="REGISTRADO">REGISTRADO</option>
						<option value="ENTREGADO">ENTREGADO</option>
						<option value="ELIMINADO">ELIMINADO</option>';
					} elseif ($estado == "ENTREGADO") {
						$opcion .= '<option value="REGISTRADO">REGISTRADO</option>
						<option selected value="ENTREGADO">ENTREGADO</option>
						<option value="ELIMINADO">ELIMINADO</option>';
					} else {
						$opcion .= '<option value="REGISTRADO">REGISTRADO</option>
						<option  value="ENTREGADO">ENTREGADO</option>
						<option selected value="ELIMINADO">ELIMINADO</option>';
					}
					return '<select id="estado_inscripcion_curso" data-id=' . $row["id_inscripcion_curso"] . '  name="estado_inscripcion_curso" class="form-control">
						' . $opcion . '
					</select>';
				}),
				array('dt' => 16, 'db' => 'id_inscripcion_curso', 'formatter' => function ($id, $row) {
					return "<a data-id='" . $id . "' id='editar_inscripcion_curso' data-nombre='" . $row['usuario'] . "' href='javascript:;' class='btn btn-light-warning btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Editar datos del estudiante'>
					<i class='nav-icon la la-edit'></i>
					</a>
					<a data-curso='" . $row["id"] . "' data-id='" . $id . "' data-nombre='" . $row['usuario'] . "' id='imprimir_certificado'  href='javascript:;' class='btn btn-light-primary btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Imprimir certificado'>
						<i class='nav-icon la la-print'></i>
					</a>";
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

	public function editar_conf_curso()
	{
		$id = $this->input->post('id');
		$respuesta = $this->cursos_model->editar_inscripcion_curso($id);
		$this->output->set_content_type('application/json')->set_output(json_encode(
			[
				'exito' => $respuesta
			]
		));
	}

	public function actualizar_conf_curso()
	{
		$id_inscripcion_curso = $this->input->post('id_inscripcion_curso');
		$calificacion_final = $this->input->post('calificacion_final');
		$tipo_pago = $this->input->post('tipo_pago');
		$nro_transaccion = $this->input->post('nro_transaccion');
		$monto_pago = $this->input->post('monto_pago');
		$respaldo_pago = $this->input->post('respaldo_pago');
		$tipo_participacion = $this->input->post('tipo_participacion');
		$fecha_entrega = $this->input->post('fecha_entrega');
		$entregado_a = $this->input->post('entregado_a');
		$observacion_entrega = $this->input->post('observacion_entrega');
		$tipo_certificacion_solicitado = $this->input->post('tipo_certificacion_solicitado');
		$ruta = "";

		if (isset($_FILES["respaldo_pago"]) && $_FILES["respaldo_pago"]['name'] != "") {
			$subir_foto = true;
			$uploadedfile_size = $_FILES['respaldo_pago']['size'];
			if ($_FILES['respaldo_pago']['size'] > 2000000) {
				$subir_foto = false;
			}

			if (!($_FILES['respaldo_pago']['type'] == "image/jpeg" or $_FILES['respaldo_pago']['type'] == "image/png")) {
				$subir_foto = false;
			}

			$file_name = $_FILES["respaldo_pago"]['name'];
			$extension = explode(".", $file_name);
			$nombre = date('Ymdhis') . '_' . mt_rand(100, 9999);
			$ruta = "assets/img/respaldo_pago/$nombre.$extension[1]";

			if ($subir_foto) {
				move_uploaded_file($_FILES["respaldo_pago"]['tmp_name'], $ruta);
				$respuesta = $this->sql_ssl->modificar_tabla(
					'inscripcion_curso',
					[
						'calificacion_final' => $calificacion_final,
						'tipo_pago' => $tipo_pago,
						'nro_transaccion' => $nro_transaccion,
						'monto_pago' => $monto_pago,
						'tipo_participacion' => $tipo_participacion,
						'fecha_entrega' => $fecha_entrega,
						'respaldo_pago' => $ruta,
						'entregado_a' => $entregado_a,
						'observacion_entrega' => $observacion_entrega,
						'tipo_certificacion_solicitado' => $tipo_certificacion_solicitado
					],
					['id_inscripcion_curso' => $id_inscripcion_curso]
				);

				if ($respuesta) {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'exito' => 'Asignacion de curso editado correctamente'
						]
					));
				} else {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							'error' => 'Error al editar la asignacion del curso'
						]
					));
				}
			}
		} else {
			$respuesta = $this->sql_ssl->modificar_tabla(
				'inscripcion_curso',
				[
					'calificacion_final' => $calificacion_final,
					'tipo_pago' => $tipo_pago,
					'nro_transaccion' => $nro_transaccion,
					'monto_pago' => $monto_pago,
					'tipo_participacion' => $tipo_participacion,
					'fecha_entrega' => $fecha_entrega,
					'entregado_a' => $entregado_a,
					'observacion_entrega' => $observacion_entrega,
					'tipo_certificacion_solicitado' => $tipo_certificacion_solicitado
				],
				['id_inscripcion_curso' => $id_inscripcion_curso]
			);

			if ($respuesta) {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'exito' => 'Asignacion de curso editado correctamente'
					]
				));
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'error' => 'Error al editar la asignacion del curso'
					]
				));
			}
		}
	}

	public function estado_inscripcion_curso()
	{
		$id = $this->input->post('id');
		$valor = $this->input->post('valor');
		$respuesta = $this->sql_ssl->modificar_tabla(
			'inscripcion_curso',
			['estado_inscripcion_curso' => $valor],
			['id_inscripcion_curso' => $id]
		);

		if ($respuesta) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'exito' => 'Inscripcion cambiado de estado correctamente'
				]
			));
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'Error al cambiar de estado a la inscripcion'
				]
			));
		}
	}

	public function certificacion_unica()
	{
		$id = $this->input->post('id');
		$valor = $this->input->post('valor');
		if ($valor != "") {
			$respuesta = $this->sql_ssl->modificar_tabla(
				'inscripcion_curso',
				['certificacion_unica' => $valor],
				['id_inscripcion_curso' => $id]
			);

			if ($respuesta) {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'exito' => 'Inscripcion cambiado de estado correctamente'
					]
				));
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'error' => 'Error al cambiar de estado a la inscripcion'
					]
				));
			}
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'El estado no puede ser vacio'
				]
			));
		}
	}

	public function imprimir_certificado()
	{
		$id = $this->input->post('id');
		$idcurso = $this->input->post('idcurso');
		$tipo = $this->input->post('tipo');

		$datos_curso = $this->cursos_model->get_datos_curso($idcurso);

		$modulos = $this->sql_ssl->listar_tabla(
			'mdl_certificacion',
			['id_course' => $idcurso, 'estado' => 'REGISTRADO']
		);

		if ($datos_curso == NULL) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
				]
			));
		} else {

			$data = array();
			$estudiante = $this->cursos_model->get_datos_estudiante($id);

			if (count($estudiante) > 0) {
				$fila = array();
				array_push($fila, $estudiante[0]->id_inscripcion_curso);
				array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante[0]->usuario)), MB_CASE_UPPER));
				array_push($fila, $estudiante[0]->calificacion_final);
				array_push($fila, $estudiante[0]->tipo_participacion);
				array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($datos_curso[0]->nombre_curso)), MB_CASE_UPPER));
				array_push($fila, $datos_curso[0]->fecha_inicial);
				array_push($fila, $datos_curso[0]->fecha_final);
				array_push($fila, $datos_curso[0]->carga_horaria);
				array_push($fila, $datos_curso[0]->fecha_certificacion);

				array_push($data, $fila);
			}

			foreach ($modulos as $key => $r) {
				$modulo = array();
				array_push($modulo, $estudiante[0]->id_inscripcion_curso);
				array_push($modulo, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante[0]->usuario)), MB_CASE_UPPER));
				array_push($modulo, $estudiante[0]->calificacion_final);
				array_push($modulo, $estudiante[0]->tipo_participacion);
				array_push($modulo, mb_convert_case(preg_replace('/\s+/', ' ', trim($r->nombre)), MB_CASE_UPPER));
				array_push($modulo, $r->fecha_inicial);
				array_push($modulo, $r->fecha_final);
				array_push($modulo, $r->carga_horaria);
				array_push($modulo, $r->fecha_certificacion);
				array_push($data, $modulo);
			}

			$rep = new ImprimirCertificado();
			$rep->imprimir($datos_curso, $data, $tipo);
		}
	}

	public function imprimir_certificado_todos()
	{
		$id = $this->input->post('id');
		$value = $this->input->post('value');
		$estudiantes = $this->cursos_model->get_estudiantes_curso($id);
		$data = array();

		if (!empty($estudiantes)) {
			$datos_curso = $this->cursos_model->get_datos_curso($estudiantes[0]->id);
			if ($datos_curso == NULL) {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
					]
				));
			} else {

				if (count($estudiantes) > 0) {

					$datos_curso = $this->cursos_model->get_datos_curso($estudiantes[0]->id);
					$imagen = $datos_curso[0]->imagen_curso;
					foreach ($estudiantes as $key => $estudiante) {
						// var_dump($estudiante);
						if ($estudiante->certificacion_unica == "CURSO") {
							$fila = array();
							array_push($fila, $estudiante->id_inscripcion_curso);
							array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER));
							array_push($fila, $estudiante->calificacion_final);
							array_push($fila, $estudiante->tipo_participacion);
							array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($datos_curso[0]->nombre_curso)), MB_CASE_UPPER));
							array_push($fila, $datos_curso[0]->fecha_inicial);
							array_push($fila, $datos_curso[0]->fecha_final);
							array_push($fila, $datos_curso[0]->carga_horaria);
							array_push($fila, $datos_curso[0]->fecha_certificacion);

							array_push($data, $fila);
						} elseif ($estudiante->certificacion_unica == "MODULO") {
							// Listado de modulos de un curso

							$respuesta = $this->sql_ssl->listar_tabla(
								'mdl_certificacion',
								['id_course' => $estudiante->id, 'estado' => 'REGISTRADO']
							);

							foreach ($respuesta as $key => $r) {
								$modulo = array();
								array_push($modulo, $estudiante->id_inscripcion_curso);
								array_push($modulo, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER));
								array_push($modulo, $estudiante->calificacion_final);
								array_push($modulo, $estudiante->tipo_participacion);
								array_push($modulo, mb_convert_case(preg_replace('/\s+/', ' ', trim($r->nombre)), MB_CASE_UPPER));
								array_push($modulo, $r->fecha_inicial);
								array_push($modulo, $r->fecha_final);
								array_push($modulo, $r->carga_horaria);
								array_push($modulo, $r->fecha_certificacion);
								array_push($data, $modulo);
							}
						} else { // para ambos
							// Agregar del curso
							$fila = array();
							array_push($fila, $estudiante->id_inscripcion_curso);
							array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER));
							array_push($fila, $estudiante->calificacion_final);
							array_push($fila, $estudiante->tipo_participacion);
							array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($datos_curso[0]->nombre_curso)), MB_CASE_UPPER));
							array_push($fila, $datos_curso[0]->fecha_inicial);
							array_push($fila, $datos_curso[0]->fecha_final);
							array_push($fila, $datos_curso[0]->carga_horaria);
							array_push($fila, $datos_curso[0]->fecha_certificacion);

							array_push($data, $fila);

							// agregar modulos

							$respuesta = $this->sql_ssl->listar_tabla(
								'mdl_certificacion',
								['id_course' => $estudiante->id, 'estado' => 'REGISTRADO']
							);

							foreach ($respuesta as $key => $r) {
								$modulo = array();
								array_push($modulo, $estudiante->id_inscripcion_curso);
								array_push($modulo, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER));
								array_push($modulo, $estudiante->calificacion_final);
								array_push($modulo, $estudiante->tipo_participacion);
								array_push($modulo, mb_convert_case(preg_replace('/\s+/', ' ', trim($r->nombre)), MB_CASE_UPPER));
								array_push($modulo, $r->fecha_inicial);
								array_push($modulo, $r->fecha_final);
								array_push($modulo, $r->carga_horaria);
								array_push($modulo, $r->fecha_certificacion);
								array_push($data, $modulo);
							}
						}
					}
					// var_dump($data);
				}

				$rep = new ImprimirCertificado();
				$rep->imprimir_todos($datos_curso, $data, $value);
			}
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'No existen estudiantes inscritos en el curso'
				]
			));
		}
	}

	public function imprimir_certificado_blanco()
	{
		$id = $this->input->post('id');
		$value = $this->input->post('value');
		$tipo = $this->input->post('tipo');
		$datos_curso = $this->cursos_model->get_datos_curso($id);
		$respuesta = $this->sql_ssl->listar_tabla(
			'mdl_certificacion',
			['id_course' => $id, 'estado' => 'REGISTRADO']
		);
		//
		if ($datos_curso == NULL) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
				]
			));
		} else {
			$curso_data = array();
			foreach ($datos_curso as $key => $curso) {
				$d = array();
				array_push($d, $curso->nombre_curso);
				array_push($d, $curso->fecha_inicial);
				array_push($d, $curso->fecha_final);
				array_push($d, $curso->carga_horaria);
				array_push($d, $curso->fecha_certificacion);
				array_push($d, $curso->imagen_curso);
				array_push($d, $value);
				array_push($curso_data, $d);
			}
			//
			foreach ($respuesta as $key => $r) {
				$d = array();
				array_push($d, $r->nombre);
				array_push($d, $r->fecha_inicial);
				array_push($d, $r->fecha_final);
				array_push($d, $r->carga_horaria);
				array_push($d, $r->fecha_certificacion);
				array_push($d, $datos_curso[0]->imagen_curso);
				array_push($d, $value);

				array_push($curso_data, $d);
			}

			$rep = new ImprimirCertificado();
			$rep->imprimir_blanco($curso_data, $datos_curso, $tipo);
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
			}
		}

		// Enviar los correos
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
				} else {
					$rep = new ImprimirCertificado();
					$respuesta = $rep->guardar_certificados($datos_curso, $estudiantes);

					if (is_int($respuesta)) {
						// enviar por email 
						$respuesta1 = $this->cursos_model->get_estudiantes_send($idcurso);
						$send = new SendEmail();
						$res = $send->enviar_correos($respuesta1);
						// var_dump($res);
						if (is_int($res)) {
							$this->output->set_content_type('application/json')->set_output(json_encode(
								[
									'exito' => 'Correos enviados correctamente'
								]
							));
						} else {
							$this->output->set_content_type('application/json')->set_output(json_encode(
								[
									'error' => 'Error al enviar los correos'
								]
							));
						}
					}
				}
			}
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'No existen estudiantes inscritos en el curso'
				]
			));
		}
	}

	// Descargar pdf curso
	// public function descargar_pdf_curso()
	// {
	// 	$id = $this->input->post('id');
	// 	$idcurso = $this->encryption->decrypt(base64_decode($id));
	// 	$pdf = $this->cursos_model->get_url_pdf($idcurso);
	// 	if (count($pdf) == 1) {
	// 		$filepath = $pdf[0]->url_pdf;
	// 		echo $filepath;
	// 	} else {
	// 		$this->output->set_content_type('application/json')->set_output(json_encode(
	// 			[
	// 				'error' => 'Error al descargar la informacion del curso'
	// 			]
	// 		));
	// 	}
	// }

	public function ci()
	{
		$this->templater->view('verificacion/ci', $this->data);
	}

	public function verificar_ci()
	{
		$id = $this->input->post("ci");
		$respuesta = $this->sql_ssl->listar_tabla(
			'mdl_ver_cursos_inscritos_ci',
			['ci' => $id]
		);

		$res = '<table width=100% class="table table-responsive-sm table-responsive-md table-bordered table-condensed table-striped">
		<thead class="thead">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				<th scope="col">Curso</th>
				<th scope="col">Tipo Participacion</th>
				<th scope="col">Fecha Inicio</th>
				<th scope="col">Fecha Final</th>
			</tr>
		</thead>';

		if (count($respuesta) > 0) {
			$cn = 1;
			foreach ($respuesta as $key => $value) {
				$res .= '<tbody>
					<tr>
						<th scope="row">' . $cn . '</th>
						<td>' . $value->nombre_completo . '</td>
						<td>' . $value->curso . '</td>
						<td>
							<span class="label label-inline label-light-primary font-weight-bold">
								PARTICIPANTE
							</span>
						</td>
						<td>'.$value->fecha_inicial.'</td>
						<td>'.$value->fecha_final.'</td>
					</tr>
				</tbody>';
				$cn++;
			}
		} else {
			$res .= '<tbody>
				<tr>
					<td colspan="6" class="text-center">No existe registros con el ci: ' . $id . '</td>
				</tr>
			</tbody>';
		}



		$res .= '</table>';
		echo $res;
	}
}
