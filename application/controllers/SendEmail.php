<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/Templater.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class SendEmail extends PSG_Controller
{
    protected $data;
    public function __construct()
    {
        $this->CI = &get_instance();
    }
    public function enviar_correos($estudiantes)
    {
        $cn = 0;
        $correo = '';
        foreach ($estudiantes as $estudiante) {
            $this->data['nombre'] = utf8_decode($estudiante->nombre_completo);
            $this->data['email'] = $estudiante->email;
            $this->data['curso'] = utf8_decode($estudiante->fullname);
            $this->data['ap'] = $this->tipo_participacion($estudiante->tipo_participacion, $estudiante->calificacion_final);
            $mensaje = $this->CI->load->view('correo/email', $this->data, TRUE);
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP();
            $mail->isHTML(true);
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = "mail.upea.bo";
            $mail->Port = 465;
            $mail->Username = "posgrado@upea.bo";
            $mail->Password = "Posgrado#1";
            $mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
            $mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
            $mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
            $mail->addAddress('juanzapanacondori@gmail.com', "juan carlos condori");
            $mail->Subject = 'CERTIFICADO DIGITAL DEL CURSO';
            $mail->Body = $mensaje;
            $mail->AltBody = 'CERTIFICADO DIGITAL DEL CURSO: ' . $this->data['curso'];
            $mail->addAttachment("assets/certificados_enviar/$estudiante->id/$estudiante->id_inscripcion_curso" . ".pdf");
            if (!$mail->send()) {
                echo 'Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Mensaje Enviado correctamente.';
            }
            $cn++;
            if ($cn == 1) {
                break;
            }
        }
    }

    public function tipo_participacion($tipo, $calificacion)
    {
        $ap = "PARTICIPADO";
        if ($tipo == "PARTICIPANTE") {
            $ap = $this->verificar_aprobacion(60, $calificacion);
        } elseif ($tipo == "EXPOSITOR") {
            $ap = "EXPUESTO";
        } elseif ($tipo == "ORGANIZADOR") {
            $ap = "ORGANIZADOR";
        } else {
            $ap = "PARTICIPADO";
        }
        return $ap;
    }

    public function verificar_aprobacion($nota_aprobacion = 60, $nota_final)
    {
        if (intval($nota_final) >= intval($nota_aprobacion)) {
            return "APROBADO";
        } else {
            return "PARTICIPADO";
        }
    }
}
