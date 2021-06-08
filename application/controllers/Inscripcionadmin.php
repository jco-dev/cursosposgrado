<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');
require_once APPPATH . '/controllers/Reportes/ImprimirCertificado.php';
require_once APPPATH . 'controllers/Reportes/Reporte_estudiantes_excel.php';

class Inscripcionadmin extends PSG_Controller
{
    protected $id = null;
    // protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inscripcion_model');
    }

    public function index()
    {
        $this->data['municipios'] = $this->inscripcion_model->listar_municipios();
        $this->data['cursos'] = $this->inscripcion_model->listar_cursos();
        $this->templater->view('inscripcion/index', $this->data);
    }

    public function ver_inscritos()
    {

        $this->data['cursos'] = $this->inscripcion_model->listar_cursos();
        $this->templater->view('inscripcion/ver_inscritos', $this->data);
    }

    // public function imprimir_recibo()
    // {
    //     $datos = array(
    //         'titulo' => "CURSO PLATAFORMA MOODLE",
    //         'fecha' => date('d-m-Y'),
    //         'numero' => '002',
    //         'importe' => '100 Bs.',
    //         'descripcion' => "PAGO DEL CURSO DE PLATAFORMAS DE MOODLE",
    //         'recibido_por' => "ING WALTER PACO SILES",
    //         'entregado_a' => "LIC TANTOS",
    //         'a_favor_de' => "JUAN CARLOS CONDORI"
    //     );

    //     $rep = new ImprimirCertificado();
    //     $rep->imprimir_recibo($datos);
    // }

    public function curso($id)
    {
        $id_curso = $this->encryption->decrypt(base64_decode($id));
        $this->data['data'] = $this->inscripcion_model->data_curso($id_curso);
        $this->data['municipios'] = $this->inscripcion_model->listar_municipios();
        $this->data['curso'] = $id;
        if (isset($this->data['data'])) {
            $this->load->view("inscripcion/curso", $this->data);
        } else {
            $this->data['data'] = null;
            $this->load->view("inscripcion/curso", $this->data);
        }
    }

    public function guardar_preinscripcion()
    {
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
        $modalidad_inscripcion = $this->input->post('modalidad_inscripcion');
        $id_transaccion = $this->input->post('id_transaccion');
        $fecha_pago = $this->input->post('fecha_pago');
        $monto_pago = $this->input->post('monto_pago');
        $tipo_certificado_solicitado = $this->input->post('tipo_certificado_solicitado');

        // verificar la inscripcion del curso con ci
        $respuesta = $this->sql_ssl->listar_tabla(
            'mdl_participante_preinscripcion_curso',
            ['ci' => $ci, 'id_course_moodle' => $id_curso]
        );

        if (count($respuesta) == 0) {
            //inscribir
            //verificamos si ya esta inscrito en participante
            $respuesta = $this->sql_ssl->listar_tabla(
                'mdl_participante',
                ['ci' => $ci]
            );
            if (count($respuesta) == 0) {
                // inscribir en participante y preinscripcion
                $resp = $this->sql_ssl->insertar_tabla(
                    'mdl_participante',
                    [
                        'ci' => $ci,
                        'expedido' => $expedido,
                        'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER),
                        'paterno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($paterno)), MB_CASE_UPPER),
                        'materno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($materno)), MB_CASE_UPPER),
                        'genero' => $genero,
                        'id_municipio' => $id_municipio,
                        'fecha_nacimiento' => $fecha_nacimiento,
                        'correo' => $correo,
                        'celular' => $celular
                    ]
                );

                if (is_numeric($resp)) {
                    //subir imagen
                    $ruta = '';
                    if (isset($_FILES['respaldo_transaccion']) && $_FILES['respaldo_transaccion']['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['respaldo_transaccion']['tmp_name'];
                        $fileName = $_FILES['respaldo_transaccion']['name'];
                        $fileSize = $_FILES['respaldo_transaccion']['size'];
                        $fileType = $_FILES['respaldo_transaccion']['type'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));

                        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                        $allowedfileExtensions = array('jpeg', 'png', 'jpg');
                        if (in_array($fileExtension, $allowedfileExtensions)) {
                            $uploadFileDir = 'assets/img/preinscripcion_respaldo/';
                            $dest_path = $uploadFileDir . $newFileName;
                            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                $ruta = $dest_path;
                            }
                        }
                    }
                    $res = $this->sql_ssl->insertar_tabla(
                        'mdl_preinscripcion_curso',
                        [
                            'id_participante' => $resp,
                            'id_course_moodle' => $id_curso,
                            'tipo_pago' => $modalidad_inscripcion,
                            'id_transaccion' => $id_transaccion,
                            'monto_pago' => $monto_pago,
                            'tipo_certificacion' => $tipo_certificado_solicitado,
                            'fecha_pago' => $fecha_pago,
                            'respaldo_pago' => $ruta
                        ]

                    );

                    if (is_numeric($res)) {
                        $this->output->set_content_type('application/json')->set_output(
                            json_encode(['exito' => "Registado al curso correctamente"])
                        );
                    } else {
                        $this->output->set_content_type('application/json')->set_output(
                            json_encode(['error' => "Error al registrarse al curso"])
                        );
                    }
                }
            } else {
                // actualizar datos en participante y insertar la preinscripcion
                $id_participante = $respuesta[0]->id_participante;
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'mdl_participante',
                    [
                        'expedido' => $expedido,
                        'nombre' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER),
                        'paterno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($paterno)), MB_CASE_UPPER),
                        'materno' =>  mb_convert_case(preg_replace('/\s+/', ' ', trim($materno)), MB_CASE_UPPER),
                        'genero' => $genero,
                        'id_municipio' => $id_municipio,
                        'fecha_nacimiento' => $fecha_nacimiento,
                        'correo' => $correo,
                        'celular' => $celular
                    ],
                    ['id_participante' => $id_participante]
                );

                if ($respuesta) {
                    //subir imagen
                    $ruta = '';
                    if (isset($_FILES['respaldo_transaccion']) && $_FILES['respaldo_transaccion']['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['respaldo_transaccion']['tmp_name'];
                        $fileName = $_FILES['respaldo_transaccion']['name'];
                        $fileSize = $_FILES['respaldo_transaccion']['size'];
                        $fileType = $_FILES['respaldo_transaccion']['type'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));

                        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                        $allowedfileExtensions = array('jpeg', 'png', 'jpg');
                        if (in_array($fileExtension, $allowedfileExtensions)) {
                            $uploadFileDir = 'assets/img/preinscripcion_respaldo/';
                            $dest_path = $uploadFileDir . $newFileName;
                            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                $ruta = $dest_path;
                            }
                        }
                    }

                    $res = $this->sql_ssl->insertar_tabla(
                        'mdl_preinscripcion_curso',
                        [
                            'id_participante' => $id_participante,
                            'id_course_moodle' => $id_curso,
                            'tipo_pago' => $modalidad_inscripcion,
                            'id_transaccion' => $id_transaccion,
                            'monto_pago' => $monto_pago,
                            'tipo_certificacion' => $tipo_certificado_solicitado,
                            'fecha_pago' => $fecha_pago,
                            'respaldo_pago' => $ruta
                        ]

                    );

                    if (is_numeric($res)) {
                        $this->output->set_content_type('application/json')->set_output(
                            json_encode(['exito' => "Registado al curso correctamente"])
                        );
                    } else {
                        $this->output->set_content_type('application/json')->set_output(
                            json_encode(['error' => "Error al registrarse al curso"])
                        );
                    }
                }
            }
        } else {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['warning' => "Ya se encuentra registrado en el curso"])
            );
        }
        // var_dump($_FILES['respaldo_transaccion']);

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

    public function ajax_ver_inscritos()
    {
        $id = $this->input->post('id');
        if ($id != "") {
            if ($this->input->is_ajax_request()) {
                $table = "mdl_ver_inscritos";
                $primaryKey = 'id_participante';
                $condicion = "id_course_moodle= $id";
                $columns = array(
                    array('dt' => 0, 'db' => 'id_participante'),
                    array('dt' => 1, 'db' => 'ci', 'formatter' => function ($ci) {
                        return '' . $ci . '';
                    }),
                    array('dt' => 2, 'db' => 'nombre_completo', 'formatter' => function ($nombre) {
                        return '' . $nombre . '';
                    }),
                    array('dt' => 3, 'db' => 'municipio_enviar'),
                    array('dt' => 4, 'db' => 'celular'),
                    array('dt' => 5, 'db' => 'curso', 'formatter' => function ($curso) {
                        return "<small>$curso</small>";
                    }),
                    array('dt' => 6, 'db' => 'fecha_inicial', 'formatter' => function ($inicio) {
                        return "<span class='label label-primary label-inline mr-2'>$inicio</span>";
                    }),
                    array('dt' => 7, 'db' => 'fecha_final', 'formatter' => function ($final) {
                        return "<span class='label label-primary label-inline mr-2'>$final</span>";
                    }),
                    array('dt' => 8, 'db' => 'fecha_preinscripcion', 'formatter' => function ($final) {
                        return "<small>$final</small>";
                    }),
                    array('dt' => 9, 'db' => 'estado', 'formatter' => function ($estado) {
                        if ($estado == "INTERESADO") {
                            return "<span class='label label-info label-inline mr-2'>INTERESADO</span>";
                        } elseif ($estado == "PREINSCRITO") {
                            return "<span class='label label-warning label-inline mr-2'>PREINSCRITO</span>";
                        } elseif ($estado == "INSCRITO") {
                            return "<span class='label label-success label-inline mr-2'>INSCRITO</span>";
                        } else {
                            return "<span class='label label-danger label-inline mr-2'>ANULADO</span>";
                        }
                    }),
                    array('dt' => 10, 'db' => 'tipo_pago'),
                    array('dt' => 11, 'db' => 'monto_pago', 'formatter' => function ($monto) {
                        return '<span class="label label-info label-inline font-weight-bolder mr-2">Bs. ' . intval($monto) . '</span>';
                    }),
                    array('dt' => 12, 'db' => 'id_transaccion'),
                    array('dt' => 13, 'db' => 'tipo_certificacion'),
                    array('dt' => 14, 'db' => 'respaldo_pago', 'formatter' => function ($img) {
                        if ($img == "") {
                            return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
                        } else {
                            return '<a class="image-popup-vertical-fit" href="' . base_url($img)  . '">
                                <img class="img img-thumbnail" src="' . base_url($img) . '" width="120" id="img-preview" height="120"> &nbsp;
                                <i class="fa fa-eye text-info"></i>
                            </a><script>$(".image-popup-vertical-fit").magnificPopup({
                                type: "image",
                                closeOnContentClick: true,
                                closeBtnInside: false,
                                fixedContentPos: true,
                                mainClass: "mfp-no-margins mfp-with-zoom", // class to remove default margin from left and right side
                                image: {
                                    verticalFit: true,
                                },
                                zoom: {
                                    enabled: true
                                },
                            });</script>';
                        }
                    }),
                    array('dt' => 15, 'db' => 'id_preinscripcion_curso', 'formatter' => function ($id, $row) {
                        $datos = '';
                        if ($row['estado'] == "PREINSCRITO") {
                            $datos .= "<option value='PREINSCRITO' selected>PREINSCRITO</option>
                            <option value='INSCRITO'>INSCRITO</option>
                            <option value='ANULADO'>ANULADO</option>";
                        } elseif ($row['estado'] == "INSCRITO") {
                            $datos .= "<option value='PREINSCRITO'>PREINSCRITO</option>
                            <option value='INSCRITO' selected>INSCRITO</option>
                            <option value='ANULADO'>ANULADO</option>";
                        } else {
                            $datos .= "<option value='PREINSCRITO'>PREINSCRITO</option>
                            <option value='INSCRITO'>INSCRITO</option>
                            <option value='ANULADO' selected>ANULADO</option>";
                        }
                        return "<select data-id='$id' class='custom-select form-control bg-secondary' id='estado_preinscrito' name='estado_preinscrito_$id'>
                            $datos
                        </select>";
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
                    mb_convert_encoding(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condicion, NULL), 'UTF-8', 'ISO-8859-2')
                ));

                return;
            }
        } else {
            if ($this->input->is_ajax_request()) {
                $table = "mdl_ver_inscritos";
                $primaryKey = 'id_participante';
                $columns = array(
                    array('dt' => 0, 'db' => 'id_participante'),
                    array('dt' => 1, 'db' => 'ci', 'formatter' => function ($ci) {
                        return '' . $ci . '';
                    }),
                    array('dt' => 2, 'db' => 'nombre_completo', 'formatter' => function ($nombre) {
                        return '' . $nombre . '';
                    }),
                    array('dt' => 3, 'db' => 'municipio_enviar'),
                    array('dt' => 4, 'db' => 'celular'),
                    array('dt' => 5, 'db' => 'curso', 'formatter' => function ($curso) {
                        return "<small>$curso</small>";
                    }),
                    array('dt' => 6, 'db' => 'fecha_inicial', 'formatter' => function ($inicio) {
                        return "<span class='label label-primary label-inline mr-2'>$inicio</span>";
                    }),
                    array('dt' => 7, 'db' => 'fecha_final', 'formatter' => function ($final) {
                        return "<span class='label label-primary label-inline mr-2'>$final</span>";
                    }),
                    array('dt' => 8, 'db' => 'fecha_preinscripcion', 'formatter' => function ($final) {
                        return "<small>$final</small>";
                    }),
                    array('dt' => 9, 'db' => 'estado', 'formatter' => function ($estado) {
                        if ($estado == "INTERESADO") {
                            return "<span class='label label-info label-inline mr-2'>INTERESADO</span>";
                        } elseif ($estado == "PREINSCRITO") {
                            return "<span class='label label-warning label-inline mr-2'>PREINSCRITO</span>";
                        } elseif ($estado == "INSCRITO") {
                            return "<span class='label label-success label-inline mr-2'>INSCRITO</span>";
                        } else {
                            return "<span class='label label-danger label-inline mr-2'>ANULADO</span>";
                        }
                    }),
                    array('dt' => 10, 'db' => 'tipo_pago'),
                    array('dt' => 11, 'db' => 'monto_pago', 'formatter' => function ($monto) {
                        return '<span class="label label-info label-inline font-weight-bolder mr-2">Bs. ' . intval($monto) . '</span>';
                    }),
                    array('dt' => 12, 'db' => 'id_transaccion'),
                    array('dt' => 13, 'db' => 'tipo_certificacion'),
                    array('dt' => 14, 'db' => 'respaldo_pago', 'formatter' => function ($img) {
                        if ($img == "") {
                            return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
                        } else {
                            return '<a class="image-popup-vertical-fit" href="' . base_url($img)  . '">
                                <img class="img img-thumbnail" src="' . base_url($img) . '" width="120" id="img-preview" height="120"> &nbsp;
                                <i class="fa fa-eye text-info"></i>
                            </a><script>$(".image-popup-vertical-fit").magnificPopup({
                                type: "image",
                                closeOnContentClick: true,
                                closeBtnInside: false,
                                fixedContentPos: true,
                                mainClass: "mfp-no-margins mfp-with-zoom", // class to remove default margin from left and right side
                                image: {
                                    verticalFit: true,
                                },
                                zoom: {
                                    enabled: true
                                },
                            });</script>';
                        }
                    }),
                    array('dt' => 15, 'db' => 'id_preinscripcion_curso', 'formatter' => function ($id, $row) {
                        $datos = '';
                        if ($row['estado'] == "PREINSCRITO") {
                            $datos .= "<option value='PREINSCRITO' selected>PREINSCRITO</option>
                            <option value='INSCRITO'>INSCRITO</option>
                            <option value='ANULADO'>ANULADO</option>";
                        } elseif ($row['estado'] == "INSCRITO") {
                            $datos .= "<option value='PREINSCRITO'>PREINSCRITO</option>
                            <option value='INSCRITO' selected>INSCRITO</option>
                            <option value='ANULADO'>ANULADO</option>";
                        } else {
                            $datos .= "<option value='PREINSCRITO'>PREINSCRITO</option>
                            <option value='INSCRITO'>INSCRITO</option>
                            <option value='ANULADO' selected>ANULADO</option>";
                        }
                        return "<select data-id='$id' class='custom-select form-control bg-secondary' id='estado_preinscrito' name='estado_preinscrito_$id'>
                            $datos
                        </select>";
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
                    mb_convert_encoding(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, NULL), 'UTF-8', 'ISO-8859-2')
                ));

                return;
            }
        }
    }

    public function confirmar_inscripcion()
    {
        $id_preinscripcion_curso = $this->input->post('id');
        $datos = (array) $this->sql_ssl->listar_tabla(
            'mdl_preinscripcion_curso',
            ['id_preinscripcion_curso' => $id_preinscripcion_curso],
            null,
            'row'
        );
        // var_dump($datos);
    }

    public function confirmar_cambio_estado()
    {
        $id_preinscripcion_curso = $this->input->post('id');
        $data = $this->input->post('data');
        $respuesta = $this->sql_ssl->modificar_tabla(
            'mdl_preinscripcion_curso',
            ['estado' => $data],
            ['id_preinscripcion_curso' => $id_preinscripcion_curso]
        );

        if ($respuesta) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['exito' => "Cambio de estado realizado correctamente"])
            );
        } else {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['error' => "Error al realizar el cambio de estado"])
            );
        }
    }

    public function confirmar_cambio_estado_contacto()
    {
        $id_preinscripcion_curso = $this->input->post('id');
        $data = $this->input->post('data');
        $respuesta = $this->sql_ssl->modificar_tabla(
            'mdl_preinscripcion_curso',
            ['estado_contacto' => $data],
            ['id_preinscripcion_curso' => $id_preinscripcion_curso]
        );

        if ($respuesta) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['exito' => "Cambio de estado realizado correctamente"])
            );
        } else {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['error' => "Error al realizar el cambio de estado"])
            );
        }
    }

    public function ver_informacion()
    {
        $this->templater->view('inscripcion/ver_informacion', $this->data);
    }

    public function ajax_ver_informacion()
    {

        if ($this->input->is_ajax_request()) {
            $table = "mdl_ver_informacion";
            $primaryKey = 'id_participante';
            $columns = array(
                array('dt' => 0, 'db' => 'id_participante'),
                array('dt' => 1, 'db' => 'ci', 'formatter' => function ($ci) {
                    return '<small>' . $ci . '</small>';
                }),
                array('dt' => 2, 'db' => 'nombre_completo', 'formatter' => function ($nombre) {
                    return '<small>' . $nombre . '</small>';
                }),
                array('dt' => 3, 'db' => 'profesion_ocupacion', 'formatter' => function ($profesion) {
                    return '<small>' . $profesion . '</small>';
                }),
                array('dt' => 4, 'db' => 'celular', 'formatter' => function ($cel) {
                    return '<span class="label label-primary label-inline">' . $cel . '</span>';
                }),
                array('dt' => 5, 'db' => 'curso', 'formatter' => function ($curso) {
                    return "<small>$curso</small>";
                }),
                array('dt' => 6, 'db' => 'fecha_inicial'),
                array('dt' => 7, 'db' => 'fecha_final'),
                array('dt' => 8, 'db' => 'fecha_preinscripcion'),
                array('dt' => 9, 'db' => 'estado_contacto', 'formatter' => function ($estado, $row) {
                    $datos = '';
                    if ($estado == "PENDIENTE" || $estado == NULL) {
                        $datos .= "<option value='PENDIENTE' selected>PENDIENTE</option>
                        <option value='CONFIRMADO'>CONFIRMADO</option>
                        <option value='DESCARTADO'>DESCARTADO</option>";
                    } elseif ($estado == "CONFIRMADO") {
                        $datos .= "<option value='PENDIENTE'>PENDIENTE</option>
                        <option value='CONFIRMADO' selected>CONFIRMADO</option>
                        <option value='DESCARTADO'>DESCARTADO</option>";
                    } else {
                        $datos .= "<option value='PENDIENTE'>PENDIENTE</option>
                        <option value='CONFIRMADO'>CONFIRMADO</option>
                        <option value='DESCARTADO' selected>DESCARTADO</option>";
                    }
                    $id = $row['id_preinscripcion_curso'];
                    return "<select data-id='" . $id . "' class='custom-select form-control bg-secondary' id='estado_contacto' name='estado_correo_" . $id . "' >
                        $datos
                    </select>";
                }),
                array('dt' => 10, 'db' => 'correo'),
                array('dt' => 11, 'db' => 'estado_correo', 'formatter' => function ($estado) {
                    if ($estado == 0) {
                        return '<span class="text-xs label label-danger label-inline">FALTA</span>';
                    } else {
                        return '<span class="text-sm-center  label label-info label-inline">ENVIADO</span>';
                    }
                }),
                array('dt' => 12, 'db' => 'id_preinscripcion_curso', 'formatter' => function ($id_preinscripcion_curso) {
                    return "<a id='btn_enviar_informacion' data-id=" . $id_preinscripcion_curso . " href='javascript:;' class='btn btn-light-success btn-sm font-weight-bold btn-clean' title='Enviar correo'>
                        <i class='nav-icon la la-send'></i>
                         Enviar
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
                mb_convert_encoding(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, NULL), 'UTF-8', 'ISO-8859-2')
            ));

            return;
        }
    }

    public function descargar_csv()
    {
        $id = $_GET['id'];
        $estado = $_GET['estado'];
        $data = $this->listar_data_estudiantes($id, $estado);

        if (count($data) != 0) {
            $curso = $this->sql_ssl->listar_tabla("mdl_course", ["id" => $data[0]->id_course_moodle]);
            if (count($curso) == 1) {
                $rep = new Reporte_estudiantes_excel();
                $rep->lista_estudiantes($data, $curso[0]->fullname);
            }
        }
    }

    public function descargar_contacto()
    {
        $id = $_GET['id'];
        $estado = $_GET['estado'];
        $data = $this->listar_data_estudiantes($id, $estado);
       
        if (count($data) != 0) {
            $curso = $this->sql_ssl->listar_tabla("mdl_course", ["id" => $data[0]->id_course_moodle]);
            if (count($curso) == 1) {
                $rep = new Reporte_estudiantes_excel();
                $rep->lista_estudiantes_contacto($data, $curso[0]->fullname);
            }
        }
    }

    public function listar_data_estudiantes($id, $estado)
    {
        $data = NULL;
        if ($estado == "PREINSCRITO") {
            $data = $this->sql_ssl->listar_tabla(
                'mdl_participante_preinscripcion_curso',
                ['estado' => "PREINSCRITO", 'id_course_moodle' => $id]
            );
        }elseif($estado == "INSCRITO"){
            $data = $this->sql_ssl->listar_tabla(
                'mdl_participante_preinscripcion_curso',
                ['estado' => "INSCRITO", 'id_course_moodle' => $id]
            );
        }else{
            $data = $this->inscripcion_model->listar_estudiantes_todos($id); 
        }
        return $data;
    }

    public function ver_estudiantes()
    {
        $idcurso = $this->input->post('id');
        $estado = $this->input->post('estado');
        $respuesta = $this->inscripcion_model->ver_estudiantes_curso($idcurso, $estado);
        if (count($respuesta) >= 1) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['data' => $respuesta[0]->total])
            );
        } else {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['data' => null])
            );
        }
    }
}
