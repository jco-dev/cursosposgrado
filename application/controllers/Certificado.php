<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('America/La_Paz');

class Certificado extends PSG_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('certificado_model');
    }

    public function index()
    {
        $this->templater->view('certificado/index', $this->data);
    }

    public function ajax_certificate_type_listing()
    {
        if ($this->input->is_ajax_request()) {
            $table = "mdl_tipo_certificado";
            $primaryKey = 'id_tipo_certificado';
            $columns = array(
                array('dt' => 0, 'db' => 'id_tipo_certificado', 'formatter' => function ($id) {
                    return "<small>$id</small>";
                }),
                array('dt' => 1, 'db' => 'imagen', 'formatter' => function ($img) {
                    if ($img == "") {
                        return '<img class="img-thumbnail" width="60" heigth="60" src="' . base_url('assets/img/default.jpg') . '" alt="Imagen tipo certificado" />';
                    } else {
                        return '<img class="img-thumbnail" width="60" heigth="60" src="' . base_url($img) . '" alt="Imagen tipo certificado" />';
                    }
                }),
                array('dt' => 2, 'db' => 'metodo'),
                array('dt' => 3, 'db' => 'posx_nombre_participante'),
                array('dt' => 4, 'db' => 'posy_nombre_participante'),
                array('dt' => 5, 'db' => 'posx_nombre_curso'),
                array('dt' => 6, 'db' => 'posy_nombre_curso'),
                array('dt' => 7, 'db' => 'posx_qr'),
                array('dt' => 8, 'db' => 'posy_qr'),
                array('dt' => 9, 'db' => 'posx_tipo_participacion'),
                array('dt' => 10, 'db' => 'posy_tipo_participacion'),
                array('dt' => 11, 'db' => 'posx_bloque_texto'),
                array('dt' => 12, 'db' => 'posy_bloque_texto'),
                array('dt' => 13, 'db' => 'tamano_participante'),
                array('dt' => 14, 'db' => 'tamano_curso'),
                array('dt' => 15, 'db' => 'tamano_texto'),
                array('dt' => 16, 'db' => 'orientacion'),
                array('dt' => 17, 'db' => 'estado', 'formatter' => function ($estado) {
                    return "<span class='label label-light-primary label-inline mr-2'>" . $estado . "</span>";
                }),
                array('dt' => 18, 'db' => 'id_tipo_certificado', 'formatter' => function ($id) {
                    return '
					<a id="btn-edit-certificate-type" data-id=' . $id . ' href="javascript:;" class="btn btn-warning btn-sm btn-clean btn-icon" title="Editar">
						<i class="nav-icon la la-edit"></i>
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

    public function guardar_tipo_certificado()
    {
        $id_tipo_certificado = $this->input->post('id_tipo_certificado');
        $id_course_moodle = $this->input->post('id_course');
        $settings = $this->sql_ssl->listar_tabla(
            'tipo_certificado',
            [
                'id_tipo_certificado' => $id_tipo_certificado,
                'estado' => 'REGISTRADO'
            ]
        );
        if (count($settings) > 0) {
            $response = $this->sql_ssl->modificar_tabla(
                'configuracion_curso',
                [
                    'id_tipo_certificado' => $id_tipo_certificado,
                    'orientacion' => $settings[0]->orientacion,
                    'imagen_curso' => NULL,
                    'posx_nombre_participante' => $settings[0]->posx_nombre_participante,
                    'posy_nombre_participante' => $settings[0]->posy_nombre_participante,
                    'posx_nombre_curso' => $settings[0]->posx_nombre_curso,
                    'posy_nombre_curso' => $settings[0]->posy_nombre_curso,
                    'posx_qr' => $settings[0]->posx_qr,
                    'posy_qr' => $settings[0]->posy_qr,
                    'posx_tipo_participacion' => $settings[0]->posx_tipo_participacion,
                    'posy_tipo_participacion' => $settings[0]->posy_tipo_participacion,
                    'posx_bloque_texto' => $settings[0]->posx_bloque_texto,
                    'posy_bloque_texto' => $settings[0]->posy_bloque_texto,
                    'tamano_titulo' => $settings[0]->tamano_participante,
                    'tamano_subtitulo' => $settings[0]->tamano_curso,
                    'tamano_texto' => $settings[0]->tamano_texto,
                ],
                ['id_course_moodle' => $id_course_moodle]
            );
            if ($response) {
                $this->output->set_content_type('application/json')->set_output(json_encode(
                    [
                        'exito' => 'Configuración registrado correctamente, SUBA LA IMAGEN DEL CERTIFICADO CORRESPONDIENTE EN LA CONFIGURACIÓN DEL CURSO PARA ESTE TIPO DE CERTIFICADO',
                    ]
                ));
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(
                    [
                        'error' => 'Error al guardar la configuración'
                    ]
                ));
            }
        }
    }
}
