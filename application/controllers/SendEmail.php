<?php defined('BASEPATH') or exit('No direct script access allowed');

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
        // foreach ($estudiantes as $estudiante) {
        //     $this->data['nombre'] = utf8_decode($estudiante->nombre_completo);
        //     $this->data['email'] = $estudiante->email;
        //     $this->data['curso'] = utf8_decode($estudiante->fullname);
        //     $this->data['ap'] = $this->tipo_participacion($estudiante->tipo_participacion, $estudiante->calificacion_final);
        //     $mensaje = $this->CI->load->view('correo/email', $this->data, TRUE);
        //     $mail = new \PHPMailer\PHPMailer\PHPMailer();
        //     $mail->IsSMTP();
        //     $mail->isHTML(true);
        //     $mail->SMTPDebug = 0;
        //     $mail->SMTPAuth = true;
        //     $mail->SMTPSecure = "ssl";
        //     $mail->Host = "mail.upea.bo";
        //     $mail->Port = 465;
        //     $mail->Username = "posgrado@upea.bo";
        //     $mail->Password = "Posgrado#1";
        //     $mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
        //     $mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
        //     $mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
        //     $mail->addAddress($this->data['email'], $this->data['nombre']);
        //     $mail->Subject = 'CERTIFICADO DIGITAL DEL CURSO';
        //     $mail->Body = $mensaje;
        //     $mail->AltBody = 'CERTIFICADO DIGITAL DEL CURSO: ' . $this->data['curso'];
        //     $mail->addAttachment("assets/certificados_enviar/$estudiante->id/$estudiante->id_inscripcion_curso" . ".pdf");
        //     if (!$mail->send()) {
        //         return null;
        //         echo 'Error: ' . $mail->ErrorInfo;
        //     } else {
        //         echo 'Mensaje Enviado correctamente.';
        //         $cn++;
        //     }
        // }
        return $cn;
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

    public function enviar_correo_personal($datos)
    {
        if (count($datos) == 1) {
            $cn = 0;
            foreach ($datos as $estudiante) {
                $this->data['nombre'] = utf8_decode($estudiante->nombre_completo);
                $this->data['email'] = $estudiante->correo;
                $this->data['curso'] = utf8_decode($estudiante->fullname);
                $this->data['imagen'] = $estudiante->banner_curso;
                $mensaje = $this->CI->load->view('correo/email_informacion', $this->data, TRUE);
                // var_dump($mensaje);
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
                $mail->addAddress($estudiante->correo, utf8_decode($estudiante->nombre_completo));
                $mail->Subject = 'CERTIFICADO DIGITAL DEL CURSO';
                $mail->Body = $mensaje;
                $mail->AltBody = 'CERTIFICADO DIGITAL DEL CURSO: ' . $this->data['curso'];
                $mail->addAttachment($estudiante->url_pdf);

                if (!$mail->send()) {
                    echo 'Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Mensaje Enviado correctamente.';
                    $cn++;
                }
            }

            if ($cn == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
