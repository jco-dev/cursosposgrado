<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');
require_once APPPATH . '/controllers/Reportes/ImprimirCertificado.php';
require_once APPPATH . '/controllers/SendEmail.php';
require_once APPPATH . 'controllers/Reportes/Reporte_economico_excel.php';
class Cursos extends PSG_Controller
{
	public $cn = 1;
	public $cnest = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cursos_model');
		$this->cn = 1;
		$this->cnest = 1;
	}

	public function index()
	{
		$this->data['total_course'] = $this->cursos_mPOSTodel->total_course();
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
		$this->data['certificate_types'] = $this->sql_ssl->listar_tabla(
			'tipo_certificado',
			[
				'estado' => 'REGISTRADO'
			],
		);
		$this->templater->view('cursos/cursos', $this->data);
	}

	public function ver_estudiantes($id)
	{
		$this->data['id'] = $id;
		$data = $this->sql_ssl->listar_tabla(
			'course',
			['id' => $id]
		);
		$this->data['nombre_curso'] = $data[0]->fullname;
		$this->data['nombre_corto'] = $data[0]->shortname;
		$this->templater->view('cursos/estudiantes', $this->data);
	}

	public function ajax_listado_cursos()
	{
		if ($this->input->is_ajax_request()) {
			$table = "mdl_listado_cursos";
			$primaryKey = 'id';
			$columns = array(
				array('dt' => 0, 'db' => 'id', 'formatter' => function ($id) {
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
				array('dt' => 3, 'db' => 'certificado', 'formatter' => function ($img) {
					if ($img == "") {
						return '<img class="img-thumbnail" width="60" heigth="60" src="' . base_url('assets/img/default.jpg') . '" alt="Imagen tipo certificado" />';
					} else {
						return '<img class="img-thumbnail" width="60" heigth="60" src="' . base_url($img) . '" alt="Imagen tipo certificado" />';
					}
				}),
				array('dt' => 4, 'db' => 'id', 'formatter' => function ($id) {
					$respuesta = $this->cursos_model->contar_estudiantes_inscritos($id);
					return "<span class='label label-info label-inline mr-2'>" . $respuesta[0]->cantidad . "</span>";
				}),
				array('dt' => 5, 'db' => 'id', 'formatter' => function ($id) {
					$respuesta = $this->cursos_model->contar_estudiantes_preinscritos($id);
					return "<span class='label label-info label-inline mr-2'>" . $respuesta[0]->cantidad . "</span>";
				}),
				array('dt' => 6, 'db' => 'id', 'formatter' => function ($id) {
					$respuesta = $this->cursos_model->contar_modulos($id);
					return "<span class='label label-danger label-inline mr-2'>" . $respuesta[0]->cantidad . "</span>";
				}),
				array('dt' => 7, 'db' => 'timecreated'),
				array('dt' => 8, 'db' => 'estado_informe', 'formatter' => function ($state, $row) {
					// var_dump($row['id']);
					if ($state == "SI") {
						return "<span class='estado_informe label label-success label-inline mr-2' valor='NO' curso='" . $row['fullname'] . "' valor='NO' id='" . $row['id'] . "' title='Anular el informe entregado' style='cursor: pointer'>ENTREGADO</span>";
					} else {
						return "<span class='estado_informe label label-danger label-inline mr-2' valor='SI' curso='" . $row['fullname'] . "' id='" . $row['id'] . "' title='Cambiar de estado a entregado el informe' style='cursor: pointer'>NO ENTREGADO</span>";
					}
				}),
				array('dt' => 9, 'db' => 'id', 'formatter' => function ($id, $row) {
					$nombre_curso = $row['fullname'];
					return '<div class="dropdown dropdown-inline lista-opciones">
						<a href="#" class="btn btn-light-primary btn-sm font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</a>
						<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
							<ul class="navi flex-column navi-hover py-2">
								<li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
									Elige una acción:
								</li>

								<li class="navi-item">
									<a onclick="configuracion(' . $id . ')" type="button" id="btn_configuracion" class="navi-link" title="Ingresar el curso a la configuración">
										<span class="navi-icon"><i class="la la-cog"></i></span>
										<span class="navi-text">Configuración</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="inscripcion_estudiantes(' . $id . ')" type="button" id="btn_inscripcion" data-id=' . $id . ' class="navi-link" title="Inscripción de estudiantes de la plataforma moodle">
										<span class="navi-icon"><i class="la la-pen-alt"></i></span>
										<span class="navi-text">Inscripción</span>
									</a>
								</li>

									<li class="navi-item">
									<a href="' . base_url("cursos/ver_estudiantes/" . $id) . '" class="navi-link" title="Estudiantes del curso">
										<span class="navi-icon"><i class="la la-users"></i></span>
										<span class="navi-text">Estudiantes</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="imprimir_certificados(' . $id . ')" type="button" id="btn_imprimir_todos" data-id=' . $id . ' class="navi-link" title="Imprimir certificados del curso">
										<span class="navi-icon"><i class="la la-print"></i></span>
										<span class="navi-text">Certificados</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="imprimir_certificado_blanco(' . $id . ')" type="button" id="btn_imprimir_blanco" data-id=' . $id . ' class="navi-link" title="Imprimir certificado en blanco del curso">
										<span class="navi-icon"><i class="la la-print"></i></span>
										<span class="navi-text">Cert. Blanco</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="enviar_certificados_correo(' . $id . ')" type="button" id="btn_enviar_por_correo" data-id=' . $id . ' class="navi-link" title="Enviar certificados del curso por correo">
										<span class="navi-icon"><i class="la la-mail-bulk"></i></span>
										<span class="navi-text">Enviar cert.</span>
									</a>
								</li>

								<li class="navi-item">
									<a href="' . base_url('contactos/enviar/' . $id) . '" class="navi-link" title="Enviar correo del curso a los contactos">
										<span class="navi-icon"><i class="la la-mail-bulk"></i></span>
										<span class="navi-text">Enviar correo</span>
									</a>
								</li>

								<li class="navi-item">
									<a href="' . base_url('inscripcionadmin/ver_inscritos/' . $id) . '" id="btn_ver_preinscritos" data-id=' . $id . ' class="navi-link" title="Listado de preinscritos del curso">
										<span class="navi-icon"><i class="la la-pen-square"></i></span>
										<span class="navi-text">Preinscritos</span>
									</a>
								</li>

								<li class="navi-item">
									<a href="' . base_url('inscripcionadmin/ver_informacion/' . $id) . '"  id="btn_ver_informacion" data-id=' . $id . ' class="navi-link" title="Listado de usuarios que pidieron información del curso">
										<span class="navi-icon"><i class="la la-info-circle"></i></span>
										<span class="navi-text">Información</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="reporte_economico(' . $id . ')" type="button" id="btn_reporte_economico" data-id=' . $id . ' class="navi-link" title="Reporte económico del curso">
										<span class="navi-icon"><i class="la la-print"></i></span>
										<span class="navi-text">Económico</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="reporte_totales(' . $id . ')" type="button" id="btn_reporte_totales" data-id=' . $id . ' class="navi-link" title="Reporte económico total del curso">
										<span class="navi-icon"><i class="la la-money"></i></span>
										<span class="navi-text">Totales</span>
									</a>
								</li>

								<li class="navi-item">
									<a onclick="reporte_estudiantes(' . $id . ')" type="button" id="btn_reporte_estudiantes" data-id=' . $id . ' class="navi-link" title="Reporte de estudiantes del curso">
										<span class="navi-icon"><i class="la la-print"></i></span>
										<span class="navi-text">Estudiantes PDF</span>
									</a>
								</li>
								<li class="navi-item">
									<a onclick="add_certificate_type(' . $id . ')" type="button" id="btn_reporte_estudiantes" data-id=' . $id . ' class="navi-link" title="Agregar tipo certificado">
										<span class="navi-icon"><i class="la la-plus"></i></span>
										<span class="navi-text">Agregar tipo certificado</span>
									</a>
								</li>

								</li>

									<li class="navi-item">
									<a href="' . base_url("cursos/agregar_envios/" . $id) . '" class="navi-link" title="Agregar envio de certificados">
										<span class="navi-icon"><i class="fa fa-truck"></i></span>
										<span class="navi-text">Envío de Certificados</span>
									</a>
								</li>

							</ul>
						</div>
					</div><script>jQuery(".navi").toggleClass("visible")</script>';
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
				// HORIZONTAL
				$res = $this->sql_ssl->insertar_tabla(
					'configuracion_curso',
					[
						'id_course_moodle'          => $id,
						'carga_horaria'             => 180,
						'nota_aprobacion'			=> 65,
						'posx_nombre_participante'  => 25,
						'posy_nombre_participante'  => 90,
						'posx_bloque_texto' 	    => 32,
						'posy_bloque_texto'         => 131,
						'posx_nombre_curso' 	    => 30,
						'posy_nombre_curso'         => 120,
						'posx_qr' 				    => 234,
						'posy_qr' 				    => 40,
						'posx_tipo_participacion' 	=> 32,
						'posy_tipo_participacion'   => 108,
						'tamano_titulo'             => 24,
						'tamano_subtitulo' 		    => 21,
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
			$cn1 = 0;
			foreach ($respuesta as $key => $valor) {
				$res = $this->sql_ssl->listar_tabla('inscripcion_curso', ['id_user_moodle' => $valor->id_user_moodle, 'id_course_moodle' => $valor->id_course_moodle]);
				// return var_dump($res);
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
				} else {
					$response = $this->sql_ssl->modificar_tabla(
						'inscripcion_curso',
						[
							'calificacion_final' => $valor->nota
						],
						[
							'id_inscripcion_curso' => $res[0]->id_inscripcion_curso
						]
					);
					if ($response) {
						$cn1++;
					}
				}
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'exito' => 'Cantidad de estudiantes incritos en el curso ' . $cn . ' y ' . $cn1 . ' notas actualizados'
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
				// array('dt' => 0, 'db' => 'id_inscripcion_curso', 'formatter' => function($id){
				// 	return $this->cnest++;
				// }),
				array('dt' => 0, 'db' => 'id_inscripcion_curso'),
				array('dt' => 1, 'db' => 'usuario'),
				array('dt' => 2, 'db' => 'id'),
				array('dt' => 3, 'db' => 'fullname'),
				array('dt' => 4, 'db' => 'calificacion_final', 'formatter' => function ($nota) {
					if ($nota <= 60) {
						return '<span class="label label-rounded label-danger mr-2">' . $nota . '</span>';
					} elseif ($nota > 60 && $nota <= 80) {
						return '<span class="label label-rounded label-warning mr-2">' . $nota . '</span>';
					} else {
						return '<span class="label label-rounded label-success mr-2">' . $nota . '</span>';
					}
				}),
				array('dt' => 5, 'db' => 'tipo_pago'),

				array('dt' => 6, 'db' => 'monto_pago'),
				array('dt' => 7, 'db' => 'respaldo_pago', 'formatter' => function ($img) {
					if ($img == "") {
						return '<img class="img-thumbnail" width="40" heigth="40" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
					} else {
						return '<img class="img-thumbnail" width="40" heigth="40" src="' . base_url("$img") . '" alt="foto curso" />';
					}
				}),
				array('dt' => 8, 'db' => 'tipo_participacion', 'formatter' => function ($tipo) {
					if ($tipo == "PARTICIPANTE") {
						return '<span class="label label-info label-inline mr-2">' . $tipo . '</span>';
					} else {
						return '<span class="label label-success label-inline mr-2">' . $tipo . '</span>';
					}
				}),
				array('dt' => 9, 'db' => 'certificado_recogido'),
				array('dt' => 10, 'db' => 'fecha_entrega'),
				array('dt' => 11, 'db' => 'entregado_a'),
				array('dt' => 12, 'db' => 'observacion_entrega'),
				array('dt' => 13, 'db' => 'fecha_registro'),
				array('dt' => 14, 'db' => 'tipo_certificacion_solicitado'),
				array('dt' => 15, 'db' => 'certificacion_unica', 'formatter' => function ($cert, $row) {
					$opcion = '';
					foreach (['', 'CURSO', 'MODULO', 'AMBOS'] as $key => $value) {
						$opcion .= "<option value='" . $value . "' " . ($cert == $value ? 'selected' : '') . " >$value</option>";
					}

					return '<select id="certificacion_unica" data-id=' . $row["id_inscripcion_curso"] . '  name="certificacion_unica" class="form-control">
						' . $opcion . '
					</select>';
				}),

				array('dt' => 16, 'db' => 'estado_inscripcion_curso', 'formatter' => function ($estado, $row) {
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
				array('dt' => 17, 'db' => 'id_inscripcion_curso', 'formatter' => function ($id, $row) {
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
		date_default_timezone_set('America/La_Paz');
		$id_inscripcion_curso = $this->input->post('id_inscripcion_curso');
		$calificacion_final = $this->input->post('calificacion_final');
		$tipo_pago = $this->input->post('tipo_pago');
		$nro_transaccion = $this->input->post('nro_transaccion');
		$monto_pago = $this->input->post('monto_pago');
		$respaldo_pago = $this->input->post('respaldo_pago');
		$tipo_participacion = $this->input->post('tipo_participacion');
		$fecha_entrega = $this->input->post('fecha_entrega');
		$entregado_a = trim($this->input->post('entregado_a'));
		$observacion_entrega = trim($this->input->post('observacion_entrega'));
		$tipo_certificacion_solicitado = $this->input->post('tipo_certificacion_solicitado');
		$certificado_recogido = $this->input->post('certificado_recogido');
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
						'fecha_entrega' => $fecha_entrega . date(' h:i:s'),
						'certificado_recogido' => $certificado_recogido,
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
					'certificado_recogido' => $certificado_recogido,
					'fecha_entrega' => $fecha_entrega . date(' h:i:s'),
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

	// IMPRIMIR CERTIFICADO POR ESTUDIANTE Y CURSO
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

			// CURSO
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
				array_push($fila, $datos_curso[0]->imagen_personalizado);
				array_push($fila, $datos_curso[0]->posx_imagen_personalizado);
				array_push($fila, $datos_curso[0]->posy_imagen_personalizado);
				array_push($fila, $datos_curso[0]->color_subtitulo);
				array_push($fila, $datos_curso[0]->fecha_certificacion);
				array_push($fila, "CURSO");

				array_push($data, $fila);
			}

			// MODULOS
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
				array_push($modulo, $r->imagen_modulo);
				array_push($modulo, $r->posx_imagen_modulo);
				array_push($modulo, $r->posy_imagen_modulo);
				array_push($modulo, $r->color_titulo);
				array_push($modulo, $r->fecha_certificacion);
				array_push($modulo, "MODULO");

				array_push($data, $modulo);
			}

			$rep = new ImprimirCertificado();
			$rep->imprimir_certificado_estudiante($datos_curso, $data, $tipo);
		}
	}

	public function imprimir_certificado_todos()
	{
		$id = $this->input->post('id');
		$imprimir_a = $this->input->post('imprimir_a');
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

					foreach ($estudiantes as $key => $estudiante) {
						// CERTIFICACION DEL CURSO
						if ($estudiante->certificacion_unica == "CURSO" || $estudiante->certificacion_unica == "" || $estudiante->certificacion_unica == null) {
							$fila = array();
							array_push($fila, $estudiante->id_inscripcion_curso);
							array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER));
							array_push($fila, $estudiante->calificacion_final);
							array_push($fila, $estudiante->tipo_participacion);
							array_push($fila, mb_convert_case(preg_replace('/\s+/', ' ', trim($datos_curso[0]->nombre_curso)), MB_CASE_UPPER));
							array_push($fila, $datos_curso[0]->fecha_inicial);
							array_push($fila, $datos_curso[0]->fecha_final);
							array_push($fila, $datos_curso[0]->carga_horaria);
							array_push($fila, $datos_curso[0]->imagen_personalizado);
							array_push($fila, $datos_curso[0]->posx_imagen_personalizado);
							array_push($fila, $datos_curso[0]->posy_imagen_personalizado);
							array_push($fila, $datos_curso[0]->color_subtitulo);
							array_push($fila, $datos_curso[0]->fecha_certificacion);
							array_push($fila, "CURSO");

							array_push($data, $fila);
						} elseif ($estudiante->certificacion_unica == "MODULO") {
							// CERTIFICACION POR MODULOS

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
								array_push($modulo, $r->imagen_modulo);
								array_push($modulo, $r->posx_imagen_modulo);
								array_push($modulo, $r->posy_imagen_modulo);
								array_push($modulo, $r->color_titulo);
								array_push($modulo, $r->fecha_certificacion);
								array_push($modulo, "MODULO");

								array_push($data, $modulo);
							}
						} elseif ($estudiante->certificacion_unica == "AMBOS") {
							// CERTIFICACION POR CURSO Y MODULO (AMBOS)

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
							array_push($fila, $datos_curso[0]->imagen_personalizado);
							array_push($fila, $datos_curso[0]->posx_imagen_personalizado);
							array_push($fila, $datos_curso[0]->posy_imagen_personalizado);
							array_push($fila, $datos_curso[0]->color_subtitulo);
							array_push($fila, $datos_curso[0]->fecha_certificacion);
							array_push($fila, "CURSO");

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
								array_push($modulo, $r->imagen_modulo);
								array_push($modulo, $r->posx_imagen_modulo);
								array_push($modulo, $r->posy_imagen_modulo);
								array_push($modulo, $r->color_titulo);
								array_push($modulo, $r->fecha_certificacion);
								array_push($modulo, "MODULO");

								array_push($data, $modulo);
							}
						}
					}
					// return var_dump($data);
				}

				if ($datos_curso[0]->metodo === NULL) {
					$metodo = "certificado1";
				} else {
					$metodo = $datos_curso[0]->metodo;
				}
				$rep = new ImprimirCertificado();
				$rep->$metodo($datos_curso, $data, $imprimir_a, false);
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
		$tipo_participacion = $this->input->post('tipo_participacion');
		$imprimir_a = $this->input->post('imprimir_a');
		// return var_dump($_REQUEST);
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
			$participation_type = null;
			$final_note = null;
			if ($tipo_participacion == "APROBADO" || $tipo_participacion == "PARTICIPADO") {
				if ($tipo_participacion == "APROBADO") {
					$final_note = 100;
				} else {
					$final_note = 10;
				}
				$participation_type = "PARTICIPANTE";
			} else {
				$participation_type = $tipo_participacion;
			}
			$curso_data = array();
			foreach ($datos_curso as $key => $curso) {
				$d = array();
				array_push($d, NULL);
				array_push($d, NULL);
				array_push($d, $final_note);
				array_push($d, $participation_type);
				array_push($d, mb_convert_case(preg_replace('/\s+/', ' ', trim($curso->nombre_curso)), MB_CASE_UPPER));
				array_push($d, $curso->fecha_inicial);
				array_push($d, $curso->fecha_final);
				array_push($d, $curso->carga_horaria);
				array_push($d, $curso->imagen_personalizado);
				array_push($d, $curso->posx_imagen_personalizado);
				array_push($d, $curso->posy_imagen_personalizado);
				array_push($d, $curso->color_subtitulo);
				array_push($d, $curso->fecha_certificacion);
				array_push($d, 'CURSO');

				array_push($curso_data, $d);
			}

			foreach ($respuesta as $key => $r) {
				$d = array();
				array_push($d, NULL);
				array_push($d, NULL);
				array_push($d, $final_note);
				array_push($d, $participation_type);
				array_push($d, mb_convert_case(preg_replace('/\s+/', ' ', trim($r->nombre)), MB_CASE_UPPER));
				array_push($d, $r->fecha_inicial);
				array_push($d, $r->fecha_final);
				array_push($d, $r->carga_horaria);
				array_push($d, $r->imagen_modulo);
				array_push($d, $r->posx_imagen_modulo);
				array_push($d, $r->posy_imagen_modulo);
				array_push($d, $r->color_titulo);
				array_push($d, $r->fecha_certificacion);
				array_push($d, 'MODULO');

				array_push($curso_data, $d);
			}
			if ($datos_curso == null) {
				$metodo = 'certificado1';
			} else {
				$metodo = $datos_curso[0]->metodo;
			}

			// $rep = new ImprimirCertificado();
			// $rep->$metodo($curso_data, $datos_curso, $imprimir_a, true);
			$rep = new ImprimirCertificado();
			$rep->$metodo($datos_curso, $curso_data, $imprimir_a, true);
		}
	}

	public function enviar_certificados()
	{
		$idcurso = $this->input->post('id');

		// verificamos si el directorio certificados_enviar existe
		$path = "assets/certificados/certificados_{$idcurso}";

		// Datos del curso y estudiantes
		$students_course = $this->cursos_model->get_estudiantes_curso($idcurso);
		$course_data = $this->cursos_model->get_datos_curso($students_course[0]->id);

		if ($course_data == NULL) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
				]
			));
		} else {
			if (file_exists($path)) {
				// Verfificar que el directorio no este vacio
				$carpeta = @scandir("assets/certificados/certificados_{$idcurso}");
				if (count($carpeta) > 2) {

					$send = new SendEmail();
					$data = $this->cursos_model->get_estudiantes_send($idcurso);
					$response1 = $send->send_certificates($data, $course_data);
					// var_dump($response1);
					if (is_array($response1)) {
						$this->output->set_content_type('application/json')->set_output(json_encode(
							[
								'exito' => "{$response1[0]} Correos enviados correctamente y {$response1[1]} no se ha enviado"
							]
						));
					} else {
						$this->output->set_content_type('application/json')->set_output(json_encode(
							[
								'error' => 'Error al enviar los correos'
							]
						));
					}
				} else {
					$this->output->set_content_type('application/json')->set_output(json_encode(
						[
							"error" => "Por favor peque los certificados escaneados en la siguiente ruta  assets/certificados/certificados_{$idcurso}"
						]
					));
				}
			} else {
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						"error" => "Por favor crea la siguiente ruta assets/certificados/certificados_{$idcurso} y seguidamente pegue los certificados scaneados del curso"
					]
				));
			}
		}



		// generar certificados del curso en el directorio  assets/certificados_enviar/ en la carpeta id_curso
		// $directory = "assets/certificados_enviar/$idcurso/";
		// $directory1 = "assets/certificados_enviar/enviar_{$idcurso}/";
		// if (!is_dir($directory)) {
		// 	if (mkdir($directory, 0777, true)) {
		// 		chmod($directory, 0777);
		// 	}
		// }

		// if (!is_dir($directory1)) {
		// 	if (mkdir($directory1, 0777, true)) {
		// 		chmod($directory1, 0777);
		// 	}
		// }
		// Enviar los correos
		// $students_course = $this->cursos_model->get_estudiantes_curso($idcurso);

		// if (!empty($students_course)) {
		// 	$course_data = $this->cursos_model->get_datos_curso($students_course[0]->id);
		// 	if ($course_data == NULL) {
		// 		$this->output->set_content_type('application/json')->set_output(json_encode(
		// 			[
		// 				'error' => 'Por favor Ingrese el curso a la configuracion para subir su imagen del certificado y la calibracion de las posiciones de los datos'
		// 			]
		// 		));
		// 	} else {
		// 		$total_images = count(glob("assets/certificados_enviar/$idcurso/{*.jpg}",GLOB_BRACE));
		// 		if($total_images == 10){
		// 			// Send course Certificates
		// 			$print = new ImprimirCertificado();
		// 			$response = $print->generate_certificates($course_data, $students_course);
		// 			if (is_int($response)) {
		// 				// send email
		// 				// var_dump($response);
		// 				$data = $this->cursos_model->get_estudiantes_send($idcurso);
		// 				$send = new SendEmail();
		// 				$response1 = $send->send_certificates($data, $course_data);
		// 				// var_dump($response1);
		// 				if (is_array($response1)) {
		// 					$this->output->set_content_type('application/json')->set_output(json_encode(
		// 						[
		// 							'exito' => "{$response1[0]} Correos enviados correctamente y {$response1[1]} no se ha enviado"
		// 						]
		// 					));
		// 				} else {
		// 					$this->output->set_content_type('application/json')->set_output(json_encode(
		// 						[
		// 							'error' => 'Error al enviar los correos'
		// 						]
		// 					));
		// 				}
		// 			}else{
		// 				echo "no generado los certificados";
		// 			}
		// 		}else{
		// 			$this->output->set_content_type('application/json')->set_output(json_encode(
		// 				[
		// 					"error" => "Por favor suba los 10 certificados escaneados en la carpeta assets/certificados_enviar/$idcurso/ en la carpeta con el id del curso en formato .jpg"
		// 				]
		// 			));
		// 		}

		// 	}
		// } else {
		// 	$this->output->set_content_type('application/json')->set_output(json_encode(
		// 		[
		// 			'error' => 'No existen estudiantes inscritos en el curso'
		// 		]
		// 	));
		// }
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
						<td>' . $value->fecha_inicial . '</td>
						<td>' . $value->fecha_final . '</td>
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

	// REPORTE ECONOMICO DEL CURSO
	public function reporte_economico($id)
	{
		$data_course = $this->cursos_model->get_datos_curso($id);
		$data_students = $this->cursos_model->get_inscritos_preinscritos($id);
		$total_inscrito = $this->cursos_model->total_recaudacion($id, 'INSCRITO');
		$total_i = ($total_inscrito[0]->monto_total != null) ? intval($total_inscrito[0]->monto_total) : 0;
		$total_preinscrito = $this->cursos_model->total_recaudacion($id, 'PREINSCRITO');
		$total_p = ($total_preinscrito[0]->monto_total != null) ? intval($total_preinscrito[0]->monto_total) : 0;
		$total_agrupacion_incritos = $this->cursos_model->total_recaudacion_por_tipo_pago_agrupacion($id, 'INSCRITO');
		$total_agrupacion_preinscritos = $this->cursos_model->total_recaudacion_por_tipo_pago_agrupacion($id, 'PREINSCRITO');
		$rep = new Reporte_economico_excel();
		$rep->reporte_economico_curso($data_course, $data_students, $total_i, $total_p, $total_agrupacion_incritos, $total_agrupacion_preinscritos);
	}

	// REPORTE TOTALES CURSO
	public function reporte_totales_curso()
	{
		$id = $this->input->post('id');
		$data_course = $this->cursos_model->get_datos_curso($id);
		$tipo_inscritos = (array) $this->cursos_model->total_recaudacion_por_tipo_pago($id, 'INSCRITO');
		$tipo_preinscritos = (array) $this->cursos_model->total_recaudacion_por_tipo_pago($id, 'PREINSCRITO');

		$this->output->set_content_type('application/json')->set_output(json_encode(
			[
				"nombre_curso" => $data_course[0]->nombre_curso,
				"id" => $id,
				'inscritos' => $tipo_inscritos,
				'preinscritos' => $tipo_preinscritos,
			]
		));
	}

	public function reporte_totales_pdf()
	{
		$id = $this->input->post('id');
		$data_course = $this->cursos_model->get_datos_curso($id);
		$tipo_inscritos = (array) $this->cursos_model->total_recaudacion_por_tipo_pago($id, 'INSCRITO');
		$tipo_preinscritos = (array) $this->cursos_model->total_recaudacion_por_tipo_pago($id, 'PREINSCRITO');

		$rep = new ImprimirCertificado();
		$rep->imprimir_reporte_total_reacudacion($data_course, $tipo_inscritos, $tipo_preinscritos);
	}

	public function reporte_estudiantes($id)
	{
		$data = $this->sql_ssl->listar_tabla(
			'inscripcion_curso_vista',
			['id' => $id]
		);

		$data_course = $this->cursos_model->get_datos_curso($id);


		$rep = new ImprimirCertificado();
		$rep->imprimir_estudiantes($data, $data_course);
	}

	public function date_impresion()
	{
		$id = $this->input->post('id');
		$response = $this->cursos_model->date_print($id);
		$this->output->set_content_type('application/json')->set_output(json_encode(
			[
				'exito' => $response
			]
		));
		// $data_course = $this->cursos_model->get_datos_curso($id);
	}

	public function cambiar_estado_informe()
	{
		$id = $this->input->post('id');
		$valor = $this->input->post('valor');

		$response = $this->sql_ssl->modificar_tabla(
			'configuracion_curso',
			['estado_informe' => $valor],
			['id_course_moodle' => $id]
		);
		if ($response) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'exito' => "Estado de informe actualizado correctamente "
				]
			));
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => "Error al actualizar el estado de informe"
				]
			));
		}
	}

	public function agregar_envios($id)
	{
		$this->data['id'] = $id;
		$data = $this->sql_ssl->listar_tabla(
			'course',
			['id' => $id]
		);
		$this->data['nombre_curso'] = $data[0]->fullname;
		$this->data['nombre_corto'] = $data[0]->shortname;
		$this->templater->view('cursos/listado_envios', $this->data);
	}

	public function ajax_envio_curso()
	{
		if ($this->input->is_ajax_request()) {
			$table = "mdl_curso_envio_certificados";
			$primaryKey = 'id_envio_certificado';
			$where = "id_course_moodle = " . $this->input->post('id');
			$columns = array(
				array('dt' => 0, 'db' => 'id_envio_certificado'),
				array('dt' => 1, 'db' => 'remitente'),
				array('dt' => 2, 'db' => 'nombre'),
				array('dt' => 3, 'db' => 'celular'),
				array('dt' => 4, 'db' => 'direccion'),
				array('dt' => 5, 'db' => 'departamento'),
				array('dt' => 6, 'db' => 'estado', 'formatter' => function ($d, $row) {
					if ($d == 'REGISTRADO') {
						return '<span class="label  label-inline label-info">REGISTRADO</span>';
					} else if ($d == 'CONFIRMADO') {
						return '<span class="label  label-inline label-success">CONFIRMADO</span>';
					} else {
						return '<span class="label  label-inline label-danger">ELIMINADO</span>';
					}
				}),
				array('dt' => 7, 'db' => 'id_envio_certificado', 'formatter' => function ($id, $row) {
					$opcion = '';
					if ($row['estado'] == "REGISTRADO") {
						$opcion .= '<option selected value="REGISTRADO">REGISTRADO</option>
						<option value="CONFIRMADO">CONFIRMADO</option>
						<option value="ELIMINADO">ELIMINADO</option>';
					} elseif ($row['estado'] == "CONFIRMADO") {
						$opcion .= '<option value="REGISTRADO">REGISTRADO</option>
						<option selected value="CONFIRMADO">CONFIRMADO</option>
						<option value="ELIMINADO">ELIMINADO</option>';
					} else {
						$opcion .= '<option value="REGISTRADO">REGISTRADO</option>
						<option  value="CONFIRMADO">CONFIRMADO</option>
						<option selected value="ELIMINADO">ELIMINADO</option>';
					}
					return '<select id="estado_envio" data-id=' . $id . '  name="estado_envio" class="form-control">
						' . $opcion . '
					</select>
					<buttton id="btn_editar_envio" data-id=' . $id . ' data-remitente="' . $row['remitente'] . '" data-nombre="' . $row['nombre'] . '" data-celular="' . $row['celular'] . '" data-direccion= "' . $row['direccion'] . '" data-departamento="' . $row['departamento'] . '" class="btn btn-warning btn-sm btn-block mt-1"><i class="fa fa-edit"></i></button>';
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
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where, NULL)
			));

			return;
		}
	}

	public function listar_participantes_curso()
	{
		// var_dump($this->input->get('id'));
		$table = "mdl_envio_participantes_curso";
		$primaryKey = 'id_preinscripcion_curso';
		$where = "id_course_moodle = " . $this->input->get('id');
		$columns = array(
			array('dt' => 0, 'db' => 'id_preinscripcion_curso'),
			array('dt' => 1, 'db' => 'id_preinscripcion_curso', 'formatter' => function ($id, $row) {
				return '
						<button class="btn btn-info btn-sm add" data-id-preinscripcion="' . $id . '" data-participante-preinscripcion="' . $row['participante'] . '" data-celular-preinscripcion="' . $row['celular'] . '" data-departamento-preinscripcion="' . $row['departamento'] . '">Agregar</button>
					';
			}),
			array('dt' => 2, 'db' => 'ci'),
			array('dt' => 3, 'db' => 'participante'),
			array('dt' => 4, 'db' => 'celular'),
			array('dt' => 5, 'db' => 'correo'),
			array('dt' => 6, 'db' => 'departamento'),
		);
		$sql_details = array(
			'driver' => $this->db->dbdriver,
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db' => $this->db->database,
			'host' => $this->db->hostname
		);

		$this->output->set_content_type('application/json')->set_output(json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where, NULL)
		));

		return;
	}

	public function guardar_envio()
	{
		if ($this->sql_ssl->listar_tabla('envio_certificados', ['id_preinscripcion_curso' => $this->input->post('id_envio_preinscripcion')])) {
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => "El participante ya esta registrado en el envio"
				]
			));
		} else {
			if ($this->sql_ssl->insertar_tabla(
				'envio_certificados',
				[
					'remitente' => $this->input->post('remitente_persona_envio'),
					'id_preinscripcion_curso' => $this->input->post('id_envio_preinscripcion'),
					'direccion' => $this->input->post('direccion_persona_envio'),
				]
			))
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'exito' => "Persona Agregado para envio correctamente"
					]
				));
			else
				$this->output->set_content_type('application/json')->set_output(json_encode(
					[
						'error' => "El al registrar el envio"
					]
				));
		}
	}

	public function ajax_estado_envio()
	{
		$id = $this->input->post('id');
		$valor = $this->input->post('valor');
		if ($this->sql_ssl->modificar_tabla('envio_certificados', ['estado' => $valor], ['id_envio_certificado' => $id]))
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'exito' => "Estado modificado correctamente"
				]
			));
		else
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => "Error al modificar el estado"
				]
			));
	}

	public function editar_envio()
	{
		$data = [
			'remitente' => trim($this->input->post('editar_remitente')),
			'direccion' => trim($this->input->post('editar_direccion')),
		];
		$id = $this->input->post('editar_id');

		if ($this->sql_ssl->modificar_tabla('envio_certificados', $data, ['id_envio_certificado' => $id]))
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'exito' => "Datos modificados correctamente"
				]
			));
		else
			$this->output->set_content_type('application/json')->set_output(json_encode(
				[
					'error' => "Error al modificar los datos"
				]
			));
	}

	public function reporte_envios($id)
	{

		$data_course = $this->cursos_model->get_datos_curso($id);
		$data = $this->cursos_model->get_datos_envio($id);
		$rep = new ImprimirCertificado();
		$rep->imprimir_envios($data_course, $data);
	}
}
