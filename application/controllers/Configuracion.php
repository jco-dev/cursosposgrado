<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('America/La_Paz');

class Configuracion extends PSG_Controller
{
    public $cn = 1;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuracion_model');
        $this->cn = 1;
    }

    public function index()
    {
        $this->templater->view('cursos/configuracion', $this->data);
    }

    public function ajax_configuracion_curso()
    {
        if ($this->input->is_ajax_request()) {
            $table = "mdl_cursos_configuracion";
            $primaryKey = 'id_configuracion_curso';
            $columns = array(
                array('dt' => 0, 'db' => 'id_configuracion_curso', 'formatter' => function($id){
                    return $this->cn++;
                }),
                array('dt' => 1, 'db' => 'fullname', 'formatter' => function ($fullname) {
                    return '<small>' . $fullname . '</small>';
                }),
                array('dt' => 2, 'db' => 'imagen_curso', 'formatter' => function ($img) {
                    if ($img == "") {
                        return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
                    } else {
                        return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url("$img") . '" alt="foto curso" />';
                    }
                }),
                array('dt' => 3, 'db' => 'nota_aprobacion'),
                array('dt' => 4, 'db' => 'fecha_inicial'),
                array('dt' => 5, 'db' => 'fecha_final'),
                array('dt' => 6, 'db' => 'carga_horaria'),
                array('dt' => 7, 'db' => 'fecha_certificacion'),
                array('dt' => 8, 'db' => 'fecha_creacion'),
                array('dt' => 9, 'db' => 'posx_nombre_participante'),
                array('dt' => 10, 'db' => 'posy_nombre_participante'),
                array('dt' => 11, 'db' => 'posx_bloque_texto'),
                array('dt' => 12, 'db' => 'posy_bloque_texto'),
                array('dt' => 13, 'db' => 'posx_nombre_curso'),
                array('dt' => 14, 'db' => 'posy_nombre_curso'),
                array('dt' => 15, 'db' => 'posx_qr'),
                array('dt' => 16, 'db' => 'posy_qr'),
                array('dt' => 17, 'db' => 'posx_tipo_participacion'),
                array('dt' => 18, 'db' => 'posy_tipo_participacion'),
                array('dt' => 19, 'db' => 'fuente_pdf'),
                array('dt' => 20, 'db' => 'tamano_titulo'),
                array('dt' => 21, 'db' => 'tamano_subtitulo'),
                array('dt' => 22, 'db' => 'tamano_texto'),
                array('dt' => 23, 'db' => 'color_nombre_participante', 'formatter' => function ($color) {
                    if ($color != '') {
                        $datos = explode(", ", $color);
                        if (count($datos) == 3) {
                            return "<span style='padding: 5px; border-radius: 5px;background-color:" . $this->rgb2html($datos[0], $datos[1], $datos[2]) . ";color:" . $this->rgb2html($datos[0], $datos[1], $datos[2]) . "'>colorcolorcolor</span>";
                        } else {
                            return "<span style='padding: 5px; border-radius: 5px;background-color:" . $this->rgb2html(0, 0, 0) . ";color:" . $this->rgb2html(0, 0, 0) . "'>colorcolorcolor</span>";
                        }
                    } else {
                        return "<span style='padding: 5px; border-radius: 5px;background-color:" . $this->rgb2html(0, 0, 0) . ";color:" . $this->rgb2html(0, 0, 0) . "'>colorcolorcolor</span>";
                    }
                }),
                array('dt' => 24, 'db' => 'color_subtitulo', 'formatter' => function ($color) {
                    if ($color != '') {
                        $datos = explode(", ", $color);
                        if (count($datos) == 3) {
                            return "<span style='padding: 5px; border-radius: 5px;background-color:" . $this->rgb2html($datos[0], $datos[1], $datos[2]) . ";color:" . $this->rgb2html($datos[0], $datos[1], $datos[2]) . "'>colorcolorcolor</span>";
                        } else {
                            return "<span style='padding: 5px; border-radius: 5px;background-color:" . $this->rgb2html(0, 0, 0) . ";color:" . $this->rgb2html(0, 0, 0) . "'>colorcolorcolor</span>";
                        }
                    } else {
                        return "<span style='padding: 5px; border-radius: 5px;background-color:" . $this->rgb2html(0, 0, 0) . ";color:" . $this->rgb2html(0, 0, 0) . "'>colorcolorcolor</span>";
                    }
                }),
                array('dt' => 25, 'db' => 'detalle_curso'),
                array('dt' => 26, 'db' => 'horario'),
                array('dt' => 27, 'db' => 'url_pdf'),
                array('dt' => 28, 'db' => 'banner_curso', 'formatter' => function ($banner) {
                    if ($banner == "") {
                        return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
                    } else {
                        return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url("$banner") . '" alt="foto curso" />';
                    }
                }),
                array('dt' => 29, 'db' => 'celular_referencia', 'formatter' => function ($celular) {
                    return '<span class="label label-light-success label-inline font-weight-bolder mr-2">' . $celular . '</span>';
                }),
                array('dt' => 30, 'db' => 'inversion', 'formatter' => function ($inversion) {
                    return '<span class="label label-primary label-inline font-weight-bolder mr-2">Bs. ' . $inversion . '</span>';
                }),
                array('dt' => 31, 'db' => 'descuento', 'formatter' => function ($des) {
                    if ($des == "") {
                        $des = 0;
                    }
                    return '<span class="label label-warning label-inline font-weight-bolder mr-2">' . $des . ' %</span>';
                }),
                array('dt' => 32, 'db' => 'fecha_inicio_descuento'),
                array('dt' => 33, 'db' => 'fecha_fin_descuento'),
                // array('dt' => 34, 'db' => 'imagen_personalizado', 'formatter' => function ($img) {
                //     if ($img == "") {
                //         return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url('assets/img/default.jpg') . '" alt="foto curso" />';
                //     } else {
                //         return '<img class="img-thumbnail" width="120" heigth="120" src="' . base_url("$img") . '" alt="foto curso" />';
                //     }
                // }),
                // array('dt' => 35, 'db' => 'posx_imagen_personalizado'),
                // array('dt' => 36, 'db' => 'posy_imagen_personalizado'),
                // array('dt' => 37, 'db' => 'imprimir_subtitulo'),
                array('dt' => 34, 'db' => 'subtitulo'),
                array('dt' => 35, 'db' => 'estado_curso', 'formatter' => function ($estado) {
                    return '<span class="label label-primary label-inline font-weight-bolder mr-2">' . $estado . '</span>';
                }),
                array('dt' => 36, 'db' => 'id_configuracion_curso', 'formatter' => function ($id, $row) {
                    return "
                        <a id='btn_agregar_img_sub' titulo='" . $row['fullname'] . "' data-id=" . $id . " href='javascript:;' class='btn btn-light-primary btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Agregar imagen personalizado del curso'>
                        <i class='nav-icon la la-plus'></i>
                        </a>

                        <a id='btn_editar_conf' titulo='" . $row['fullname'] . "' data-id=" . $id . " href='javascript:;' class='btn btn-light-warning btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Editar la configuracion del curso'>
                        <i class='nav-icon la la-edit'></i>
                        </a>
                        <a id='btn_eliminar_conf' data-id=" . $id . " href='javascript:;' class='btn btn-light-danger btn-sm font-weight-bold mr-2 btn-clean btn-icon' title='Eliminar el curso de la configuracion'>
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
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, NULL)
            ));
            return;
        }
    }

    public function rgb2html($r, $g = -1, $b = -1)
    {
        if (is_array($r) && sizeof($r) == 3)
            list($r, $g, $b) = $r;

        $r = intval($r);
        $g = intval($g);
        $b = intval($b);

        $r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));
        $g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));
        $b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));

        $color = (strlen($r) < 2 ? '0' : '') . $r;
        $color .= (strlen($g) < 2 ? '0' : '') . $g;
        $color .= (strlen($b) < 2 ? '0' : '') . $b;
        return '#' . $color;
    }

    public function editar_configuracion()
    {
        $id = $this->input->post('id');
        $respuesta = $this->sql_ssl->listar_tabla(
            'mdl_cursos_configuracion',
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

    public function actualizar_configuracion_curso()
    {
        if ($this->input->is_ajax_request()) {
            $id_configuracion_curso = $this->input->post('id_configuracion_curso');
            $nota_aprobacion = $this->input->post('nota_aprobacion');
            $fecha_inicial = $this->input->post('fecha_inicial');
            $fecha_final = $this->input->post('fecha_final');
            $carga_horaria = $this->input->post('carga_horaria');
            $fecha_certificacion = $this->input->post('fecha_certificacion');
            $fecha_creacion = $this->input->post('fecha_creacion');
            $posx_nombre_participante = $this->input->post('posx_nombre_participante');
            $posy_nombre_participante = $this->input->post('posy_nombre_participante');
            $posx_bloque_texto = $this->input->post('posx_bloque_texto');
            $posy_bloque_texto = $this->input->post('posy_bloque_texto');
            $posx_nombre_curso = $this->input->post('posx_nombre_curso');
            $posy_nombre_curso = $this->input->post('posy_nombre_curso');
            $posx_qr = $this->input->post('posx_qr');
            $posy_qr = $this->input->post('posy_qr');
            $posx_tipo_participacion = $this->input->post('posx_tipo_participacion');
            $posy_tipo_participacion = $this->input->post('posy_tipo_participacion');
            $fuente_pdf = $this->input->post('fuente_pdf');
            $tamano_titulo = $this->input->post('tamano_titulo');
            $tamano_subtitulo = $this->input->post('tamano_subtitulo');
            $tamano_texto = $this->input->post('tamano_texto');
            $detalle_curso = $this->input->post('detalle_curso');
            $horario = mb_convert_case(preg_replace('/\s+/', ' ', trim($this->input->post('horario'))), MB_CASE_UPPER);
            $celular_referencia = $this->input->post('celular_referencia');
            $inversion = $this->input->post('inversion');
            $descuento = $this->input->post('descuento');
            $fecha_inicio_descuento = $this->input->post('fecha_inicio_descuento');
            $fecha_fin_descuento = $this->input->post('fecha_fin_descuento');
            $proximo_curso = $this->input->post('proximo_curso');
            // subida del archivo pdf del curso
            if (isset($_FILES['url_pdf']) && $_FILES['url_pdf']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['url_pdf']['tmp_name'];
                $fileName = $_FILES['url_pdf']['name'];
                $fileSize = $_FILES['url_pdf']['size'];
                $fileType = $_FILES['url_pdf']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $allowedfileExtensions = array('pdf', 'docx', 'doc');
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = 'assets/pdf_descripcion_curso/';
                    $dest_path = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $this->sql_ssl->modificar_tabla(
                            'mdl_configuracion_curso',
                            ['url_pdf' => $dest_path],
                            ['id_configuracion_curso' => $id_configuracion_curso]
                        );
                    }
                }
            }
            // fin subida del archivo pdf del curso

            list($r, $g, $b) = sscanf($this->input->post('color_nombre_participante'), "#%02x%02x%02x");
            $color_nombre_participante = "$r, $g, $b";
            list($r1, $g1, $b1) = sscanf($this->input->post('color_subtitulo'), "#%02x%02x%02x");
            $color_subtitulo = "$r1, $g1, $b1";

            // subida de las imagenes del curso y banner del curso
            $ruta = '';
            if ($this->input->post('imagen_curso')) {
                if (preg_match('/^data:image\/(\w+);base64,/', $this->input->post('imagen_curso'), $formato)) {
                    $imagen = substr($this->input->post('imagen_curso'), strpos($this->input->post('imagen_curso'), ',') + 1);
                    $nombre = date('Y_m_d_H_i_s') . '.' . strtolower($formato[1]);
                    $ruta = 'assets/img/imagen_cursos/' . $nombre;
                    file_put_contents(FCPATH . 'assets/img/imagen_cursos/' . $nombre, base64_decode($imagen));
                }
            }

            $ruta1 = '';
            if ($this->input->post('banner_curso')) {
                if (preg_match('/^data:image\/(\w+);base64,/', $this->input->post('banner_curso'), $formato)) {
                    $imagen = substr($this->input->post('banner_curso'), strpos($this->input->post('banner_curso'), ',') + 1);
                    $nombre = date('Y_m_d_H_i_s') . '.' . strtolower($formato[1]);
                    $ruta1 = 'assets/img/banner_cursos/' . $nombre;
                    file_put_contents(FCPATH . 'assets/img/banner_cursos/' . $nombre, base64_decode($imagen));
                }
            }
            // fin subida de imagenes del curso y banner del curso

            if ($ruta == '' && $ruta1 == '') {
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'configuracion_curso',
                    [
                        'nota_aprobacion' => $nota_aprobacion,
                        'fecha_inicial' => $fecha_inicial,
                        'fecha_final' => $fecha_final,
                        'carga_horaria' => $carga_horaria,
                        'fecha_certificacion' => $fecha_certificacion,
                        'fecha_creacion' => $fecha_creacion,
                        'posx_nombre_participante' => $posx_nombre_participante,
                        'posy_nombre_participante' => $posy_nombre_participante,
                        'posx_bloque_texto' => $posx_bloque_texto,
                        'posy_bloque_texto' => $posy_bloque_texto,
                        'posx_nombre_curso' =>  $posx_nombre_curso,
                        'posy_nombre_curso' =>   $posy_nombre_curso,
                        'posx_qr' =>   $posx_qr,
                        'posy_qr' =>   $posy_qr,
                        'posx_tipo_participacion' => $posx_tipo_participacion,
                        'posy_tipo_participacion' => $posy_tipo_participacion,
                        'fuente_pdf' => $fuente_pdf,
                        'tamano_titulo' => $tamano_titulo,
                        'tamano_subtitulo' => $tamano_subtitulo,
                        'tamano_texto' => $tamano_texto,
                        'color_nombre_participante' => $color_nombre_participante,
                        'color_subtitulo' => $color_subtitulo,
                        'detalle_curso' => $detalle_curso,
                        'horario' => $horario,
                        'celular_referencia' => $celular_referencia,
                        'inversion' => $inversion,
                        'descuento' => $descuento,
                        'fecha_inicio_descuento' => $fecha_inicio_descuento,
                        'fecha_fin_descuento' => $fecha_fin_descuento,
                        'proximo_curso' => $proximo_curso

                    ],
                    ['id_configuracion_curso' => $id_configuracion_curso]

                );

                if ($respuesta) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'exito' => 'Configuracion del curso actualizado correctamente'
                        ]
                    ));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'error' => 'Error al actualizar la configuracion del curso'
                        ]
                    ));
                }
            } elseif ($ruta != '' && $ruta1 != '') {
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'configuracion_curso',
                    [
                        'imagen_curso' => $ruta,
                        'nota_aprobacion' => $nota_aprobacion,
                        'fecha_inicial' => $fecha_inicial,
                        'fecha_final' => $fecha_final,
                        'carga_horaria' => $carga_horaria,
                        'fecha_certificacion' => $fecha_certificacion,
                        'fecha_creacion' => $fecha_creacion,
                        'posx_nombre_participante' => $posx_nombre_participante,
                        'posy_nombre_participante' => $posy_nombre_participante,
                        'posx_bloque_texto' => $posx_bloque_texto,
                        'posy_bloque_texto' => $posy_bloque_texto,
                        'posx_nombre_curso' =>  $posx_nombre_curso,
                        'posy_nombre_curso' =>   $posy_nombre_curso,
                        'posx_qr' =>   $posx_qr,
                        'posy_qr' =>   $posy_qr,
                        'posx_tipo_participacion' => $posx_tipo_participacion,
                        'posy_tipo_participacion' => $posy_tipo_participacion,
                        'fuente_pdf' => $fuente_pdf,
                        'tamano_titulo' => $tamano_titulo,
                        'tamano_subtitulo' => $tamano_subtitulo,
                        'tamano_texto' => $tamano_texto,
                        'color_nombre_participante' => $color_nombre_participante,
                        'color_subtitulo' => $color_subtitulo,
                        'color_subtitulo' => $color_subtitulo,
                        'detalle_curso' => $detalle_curso,
                        'horario' => $horario,
                        'banner_curso' => $ruta1,
                        'celular_referencia' => $celular_referencia,
                        'inversion' => $inversion,
                        'descuento' => $descuento,
                        'fecha_inicio_descuento' => $fecha_inicio_descuento,
                        'fecha_fin_descuento' => $fecha_fin_descuento,
                        'proximo_curso' => $proximo_curso

                    ],
                    ['id_configuracion_curso' => $id_configuracion_curso]

                );

                if ($respuesta) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'exito' => 'Configuracion del curso actualizado correctamente'
                        ]
                    ));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'error' => 'Error al actualizar la configuracion del curso'
                        ]
                    ));
                }
            } elseif ($ruta == '' && $ruta1 != '') {
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'configuracion_curso',
                    [
                        'nota_aprobacion' => $nota_aprobacion,
                        'fecha_inicial' => $fecha_inicial,
                        'fecha_final' => $fecha_final,
                        'carga_horaria' => $carga_horaria,
                        'fecha_certificacion' => $fecha_certificacion,
                        'fecha_creacion' => $fecha_creacion,
                        'posx_nombre_participante' => $posx_nombre_participante,
                        'posy_nombre_participante' => $posy_nombre_participante,
                        'posx_bloque_texto' => $posx_bloque_texto,
                        'posy_bloque_texto' => $posy_bloque_texto,
                        'posx_nombre_curso' =>  $posx_nombre_curso,
                        'posy_nombre_curso' =>   $posy_nombre_curso,
                        'posx_qr' =>   $posx_qr,
                        'posy_qr' =>   $posy_qr,
                        'posx_tipo_participacion' => $posx_tipo_participacion,
                        'posy_tipo_participacion' => $posy_tipo_participacion,
                        'fuente_pdf' => $fuente_pdf,
                        'tamano_titulo' => $tamano_titulo,
                        'tamano_subtitulo' => $tamano_subtitulo,
                        'tamano_texto' => $tamano_texto,
                        'color_nombre_participante' => $color_nombre_participante,
                        'color_subtitulo' => $color_subtitulo,
                        'detalle_curso' => $detalle_curso,
                        'horario' => $horario,
                        'banner_curso' => $ruta1,
                        'celular_referencia' => $celular_referencia,
                        'inversion' => $inversion,
                        'descuento' => $descuento,
                        'fecha_inicio_descuento' => $fecha_inicio_descuento,
                        'fecha_fin_descuento' => $fecha_fin_descuento,
                        'proximo_curso' => $proximo_curso

                    ],
                    ['id_configuracion_curso' => $id_configuracion_curso]

                );

                if ($respuesta) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'exito' => 'Configuracion del curso actualizado correctamente'
                        ]
                    ));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'error' => 'Error al actualizar la configuracion del curso'
                        ]
                    ));
                }
            } elseif ($ruta != '' && $ruta1 == '') {
                $respuesta = $this->sql_ssl->modificar_tabla(
                    'configuracion_curso',
                    [
                        'imagen_curso' => $ruta,
                        'nota_aprobacion' => $nota_aprobacion,
                        'fecha_inicial' => $fecha_inicial,
                        'fecha_final' => $fecha_final,
                        'carga_horaria' => $carga_horaria,
                        'fecha_certificacion' => $fecha_certificacion,
                        'fecha_creacion' => $fecha_creacion,
                        'posx_nombre_participante' => $posx_nombre_participante,
                        'posy_nombre_participante' => $posy_nombre_participante,
                        'posx_bloque_texto' => $posx_bloque_texto,
                        'posy_bloque_texto' => $posy_bloque_texto,
                        'posx_nombre_curso' =>  $posx_nombre_curso,
                        'posy_nombre_curso' =>   $posy_nombre_curso,
                        'posx_qr' =>   $posx_qr,
                        'posy_qr' =>   $posy_qr,
                        'posx_tipo_participacion' => $posx_tipo_participacion,
                        'posy_tipo_participacion' => $posy_tipo_participacion,
                        'fuente_pdf' => $fuente_pdf,
                        'tamano_titulo' => $tamano_titulo,
                        'tamano_subtitulo' => $tamano_subtitulo,
                        'tamano_texto' => $tamano_texto,
                        'color_nombre_participante' => $color_nombre_participante,
                        'color_subtitulo' => $color_subtitulo,
                        'detalle_curso' => $detalle_curso,
                        'horario' => $horario,
                        'celular_referencia' => $celular_referencia,
                        'inversion' => $inversion,
                        'descuento' => $descuento,
                        'fecha_inicio_descuento' => $fecha_inicio_descuento,
                        'fecha_fin_descuento' => $fecha_fin_descuento,
                        'proximo_curso' => $proximo_curso
                    ],
                    ['id_configuracion_curso' => $id_configuracion_curso]

                );

                if ($respuesta) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'exito' => 'Configuracion del curso actualizado correctamente'
                        ]
                    ));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(
                        [
                            'error' => 'Error al actualizar la configuracion del curso'
                        ]
                    ));
                }
            }
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
