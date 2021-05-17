<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');
require_once APPPATH . '/controllers/Reportes/ImprimirCertificado.php';
require_once APPPATH . '/controllers/SendEmail.php';

class Inscripcion extends CI_Controller
{
    protected $id = null;
    // protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inscripcion_model');
    }

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
        $this->load->library('form_validation');
        $this->load->helper('email');

        $this->form_validation->set_rules('ci', 'carnet de identidad', 'required');
        $this->form_validation->set_rules('expedido', 'expedido', 'required');
        $this->form_validation->set_rules('correo', 'correo', 'required|valid_email');
        $this->form_validation->set_rules('nombre', 'nombre', 'required');
        $this->form_validation->set_rules('paterno', 'paterno', 'required');
        $this->form_validation->set_rules('fecha_nacimiento', 'fecha nacimiento', 'callback_date_valid|callback_fecha_vacio');
        $this->form_validation->set_rules('celular', 'celular', 'callback_validar_celular');
        $this->form_validation->set_rules('fecha_pago', 'fecha pago', 'required|callback_date_valid|callback_fecha_vacio');
        $this->form_validation->set_rules('monto_pago', 'monto pago', 'required|callback_monto_valid');

        if ($this->form_validation->run() == false) {
            // if(false){
            $this->output->set_content_type('application/json')->set_output(json_encode(array('warning' => validation_errors())));
        } else {

            $res = (array) $this->getRecaptcha($this->input->post('g-recaptcha-response'));

            if (isset($res['success']) && $res['success'] == true && isset($res['score']) && $res['score'] > 0.5) {
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
                $estado = "PREINSCRITO";

                // verificar la inscripcion del curso con ci
                $respuesta = $this->sql_ssl->listar_tabla(
                    'mdl_participante_preinscripcion_curso',
                    ['ci' => $ci, 'id_course_moodle' => $id_curso, 'estado' => "PREINSCRITO"]
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
                                'nombre' => ucwords(strtolower(trim($nombre))),
                                'paterno' => ucwords(strtolower(trim($paterno))),
                                'materno' => ucwords(strtolower(trim($materno))),
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
                                    'respaldo_pago' => $ruta,
                                    'estado' => $estado
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
                                'nombre' => ucwords(strtolower(trim($nombre))),
                                'paterno' => ucwords(strtolower(trim($paterno))),
                                'materno' => ucwords(strtolower(trim($materno))),
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
                                    'respaldo_pago' => $ruta,
                                    'estado' => $estado
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
            } else {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(['warning' => "No puede enviar muchas veces el formulario.!!!"])
                );
            }
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

    public function getRecaptcha($secret_key)
    {
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeBuM4aAAAAAGPHI5DQT6oIZWjHozRoSojbWxlL&response={$secret_key}");
        $retorno = json_decode($respuesta);
        return $retorno;
    }

    public function date_valid($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if ($d && $d->format('Y-m-d') == $date) {
            return true;
        } else {
            $this->form_validation->set_message('fecha', 'El campo {field} no es una fecha válida');
            return false;
        }
    }

    public function fecha_vacio($date)
    {
        if ($date != '') {
            return true;
        } else {
            $this->form_validation->set_message('fecha', 'El campo {field} es requerido');
            return false;
        }
    }

    public function validar_celular($numero_celular)
    {
        if (strlen($numero_celular) == 8) {
            return true;
        } else {
            $this->form_validation->set_message('celular', 'El campo {field} debe tener 8 dígitos');
            return false;
        }
    }

    public function monto_valid($monto)
    {
        if (intval($monto) >= 100 && intval($monto) <= 1000) {
            return true;
        } else {
            $this->form_validation->set_message('monto pago', 'El campo {field} debe estar entre 100 y 1000');
            return false;
        }
    }

    public function datos_estudiante_curso()
    {
        $id_preinscripcion = $this->input->post("id");
        $respuesta = $this->inscripcion_model->datos_estudiante_curso($id_preinscripcion);
        $this->output->set_content_type('application/json')->set_output(
            json_encode(['exito' => $respuesta])
        );
    }

    public function enviar_correo_personal()
    {
        $id = $this->input->post('id');

        $respuesta1 = $this->inscripcion_model->get_data_informacion($id);

        $send = new SendEmail();
        $res = $send->enviar_correo_personal($respuesta1);
        if ($res) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['exito' => "Correo enviado correctamente"])
            );
        } else {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(['error' => "Error al enviar el correo"])
            );
        }
    }
}
