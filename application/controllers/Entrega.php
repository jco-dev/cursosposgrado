<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('America/La_Paz');

class Entrega extends PSG_Controller
{
    public $cn = 1;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('entrega_model');
        $this->cn = 1;
    }

    public function index()
    {
        $this->templater->view('entrega/index', $this->data);
    }

    public function ajax_listado_estudiantes()
    {
        if ($this->input->is_ajax_request()) {
            $table = "mdl_inscripcion_curso_vista";
            $primaryKey = 'id_inscripcion_curso';
            $columns = array(
                array('dt' => 0, 'db' => 'id_user'),
                array('dt' => 1, 'db' => 'usuario', 'formatter' => function ($fullname) {
                    return '<small>' . $fullname . '</small>';
                }),
                array('dt' => 2, 'db' => 'fullname', 'formatter' => function ($fullname) {
                    return '<small>' . $fullname . '</small>';
                }),
                array('dt' => 3, 'db' => 'calificacion_final'),
                array('dt' => 4, 'db' => 'tipo_pago'),
                array('dt' => 5, 'db' => 'monto_pago'),
                array('dt' => 6, 'db' => 'certificacion_unica', 'formatter' => function($data){
                    if($data == null || $data == ""){
                        return "CURSO";
                    }else{
                        return $data;
                    }

                }),
                array('dt' => 7, 'db' => 'certificado_recogido'),
                array('dt' => 8, 'db' => 'fecha_entrega'),
                array('dt' => 9, 'db' => 'entregado_a'),
                array('dt' => 10, 'db' => 'observacion_entrega'),
                array('dt' => 11, 'db' => 'fecha_registro'),
                array('dt' => 12, 'db' => 'id_inscripcion_curso', 'formatter' => function ($id, $row) {
                    return "
                        <a id='btn_entregar' nombre='" . $row['usuario'] . "' curso='" . $row['fullname'] . "' data-id=" . $id . " href='javascript:;' class='btn btn-light-primary btn-sm font-weight-bold mr-2' title='Entregar certificado'>
                            <i class='nav-icon la la-plus'></i>
                            Entregar
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
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, NULL)
            ));
            return;
        }
    }

    
    public function editar()
    {
        $id = $this->input->post('id');
        $respuesta = $this->sql_ssl->listar_tabla(
            'mdl_inscripcion_curso',
            ['id_inscripcion_curso' => $id]
        );

        if (count($respuesta) > 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'exito' => $respuesta
                ]
            ));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'error' => 'Error al entregar el certificado del curso'
                ]
            ));
        }
    }

    public function actualizar_entrega()
    {
       
        date_default_timezone_set('America/La_Paz');
		$id_inscripcion_curso = $this->input->post('id_inscripcion_curso_e');
		$fecha_entrega = $this->input->post('fecha_entrega_e');
		$entregado_a = trim($this->input->post('entregado_a_e'));
		$observacion_entrega = trim($this->input->post('observacion_entrega_e'));
		$certificado_recogido = $this->input->post('certificado_recogido_e');

        $respuesta = $this->sql_ssl->modificar_tabla(
            'mdl_inscripcion_curso',
            [
                
                'fecha_entrega' => $fecha_entrega . date(' h:i:s'),
                'certificado_recogido' => $certificado_recogido,
                'entregado_a' => $entregado_a,
                'observacion_entrega' => $observacion_entrega,
            ],
            ['id_inscripcion_curso' => $id_inscripcion_curso]
        );

        if ($respuesta) {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'exito' => 'Entrega registrado correctamente'
                ]
            ));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'error' => 'Error al editar la entrega del certificado'
                ]
            ));
        }
    }

    public function eliminar_configuracion()
    {
        $id = $this->input->post('id');
        $respuesta = $this->sql_ssl->modificar_tabla(
            'configuracion_curso',
            ['estado_curso' => 'ELIMINADO'],
            ['id_configuracion_curso' => $id]
        );
        if ($respuesta) {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'exito' => 'Configuracion del curso eliminado correctamente'
                ]
            ));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'error' => 'Error eliminar la configuracion del curso'
                ]
            ));
        }
    }

    public function subir_imagen_curso()
    {
    }

    // agregar imagen personalizado
    public function edit_agregar_imagen_personalizado()
    {
        $id = $this->input->post('id');
        $respuesta = $this->sql_ssl->listar_tabla(
            'configuracion_curso',
            ['id_configuracion_curso' => $id]
        );

        if (count($respuesta) > 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'exito' => $respuesta
                ]
            ));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(
                [
                    'error' => 'Error al editar la configuracion del curso'
                ]
            ));
        }
    }

    public function update_agregar_imagen_personalizado()
    {
        if ($this->input->is_ajax_request()) {

            $id_configuracion_curso = $this->input->post('id');
            $posx_imagen_personalizado = $this->input->post('posx_imagen_personalizado');
            $posy_imagen_personalizado = $this->input->post('posy_imagen_personalizado');
            $subtitulo = $this->input->post('subtitulo');
            $imprimir = $this->input->post('imprimir');

            // subida de las imagen personalizado del curso
            $ruta = '';
            if ($this->input->post('imagen_personalizado')) {
                if (preg_match('/^data:image\/(\w+);base64,/', $this->input->post('imagen_personalizado'), $formato)) {
                    $imagen = substr($this->input->post('imagen_personalizado'), strpos($this->input->post('imagen_personalizado'), ',') + 1);
                    $nombre = date('Y_m_d_H_i_s') . '.' . strtolower($formato[1]);
                    $ruta = 'assets/img/imagen_personalizado_curso/' . $nombre;
                    file_put_contents(FCPATH . 'assets/img/imagen_personalizado_curso/' . $nombre, base64_decode($imagen));
                }
            }

            if ($ruta == '') {
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'configuracion_curso',
                    [
                        'posx_imagen_personalizado' => $posx_imagen_personalizado,
                        'posy_imagen_personalizado' => $posy_imagen_personalizado,
                        'imprimir_subtitulo' => ($imprimir == '1')? true: false,
                        'subtitulo' => $subtitulo
                    ],
                    ['id_configuracion_curso' => $id_configuracion_curso]

                );

                if ($respuesta) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'exito' => 'Agregado subtitulo del curso correctamente'
                        ]
                    ));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'error' => 'Error al agregar el subtitulo del curso'
                        ]
                    ));
                }
            } elseif ($ruta != '') {
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'configuracion_curso',
                    [
                        'imagen_personalizado' => $ruta,
                        'posx_imagen_personalizado' => $posx_imagen_personalizado,
                        'posy_imagen_personalizado' => $posy_imagen_personalizado,
                        'imprimir_subtitulo' => ($imprimir == '1') ? true : false,
                        'subtitulo' => $subtitulo

                    ],
                    ['id_configuracion_curso' => $id_configuracion_curso]

                );

                if ($respuesta) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'exito' => 'Agregado la imagen personalizado del curso correctamente'
                        ]
                    ));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'error' => 'Error al agregar la imagen personalizado del curso'
                        ]
                    ));
                }
            } 
        }
    }
}
