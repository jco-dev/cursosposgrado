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

	public function send_certificates($estudiantes, $course_data)
	{
		// return var_dump($estudiantes[0]->certificacion_unica);
		$envied = 0;
		$not_envied = 0;
		$cn = 0;
		// banner curso
		if (isset($course_data[0]->banner_curso)) {
			$this->data['banner_curso'] = $course_data[0]->banner_curso;
		} else {
			$this->data['banner_curso'] = NULL;
		}
		foreach ($estudiantes as $estudiante) {
			$this->data['nombre'] = utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->nombre_completo)), MB_CASE_UPPER));
			$this->data['email'] = $estudiante->email;
			// $this->data['email'] = "condorizapanajuancarlos@gmail.com";
			if ($this->data['email'] != "" && $this->data['email'] != NULL) {
				$this->data['curso'] = utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->fullname)), MB_CASE_UPPER));
				$this->data['ap'] = $this->tipo_participacion($estudiante->tipo_participacion, $estudiante->calificacion_final);
				$message = $this->CI->load->view('correo/send_certificate', $this->data, TRUE);
				$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->IsSMTP();
				$mail->isHTML(true);
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = true;
				// $mail->SMTPSecure = "tls";
				$mail->SMTPSecure = "ssl";
				// $mail->Host = "smtp.mailtrap.io";
				$mail->Host = "smtp.gmail.com";
				// $mail->Port = 2525;
				$mail->Port = 465;
				// $mail->Username = "c177e9965bd0d9";
				$mail->Username = "psg.upea@gmail.com";
				// $mail->Password = "76499092bb5e36";
				$mail->Password = "Psg2020#";
				$mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
				$mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
				$mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
				$mail->addAddress($this->data['email'], $this->data['nombre']);
				$mail->Subject = 'CERTIFICADO DIGITAL DEL CURSO';
				$mail->Body = $message;
				$mail->AltBody = 'CERTIFICADO DIGITAL DEL CURSO: ' . $this->data['curso'];

				//verfificamos certificacion solicitado por curso, modulos o ambos
				$photo = false;
				$mail->addAttachment("/assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . ".pdf", "certificado.pdf");
				if (file_exists("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . ".pdf")) {
					$mail->addAttachment("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . ".pdf", 'certificado.pdf');
					$photo = true;
				}
				if (file_exists("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . "_1.pdf")) {
					$mail->addAttachment("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . "_1.pdf", 'certificado_1.pdf');
					$photo = true;
				}

				if (file_exists("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . "_2.pdf")) {
					$mail->addAttachment("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . "_2.pdf", 'certificado_2.pdf');
					$photo = true;
				}

				if (file_exists("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . "_3.pdf")) {
					$mail->addAttachment("assets/certificados/certificados_{$estudiante->id}/$estudiante->id_inscripcion_curso" . "_3.pdf", 'certificado_3.pdf');
					$photo = true;
				}

				if ($photo) {
					if ($mail->send()) {
						// echo 'Error: ' . $mail->ErrorInfo;
						$envied++;
						$cn++;
					} else {
						$not_envied++;
					}
				}
			}
		}

		$data[0] = $envied;
		$data[1] = $not_envied;

		return $data;
	}

	public function tipo_participacion($tipo, $calificacion)
	{
		$ap = "PARTICIPADO";
		if ($tipo == "PARTICIPANTE") {
			$ap = $this->verificar_aprobacion(65, $calificacion);
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

	// Enviar la información del curso
	public function enviar_correo_personal($datos)
	{
		// return var_dump($datos);
		if (count($datos) == 1) {
			$cn = 0;
			foreach ($datos as $estudiante) {
				$this->data['nombre'] = utf8_decode($estudiante->nombre_completo);
				$this->data['email'] = $estudiante->correo;
				$this->data['curso'] = utf8_decode($estudiante->fullname);
				$this->data['imagen'] = $estudiante->banner_curso;
				$mensaje = $this->CI->load->view('correo/email_informacion1', $this->data, TRUE);
				// var_dump($mensaje);
				$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->IsSMTP();
				$mail->isHTML(true);
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = true;
				// $mail->SMTPSecure = "tls";
				$mail->SMTPSecure = "ssl";
				// $mail->Host = "smtp.mailtrap.io";
				$mail->Host = "smtp.gmail.com";
				// $mail->Port = 2525;
				$mail->Port = 465;
				// $mail->Username = "c177e9965bd0d9";
				$mail->Username = "psg.upea@gmail.com";
				// $mail->Password = "76499092bb5e36";
				$mail->Password = "Psg2020#";
				$mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
				$mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
				$mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
				$mail->addAddress($estudiante->correo, utf8_decode($estudiante->nombre_completo));
				$mail->Subject = utf8_decode('INFORMACIÓN DEL CURSO');
				$mail->Body = $mensaje;
				$mail->AltBody = utf8_decode('INFORMACIÓN DEL CURSO: ' . $this->data['curso']);
				$mail->addAttachment($estudiante->url_pdf);

				if (!$mail->send()) {
					// echo 'Error: ' . $mail->ErrorInfo;
					$cn = 0;
				} else {
					$cn++;
					// echo 'Mensaje Enviado correctamente.';

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

	public function send_email_course($data_course = null, $data_contacts = null)
	{
		$cn = 0;
		$nc = 0;
		$no_email = 0;
		foreach ($data_contacts as $contact) {
			if ($contact->email == "" || $contact->email == NULL) {
				$no_email++;
			} else {
				$this->data['nombre'] = utf8_decode($contact->nombre . " " . $contact->paterno . " " . $contact->materno);
				$this->data['email'] = $contact->email;
				$this->data['curso'] = utf8_decode($data_course[0]->nombre_curso);
				//$mensaje = $this->CI->load->view('correo/email', $this->data, TRUE);
				$mensaje = "Eso es una prueba de correo: " . $this->data['curso'];
				$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->IsSMTP();
				$mail->isHTML(true);
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "tls";
				// $mail->SMTPSecure = "ssl";
				$mail->Host = "smtp.mailtrap.io";
				// $mail->Host = "mail.upea.bo";
				$mail->Port = 25;
				// $mail->Port = 465;
				$mail->Username = "c177e9965bd0d9";
				// $mail->Username = "posgrado@upea.bo";
				$mail->Password = "76499092bb5e36";
				// $mail->Password = "Posgrado#1";
				$mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
				$mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
				$mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
				$mail->addAddress($this->data['email'], $this->data['nombre']);
				$mail->Subject = 'CERTIFICADO DIGITAL DEL CURSO';
				$mail->Body = $mensaje;
				$mail->AltBody = 'CERTIFICADO DIGITAL DEL CURSO: ' . $this->data['curso'];
				//mail->addAttachment("assets/certificados_enviar/$estudiante->id/$estudiante->id_inscripcion_curso" . ".pdf");
				if (!$mail->send()) {
					$nc = 0;
				} else {
					$cn++;
				}
			}
		}
		$data[0] = $cn;
		$data[1] = $nc;
		$data[2] = $no_email;
		return $data;
	}
}
