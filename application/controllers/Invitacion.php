<?php defined('BASEPATH') or exit('No direct script access allowed');

class Invitacion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invitacion_model');
    }

    public function index($id = null)
    {
        // echo '<pre>';
        // var_dump(apache_response_headers());
        // return var_dump(getallheaders()['User-Agent']);
        $grupos = $this->invitacion_model->listar_grupos_whatsapp(['id_categoria' => $id])->result();
        if (strpos(mb_convert_case(getallheaders()['User-Agent'], MB_CASE_LOWER), "whatsapp") === false) {
            $total_grupos = count($grupos);
            $cn = 1;
            foreach ($grupos as $value) {
                if ($value->suscritos < 256) {
                    $suscritos = ++$value->suscritos;
                    $this->invitacion_model->actualizar_suscritos($value->id_grupo_whatsapp, $suscritos);
                    header('Location: ' . $value->url_invitacion);
                    break;
                } elseif ($total_grupos == $cn && $value->suscritos > 200) {
                    $this->enviar_correo($id);
                    if ($value->suscritos == 256) {
                        echo "TODOS LOS GRUPOS ESTÁN LLENOS POR FAVOR INTENTE MÁS TARDE";
                    }
                }
                $cn++;
            }
        } else {
            foreach ($grupos as $value) {
                if ($value->suscritos < 256) {
                    header('Location: ' . $value->url_invitacion);
                    break;
                }
            }
        }
    }

    public function video_informaciones($id_video_informacion)
    {
        $video = $this->invitacion_model->video_informacion([' id_video_informacion' => $id_video_informacion]);
        if (isset($video['url_video']) && !is_null($video['url_video'])) {
            header('Location: ' . $video['url_video']);
            exit;
        } else {
            echo 'Error, no pudimos encontrar su video de informacion.';
        }
    }

    public function enviar_correo($id_categoria)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->isHTML(true);
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "psg.upea@gmail.com";
        $mail->Password = "Psg2020#";
        $mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
        $mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
        $mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
        $mail->Subject = 'ALERTA GRUPO LLENO';
        $mail->Body = "<h2>TODOS LOS GRUPOS LLENOS PERRO</h2>";
        foreach ($this->invitacion_model->listar_responsables($id_categoria)->result() as $value) {
            $mail->AltBody = 'ALERTA GRUPO LLENO: ' . $value->categoria;
            $mail->addAddress($value->correo, $value->celular);
            if (!$mail->send()) {
                echo 'Error: ' . $mail->ErrorInfo;
                break;
            }
        }
    }
}
