<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "/libraries/Fpdf_psg.php";

class ImprimirCertificado extends Fpdf_psg
{
    public function __construct()
    {
        parent::__construct();
    }

    public function imprimir($datos_curso = null, $datos_estudiante = null)
    {
        // for ($i = 0; $i < 10; $i++) {
        $this->AddPage("L", "letter");
        $this->Image($datos_curso[0]->imagen_curso, 0, 0, 279.4, 215.9);

        // Nombre estudiante
        $this->SetXY($datos_curso[0]->posx_nombre_participante, $datos_curso[0]->posy_nombre_participante);
        $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
        $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
        $this->SetFont('Arial', 'B', $datos_curso[0]->tamano_titulo);
        $this->Cell(180, 18, utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($datos_estudiante[0]->usuario)), MB_CASE_UPPER)), 0, 1, 'C');

        // TIPO DE PARTICIPACION
        if ($datos_estudiante[0]->tipo_participacion == "PARTICIPANTE") {
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
            $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->AddFont('timesb', '', 'timesb.php');
            $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
            $this->Cell(190, 20, utf8_decode($this->verificar_aprobacion($datos_curso[0]->nota_aprobacion, $datos_estudiante[0]->calificacion_final)), 0, 1, '');
        } elseif ($datos_estudiante[0]->tipo_participacion == "EXPOSITOR") {
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
            $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->AddFont('timesb', '', 'timesb.php');
            $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
            $this->Cell(190, 20, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso:"), 0, 1, '');
        } elseif ($datos_estudiante[0]->tipo_participacion == "ORGANIZADOR") {
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
            $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->AddFont('timesb', '', 'timesb.php');
            $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
            $this->Cell(190, 20, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso:"), 0, 1, '');
        } else {
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
            $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->AddFont('timesb', '', 'timesb.php');
            $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
            $this->Cell(190, 20, utf8_decode("Por haber participado  del curso:"), 0, 1, '');
        }


        //qr
        // $this->Image("https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$url&.png", $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36);
        $this->Image("http://localhost/generar_qr/qr_generator.php?code=" . md5('CERTIFICADO_' . $datos_estudiante[0]->id_inscripcion_curso), $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36, "png");
        // texto de verificacion qr
        $this->SetXY(intval($datos_curso[0]->posx_qr), intval($datos_curso[0]->posy_qr) + 36);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(36, 3.5, utf8_decode("Código QR de verificación del certificado"), 0, "C");

        // Fecha de certificacion
        $fecha_certificacion = "El Alto, " . fecha_literal(explode(' ', $datos_curso[0]->fecha_certificacion)[0]);
        $this->SetXY(145, 143);
        $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
        $this->SetFont('Arial', '', $datos_curso[0]->tamano_subtitulo);
        $this->Cell(190, 20, utf8_decode($fecha_certificacion), 0, 1, '');
        // }

        echo base64_encode($this->Output('S'));
    }

    public function verificar_aprobacion($nota_aprobacion, $nota_final)
    {
        if (intval($nota_final) >= intval($nota_aprobacion)) {
            return "Por haber APROBADO SATISFACTORIAMENTE el curso: ";
        } else {
            return "Por haber PARTICIPADO del curso: ";
        }
    }

    public function imprimir_todos($datos_curso = null, $datos_estudiante = null)
    {
        // var_dump($datos_estudiante);
        $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
        $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
        $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
        foreach ($datos_estudiante as $key => $estudiante) {
            // var_dump($estudiante);
            $this->AddPage("L", "letter");
            $this->Image($datos_curso[0]->imagen_curso, 0, 0, 279.4, 215.9);

            // Nombre estudiante
            $this->SetXY($datos_curso[0]->posx_nombre_participante, $datos_curso[0]->posy_nombre_participante);
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
            $this->SetFont('Arial', 'B', $datos_curso[0]->tamano_titulo);
            $this->Cell(180, 18, utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER)), 0, 1, 'C');

            // TIPO PARTICIPACION
            if ($estudiante->tipo_participacion == "PARTICIPANTE") {
                // aprobado o participado
                $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
                $this->Cell(190, 20, utf8_decode($this->verificar_aprobacion($datos_curso[0]->nota_aprobacion, $estudiante->calificacion_final)), 0, 1, '');
            } elseif ($estudiante->tipo_participacion == "EXPOSITOR") {
                $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
                $this->Cell(190, 20, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso:"), 0, 1, '');
            } elseif ($estudiante->tipo_participacion == "ORGANIZADOR") {
                $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
                $this->Cell(190, 20, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso:"), 0, 1, '');
            } else {
                $this->SetXY($datos_curso[0]->posx_bloque_texto, $datos_curso[0]->posy_bloque_texto);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $this->SetFont('arial', '', $datos_curso[0]->tamano_subtitulo);
                $this->Cell(190, 20, utf8_decode("Por haber participado  del curso:"), 0, 1, '');
            }



            //qr
            $code = md5('CERTIFICADO_' . $estudiante->id_inscripcion_curso);
            $this->Image("http://localhost/generar_qr/qr_generator.php?code=" . $code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36, "png");
            // $this->Image("https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$url&.png", $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36);
            // texto de verificacion qr
            $this->SetXY(intval($datos_curso[0]->posx_qr), intval($datos_curso[0]->posy_qr) + 36);
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->MultiCell(36, 3.5, utf8_decode("Código QR de verificación del certificado"), 0, "C");

            // Fecha de certificacion
            $fecha_certificacion = "El Alto, " . fecha_literal(explode(' ', $datos_curso[0]->fecha_certificacion)[0]);
            $this->SetXY(145, 143);
            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetFont('Arial', '', $datos_curso[0]->tamano_subtitulo);
            $this->Cell(190, 20, utf8_decode($fecha_certificacion), 0, 1, '');
        }

        $name = "doc_" . date('Y_m_d_H_s_i') . ".pdf";

        $this->Output("F", "assets/pdf_temp/$name");
        echo "pdf_temp/$name";
    }

    public function imprimir_recibo($datos)
    {
        $this->AddPage("P", "letter");
        $this->Image('assets/img/posgrado.png', 31, 13, 23, 10);
        $this->SetXY(30, 10);
        $this->Cell(160, 70, "", 1);
        //nombre curso
        $this->SetXY(60, 13);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(110, 11, utf8_decode($datos['titulo']), 0);

        //fecha
        $this->SetXY(150, 9);
        $this->SetFont('Arial', '', 11);
        $this->Cell(40, 10, utf8_decode("Fecha: " . $datos['fecha']), 0);
        $this->SetXY(150, 14);
        $this->Cell(40, 10, utf8_decode("Número: " . $datos['numero']), 0);
        $this->SetXY(150, 19);
        $this->Cell(40, 10, utf8_decode("Importe: " . $datos['importe']), 0);

        $this->Ln(4);
        $this->SetX(32);
        $this->Cell(10, 10, utf8_decode("------------------------------------------------------------------------------------------------------------------------"), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('Descripción: '), 0);
        $this->SetX(63);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['descripcion']), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('Recibido por: '), 0);
        $this->SetX(65);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['recibido_por']), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('Entregado a: '), 0);
        $this->SetX(65);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['entregado_a']), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('A favor de: '), 0);
        $this->SetX(60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['a_favor_de']), 0);

        $this->Ln(15);
        $this->SetX(50);
        $this->Cell(10, 10, utf8_decode("----------------------------------                              -----------------------------------"), 0);
        $this->Ln(4);
        $this->SetX(50);
        $this->Cell(10, 10, utf8_decode("       Recibí conforme                                           Entregué conforme"), 0);



        $this->Image('assets/img/posgrado.png', 31, 125, 23, 10);
        $this->SetXY(30, 120);
        $this->Cell(160, 70, "", 1);
        //nombre curso
        $this->SetXY(60, 125);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(110, 11, utf8_decode($datos['titulo']), 0);

        //fecha
        $this->SetXY(150, 120);
        $this->SetFont('Arial', '', 11);
        $this->Cell(40, 10, utf8_decode("Fecha: " . $datos['fecha']), 0);
        $this->SetXY(150, 126);
        $this->Cell(40, 10, utf8_decode("Número: " . $datos['numero']), 0);
        $this->SetXY(150, 132);
        $this->Cell(40, 10, utf8_decode("Importe: " . $datos['importe']), 0);

        $this->Ln(3);
        $this->SetX(32);
        $this->Cell(10, 10, utf8_decode("------------------------------------------------------------------------------------------------------------------------"), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('Descripción: '), 0);
        $this->SetX(63);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['descripcion']), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('Recibido por: '), 0);
        $this->SetX(65);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['recibido_por']), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('Entregado a: '), 0);
        $this->SetX(65);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['entregado_a']), 0);

        $this->Ln(6);
        $this->SetX(31);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(40, 10, utf8_decode('A favor de: '), 0);
        $this->SetX(60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 10, utf8_decode($datos['a_favor_de']), 0);

        $this->Ln(15);
        $this->SetX(50);
        $this->Cell(10, 10, utf8_decode("----------------------------------                              -----------------------------------"), 0);
        $this->Ln(4);
        $this->SetX(50);
        $this->Cell(10, 10, utf8_decode("       Recibí conforme                                           Entregué conforme"), 0);

        echo base64_encode($this->Output('S'));
    }
}
