<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "/libraries/Fpdf_psg.php";
require_once APPPATH . "/libraries/WriteTag.php";

class ImprimirCertificado extends Fpdf_psg
{

    public function __construct()
    {
        parent::__construct();
    }

    public function imprimir_certificado_estudiante($datos_curso = null, $datos_estudiante = null, $value)
    {

        $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
        $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);

        foreach ($datos_estudiante as $estudiante) {

            $valor = ['id_inscripcion_curso', 'nombre_estudiante', 'calificacion_final', 'tipo_participacion', 'nombre_curso', 'fecha_inicial', 'fecha_final', 'carga_horaria', 'imagen_personalizado', 'posx_imagen_personalizado', 'posy_imagen_personalizado', 'color_nombre_curso', 'fecha_certificacion', 'tipo'];

            $est = array();

            for ($i = 0; $i < count($estudiante); $i++) {

                $est[$valor[$i]] = $estudiante[$i];
            }

            $this->AddPage("L", "letter");

            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                $this->Image($datos_curso[0]->imagen_curso, 0, 0, 279.4, 215.9);
            }

            // Nombre estudiante
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_participante, $datos_curso[0]->posy_nombre_participante);
            $this->AddFont('Parisienne-Regular', '', 'Parisienne-Regular.php');
            $this->SetFont('Parisienne-Regular', '', $datos_curso[0]->tamano_titulo + 10);
            if ($value == "SI") {
                $this->Cell(15, 18, utf8_decode("A: "), 0, 1, 'C');
            }

            $this->SetFont('Arial', 'B', $datos_curso[0]->tamano_titulo);
            $this->SetXY($datos_curso[0]->posx_nombre_participante + 15, $datos_curso[0]->posy_nombre_participante);
            $this->Cell(196, 18, utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($est['nombre_estudiante'])), MB_CASE_UPPER)), 0, 1, 'C');

            // TIPO PARTICIPACION
            $this->SetTextColor(0, 0, 0);
            if ($est['tipo_participacion'] == "PARTICIPANTE") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode($this->verificar_aprobacion($datos_curso[0]->nota_aprobacion, $est['calificacion_final'])), 0, 1, '');
            } elseif ($est['tipo_participacion'] == "EXPOSITOR") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso práctico de:"), 0, 1, '');
            } elseif ($est['tipo_participacion'] == "ORGANIZADOR") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso práctico de:"), 0, 1, '');
            } else {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado  del curso práctico de:"), 0, 1, '');
            }

            // titulo del curso
            if ($est['color_nombre_curso'] == "") {
                $color_s[0] = 0;
                $color_s[1] = 0;
                $color_s[2] = 0;
            } else {
                $color_s = explode(", ", $est['color_nombre_curso']);
            }

            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_curso, $datos_curso[0]->posy_nombre_curso);
            $this->AddFont('BookmanOldStyle-Bold', '', 'BOOKOSB.php');
            $this->SetFont('BookmanOldStyle-Bold', '', $datos_curso[0]->tamano_subtitulo);
            $this->MultiCell(214, 9, utf8_decode($est['nombre_curso']), 0, 'C');

            //IMPRIMIR SUBITULO
            $posy_bt = intval($datos_curso[0]->posy_bloque_texto);
            if ($est['tipo'] == "CURSO") {
                if ($datos_curso[0]->imprimir_subtitulo == "1") {
                    $this->SetX($datos_curso[0]->posx_nombre_curso);
                    $this->SetFont('Arial', 'B', 13);
                    $this->Cell(214, 5, utf8_decode($datos_curso[0]->subtitulo), 0, 1, 'C');
                    $posy_bt = $posy_bt + 4;
                }
            }

            //bloque de texto
            $this->SetTextColor(0, 0, 0);
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $posy_bt);
            $dia = date("d", strtotime($est['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($est['fecha_inicial'])));
            $fecha_final = strtolower(fecha_literal($est['fecha_final']));
            $carga_horaria = $est['carga_horaria'];
            $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
            $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
            $this->multiCelda(210, 8, utf8_decode("Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de $carga_horaria horas académicas."), 0, 'J');
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($est['fecha_certificacion']));
            $this->SetX($datos_curso[0]->posx_bloque_texto);
            $this->multiCelda(210, 8, utf8_decode(($fecha_certificacion)) . "     ", 0, 'R');

            // imagen personalizado curso
            if ($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null) {
                $this->Image($est['imagen_personalizado'], $est['posx_imagen_personalizado'], $est['posy_imagen_personalizado']);
            }

            //qr
            $code = md5('CERTIFICADO_' . $est['id_inscripcion_curso']);
            $this->Image("http://localhost/generar_qr/qr_generator.php?code=" . $code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36, "png");
            // texto de verificacion qr
            $this->SetXY(intval($datos_curso[0]->posx_qr), intval($datos_curso[0]->posy_qr) + 36);
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->MultiCell(36, 3.5, utf8_decode("Código QR de verificación del certificado"), 0, "C");
        }
        echo base64_encode($this->Output('S'));
    }

    public function verificar_aprobacion($nota_aprobacion, $nota_final)
    {
        if (intval($nota_final) >= intval($nota_aprobacion)) {
            return "Por haber APROBADO SATISFACTORIAMENTE el curso práctico de: ";
        } else {
            return "Por haber PARTICIPADO del curso práctico de: ";
        }
    }

    public function mes_literal($mes)
    {
        $m = '';
        if ($mes == '01' || $mes == '1') {
            $m = "enero";
        } elseif ($mes == '02' || $mes == '2') {
            $m = "febrero";
        } elseif ($mes == '03' || $mes == '3') {
            $m = "marzo";
        } elseif ($mes == '04' || $mes == '4') {
            $m = "abril";
        } elseif ($mes == '05' || $mes == '5') {
            $m = "mayo";
        } elseif ($mes == '06' || $mes == '6') {
            $m = "junio";
        } elseif ($mes == '07' || $mes == '7') {
            $m = "julio";
        } elseif ($mes == '08' || $mes == '8') {
            $m = "agosto";
        } elseif ($mes == '09' || $mes == '9') {
            $m = "septiembre";
        } elseif ($mes == '10') {
            $m = "octubre";
        } elseif ($mes == '11') {
            $m = "noviembre";
        } else {
            $m = "diciembre";
        }
        return $m;
    }

    // IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO HORIZONTAL
    public function certificado1($datos_curso = null, $datos_estudiante = null, $value,  $certificado_blanco)
    {
        $pdf = new PDF_WriteTag();
        // TAMAÑOS
        $pdf->ancho = 210;
        $pdf->alto = 6;
        $pdf->alto_subtitulo = 5;
        $pdf->ancho_a = 15;

        foreach ($datos_estudiante as $estudiante) {

            $valor = [
                'id_inscripcion_curso',
                'nombre_estudiante', 'calificacion_final',
                'tipo_participacion', 'nombre_curso', 'fecha_inicial',
                'fecha_final', 'carga_horaria', 'imagen_personalizado',
                'posx_imagen_personalizado', 'posy_imagen_personalizado',
                'color_nombre_curso', 'fecha_certificacion', 'tipo'
            ];

            $est = array();
            for ($i = 0; $i < count($estudiante); $i++) {
                $est[$valor[$i]] = $estudiante[$i];
            }

            $pdf->AddPage("L", "letter");

            // IMAGEN DEL CERTIFICADO
            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                if ($datos_curso[0]->orientacion == "vertical") {
                    $w = 215.9;
                    $h = 279.4;
                } else {
                    $w = 279.4;
                    $h = 215.9;
                }
                $pdf->print_imagen($datos_curso[0]->imagen_curso, 0, 0, $w, $h);
            }

            // NOMBRE DEL PARTICIPANTE
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $pdf->print_participante(
                $est['nombre_estudiante'],
                $datos_curso[0]->posx_nombre_participante + 15,
                $datos_curso[0]->posy_nombre_participante,
                'Arial-bold',
                $datos_curso[0]->tamano_titulo,
                'PalaceScriptMT',
                14,
                $color_p,
                '',
                $value,
            );

            // TIPO PARTICIPACION
            $pdf->print_tipo_partipacion(
                $est['tipo_participacion'],
                $datos_curso[0]->posx_tipo_participacion,
                $datos_curso[0]->posy_tipo_participacion,
                "OpenSans-Light",
                $datos_curso[0]->tamano_texto,
                "OpenSans-Regular",
                [0, 0, 0],
                $datos_curso[0]->nota_aprobacion,
                $est['calificacion_final']
            );

            // NOMBRE DEL CURSO
            if ($est['color_nombre_curso'] != "") {
                $color_s = explode(", ", $est['color_nombre_curso']);
            }
            $pdf->print_titulo_curso(
                $est['nombre_curso'],
                $datos_curso[0]->posx_nombre_curso,
                $datos_curso[0]->posy_nombre_curso,
                "BookmanOldStyle-Bold",
                $datos_curso[0]->tamano_subtitulo,
                $datos_curso[0]->subtitulo,
                "OpenSans-Regular",
                15,
                $color_s,
                $est['tipo'],
                $datos_curso[0]->imprimir_subtitulo
            );

            //BLOQUE TEXTO
            $dia = date("d", strtotime($est['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($est['fecha_inicial'])));
            $fecha_final = strtolower(fecha_literal($est['fecha_final']));
            $carga_horaria = $est['carga_horaria'];
            $text = utf8_decode("<p>Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de <vb> $carga_horaria horas académicas</vb>.</p>");
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($est['fecha_certificacion']));
            $pdf->print_bloque_texto(
                $text,
                $datos_curso[0]->posx_bloque_texto,
                $datos_curso[0]->posy_bloque_texto,
                "OpenSans-Light",
                $datos_curso[0]->tamano_texto,
                "OpenSans-Regular",
                [0, 0, 0],
                $fecha_certificacion

            );

            //  IMAGEN PERSONALIZADA
            if ($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null) {
                $pdf->print_imagen($est['imagen_personalizado'], $est['posx_imagen_personalizado'], $est['posy_imagen_personalizado']);
            }

            //QR
            if ($certificado_blanco == false) {
                $code = md5('CERTIFICADO_' . $est['id_inscripcion_curso']);
                $pdf->print_qr($code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 'AusterRounded-Light', 10);
            }
        }

        if ($certificado_blanco == false) {
            $name = $datos_curso[0]->shortname . date('Y_m_d_H_s_i') . ".pdf";
            $pdf->Output("F", "assets/pdf_temp/$name");
            echo "pdf_temp/$name";
        } else {
            echo base64_encode($pdf->Output('S'));
        }
    }

    // IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO HORIZONTAL
    public function certificado2($datos_curso = null, $datos_estudiante = null, $value, $certificado_blanco)
    {
        $pdf = new PDF_WriteTag();
        // TAMAÑOS
        $pdf->ancho = 193;
        $pdf->alto = 9;
        $pdf->alto_subtitulo = 5;
        $pdf->ancho_a = 15;

        foreach ($datos_estudiante as $estudiante) {
            $valor = [
                'id_inscripcion_curso',
                'nombre_estudiante', 'calificacion_final',
                'tipo_participacion', 'nombre_curso', 'fecha_inicial',
                'fecha_final', 'carga_horaria', 'imagen_personalizado',
                'posx_imagen_personalizado', 'posy_imagen_personalizado',
                'color_nombre_curso', 'fecha_certificacion', 'tipo'
            ];
            $est = array();
            for ($i = 0; $i < count($estudiante); $i++) {
                $est[$valor[$i]] = $estudiante[$i];
            }

            $pdf->AddPage("L", "letter");

            // IMAGEN DEL CERTIFICADO
            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                if ($datos_curso[0]->orientacion == "vertical") {
                    $w = 215.9;
                    $h = 279.4;
                } else {
                    $w = 279.4;
                    $h = 215.9;
                }
                $pdf->print_imagen($datos_curso[0]->imagen_curso, 0, 0, $w, $h);
            }

            // CABECERA DEL CERTIFICADO
            $pdf->AddFont('AusterRounded-Light', '', 'AusterRounded-Light.php');
            $pdf->SetFont('AusterRounded-Light', '', 17);
            $pdf->SetXY(43, 59);
            $pdf->Cell(70, 7, "Otorga el Presente: ", 0, 1, 'L');
            $pdf->AddFont('BebasNeue-Regular', '', 'BebasNeue-Regular.php');
            $pdf->SetFont('BebasNeue-Regular', '', 60);
            $pdf->SetXY(10, 58);
            $pdf->Cell(0, 20, "CERTIFICADO", 0, 1, 'C');

            // NOMBRE DEL PARTICIPANTE
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $pdf->print_participante(
                $est['nombre_estudiante'],
                $datos_curso[0]->posx_nombre_participante + 15,
                $datos_curso[0]->posy_nombre_participante,
                'Roboto-Black',
                $datos_curso[0]->tamano_titulo,
                'PalaceScriptMT',
                14,
                $color_p,
                '',
                $value
            );

            // TIPO PARTICIPACION
            $pdf->print_tipo_partipacion(
                $est['tipo_participacion'],
                $datos_curso[0]->posx_tipo_participacion,
                $datos_curso[0]->posy_tipo_participacion,
                "AusterRounded-Light",
                $datos_curso[0]->tamano_texto,
                "AusterRounded-Book",
                [0, 0, 0],
                $datos_curso[0]->nota_aprobacion,
                $est['calificacion_final']
            );

            // NOMBRE DEL CURSO
            if ($est['color_nombre_curso'] != "") {
                $color_s = explode(", ", $est['color_nombre_curso']);
            }
            $pdf->print_titulo_curso(
                $est['nombre_curso'],
                $datos_curso[0]->posx_nombre_curso,
                $datos_curso[0]->posy_nombre_curso,
                "BebasNeue-Regular",
                $datos_curso[0]->tamano_subtitulo,
                $datos_curso[0]->subtitulo,
                "AusterRounded-Light",
                15,
                $color_s,
                $est['tipo'],
                $datos_curso[0]->imprimir_subtitulo
            );

            //BLOQUE TEXTO
            $dia = date("d", strtotime($est['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($est['fecha_inicial'])));
            $fecha_final = strtolower(fecha_literal($est['fecha_final']));
            $carga_horaria = $est['carga_horaria'];
            $text = utf8_decode("<p>Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de <vb> $carga_horaria horas académicas</vb>.</p>");
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($est['fecha_certificacion']));
            $pdf->print_bloque_texto(
                $text,
                $datos_curso[0]->posx_bloque_texto,
                $datos_curso[0]->posy_bloque_texto,
                "AusterRounded-Light",
                $datos_curso[0]->tamano_texto,
                "AusterRounded-Book",
                [0, 0, 0],
                $fecha_certificacion
            );

            //  IMAGEN PERSONALIZADA
            if ($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null) {
                $pdf->print_imagen($est['imagen_personalizado'], $est['posx_imagen_personalizado'], $est['posy_imagen_personalizado']);
            }

            //QR
            if ($certificado_blanco == false) {
                $code = md5('CERTIFICADO_' . $est['id_inscripcion_curso']);
                $pdf->print_qr($code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 'AusterRounded-Light', 10);
            }
        }

        if ($certificado_blanco == false) {
            $name = $datos_curso[0]->shortname . date('Y_m_d_H_s_i') . ".pdf";
            $pdf->Output("F", "assets/pdf_temp/$name");
            echo "pdf_temp/$name";
        } else {
            echo base64_encode($pdf->Output('S'));
        }
    }

    public function certificado3($datos_curso = null, $datos_estudiante = null, $value, $certificado_blanco)
    {
        $pdf = new PDF_WriteTag();
        // TAMAÑOS
        $pdf->ancho = 131;
        $pdf->alto = 8;
        $pdf->alto_subtitulo = 5;
        $pdf->ancho_a = 18;

        foreach ($datos_estudiante as $estudiante) {
            $valor = [
                'id_inscripcion_curso',
                'nombre_estudiante', 'calificacion_final',
                'tipo_participacion', 'nombre_curso', 'fecha_inicial',
                'fecha_final', 'carga_horaria', 'imagen_personalizado',
                'posx_imagen_personalizado', 'posy_imagen_personalizado',
                'color_nombre_curso', 'fecha_certificacion', 'tipo'
            ];

            $est = array();
            for ($i = 0; $i < count($estudiante); $i++) {
                $est[$valor[$i]] = $estudiante[$i];
            }

            $pdf->AddPage("P", "letter");

            // IMAGEN DEL CERTIFICADO
            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                if ($datos_curso[0]->orientacion == "vertical") {
                    $w = 215.9;
                    $h = 279.4;
                } else {
                    $w = 279.4;
                    $h = 215.9;
                }
                $pdf->print_imagen($datos_curso[0]->imagen_curso, 0, 0, $w, $h);
            }

            // CABECERA DEL CERTIFICADO
            $pdf->AddFont('AusterRounded-Light', '', 'AusterRounded-Light.php');
            $pdf->SetFont('AusterRounded-Light', '', 15);
            $pdf->SetXY(68, 51);
            $pdf->Cell(70, 7, "Otorga el Presente: ", 0, 1, 'L');
            $pdf->AddFont('BebasNeue-Regular', '', 'BebasNeue-Regular.php');
            $pdf->SetFont('BebasNeue-Regular', '', 60);
            $pdf->SetXY(10, 65);
            $pdf->Cell(197, 20, "CERTIFICADO", 0, 1, 'C');

            // NOMBRE DEL PARTICIPANTE
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $pdf->print_participante(
                $est['nombre_estudiante'],
                $datos_curso[0]->posx_nombre_participante + 15,
                $datos_curso[0]->posy_nombre_participante,
                'Roboto-Black',
                $datos_curso[0]->tamano_titulo,
                'PalaceScriptMT',
                14,
                $color_p,
                '',
                $value
            );

            // TIPO PARTICIPACION
            $pdf->print_tipo_partipacion(
                $est['tipo_participacion'],
                $datos_curso[0]->posx_tipo_participacion,
                $datos_curso[0]->posy_tipo_participacion,
                "AusterRounded-Light",
                $datos_curso[0]->tamano_texto,
                "AusterRounded-Book",
                [0, 0, 0],
                $datos_curso[0]->nota_aprobacion,
                $est['calificacion_final']
            );

            // NOMBRE DEL CURSO
            if ($est['color_nombre_curso'] != "") {
                $color_s = explode(", ", $est['color_nombre_curso']);
            }
            $pdf->print_titulo_curso(
                $est['nombre_curso'],
                $datos_curso[0]->posx_nombre_curso,
                $datos_curso[0]->posy_nombre_curso,
                "BebasNeue-Regular",
                $datos_curso[0]->tamano_subtitulo,
                $datos_curso[0]->subtitulo,
                "AusterRounded-Light",
                13,
                $color_s,
                $est['tipo'],
                $datos_curso[0]->imprimir_subtitulo
            );

            //BLOQUE TEXTO
            $dia = date("d", strtotime($est['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($est['fecha_inicial'])));
            $fecha_final = strtolower(fecha_literal($est['fecha_final']));
            $carga_horaria = $est['carga_horaria'];
            $text = utf8_decode("<p>Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de <vb> $carga_horaria horas académicas</vb>.</p>");
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($est['fecha_certificacion']));
            $pdf->print_bloque_texto(
                $text,
                $datos_curso[0]->posx_bloque_texto,
                $datos_curso[0]->posy_bloque_texto,
                "AusterRounded-Light",
                $datos_curso[0]->tamano_texto,
                "AusterRounded-Book",
                [0, 0, 0],
                $fecha_certificacion

            );

            //  IMAGEN PERSONALIZADA
            if ($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null) {
                $pdf->print_imagen($est['imagen_personalizado'], $est['posx_imagen_personalizado'], $est['posy_imagen_personalizado']);
            }

            if ($certificado_blanco == false) {
                //QR
                $code = md5('CERTIFICADO_' . $est['id_inscripcion_curso']);
                $pdf->print_qr($code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 'AusterRounded-Light', 10);
            }
        }
        if ($certificado_blanco == false) {
            $name = $datos_curso[0]->shortname . date('Y_m_d_H_s_i') . ".pdf";
            $pdf->Output("F", "assets/pdf_temp/$name");
            echo "pdf_temp/$name";
        } else {
            echo base64_encode($pdf->Output('S'));
        }
    }

    // IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO HORIZONTAL
    public function certificado4($datos_curso = null, $datos_estudiante = null, $value,  $certificado_blanco)
    {
        $pdf = new PDF_WriteTag();
        // TAMAÑOS
        $pdf->ancho = 210;
        $pdf->alto = 6;
        $pdf->alto_subtitulo = 5;
        $pdf->ancho_a = 15;

        foreach ($datos_estudiante as $estudiante) {

            $valor = [
                'id_inscripcion_curso',
                'nombre_estudiante', 'calificacion_final',
                'tipo_participacion', 'nombre_curso', 'fecha_inicial',
                'fecha_final', 'carga_horaria', 'imagen_personalizado',
                'posx_imagen_personalizado', 'posy_imagen_personalizado',
                'color_nombre_curso', 'fecha_certificacion', 'tipo'
            ];

            $est = array();
            for ($i = 0; $i < count($estudiante); $i++) {
                $est[$valor[$i]] = $estudiante[$i];
            }

            $pdf->AddPage("L", "letter");

            // IMAGEN DEL CERTIFICADO
            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                if ($datos_curso[0]->orientacion == "vertical") {
                    $w = 215.9;
                    $h = 279.4;
                } else {
                    $w = 279.4;
                    $h = 215.9;
                }
                $pdf->print_imagen($datos_curso[0]->imagen_curso, 0, 0, $w, $h);
            }

            // CABECERA DEL CERTIFICADO
            $pdf->AddFont('AusterRounded-Light', '', 'AusterRounded-Light.php');
            $pdf->SetFont('AusterRounded-Light', '', 17);
            $pdf->SetXY(43, 59);
            $pdf->Cell(70, 7, "Otorga el Presente: ", 0, 1, 'L');
            $pdf->AddFont('BebasNeue-Regular', '', 'BebasNeue-Regular.php');
            $pdf->SetFont('BebasNeue-Regular', '', 60);
            $pdf->SetXY(10, 58);
            $pdf->Cell(0, 20, "CERTIFICADO", 0, 1, 'C');

            // NOMBRE DEL PARTICIPANTE
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $pdf->print_participante(
                $est['nombre_estudiante'],
                $datos_curso[0]->posx_nombre_participante + 15,
                $datos_curso[0]->posy_nombre_participante,
                'Arial-bold',
                $datos_curso[0]->tamano_titulo,
                'PalaceScriptMT',
                14,
                $color_p,
                '',
                $value,
            );

            // TIPO PARTICIPACION
            $pdf->print_tipo_partipacion(
                $est['tipo_participacion'],
                $datos_curso[0]->posx_tipo_participacion,
                $datos_curso[0]->posy_tipo_participacion,
                "OpenSans-Light",
                $datos_curso[0]->tamano_texto,
                "OpenSans-Regular",
                [0, 0, 0],
                $datos_curso[0]->nota_aprobacion,
                $est['calificacion_final']
            );

            // NOMBRE DEL CURSO
            if ($est['color_nombre_curso'] != "") {
                $color_s = explode(", ", $est['color_nombre_curso']);
            }
            $pdf->print_titulo_curso(
                $est['nombre_curso'],
                $datos_curso[0]->posx_nombre_curso,
                $datos_curso[0]->posy_nombre_curso,
                "BookmanOldStyle-Bold",
                $datos_curso[0]->tamano_subtitulo,
                $datos_curso[0]->subtitulo,
                "OpenSans-Regular",
                15,
                $color_s,
                $est['tipo'],
                $datos_curso[0]->imprimir_subtitulo
            );

            //BLOQUE TEXTO
            $dia = date("d", strtotime($est['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($est['fecha_inicial'])));
            $fecha_final = strtolower(fecha_literal($est['fecha_final']));
            $carga_horaria = $est['carga_horaria'];
            $text = utf8_decode("<p>Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de <vb> $carga_horaria horas académicas</vb>.</p>");
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($est['fecha_certificacion']));
            $pdf->print_bloque_texto(
                $text,
                $datos_curso[0]->posx_bloque_texto,
                $datos_curso[0]->posy_bloque_texto,
                "OpenSans-Light",
                $datos_curso[0]->tamano_texto,
                "OpenSans-Regular",
                [0, 0, 0],
                $fecha_certificacion

            );

            //  IMAGEN PERSONALIZADA
            if ($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null) {
                $pdf->print_imagen($est['imagen_personalizado'], $est['posx_imagen_personalizado'], $est['posy_imagen_personalizado']);
            }

            //QR
            if ($certificado_blanco == false) {
                $code = md5('CERTIFICADO_' . $est['id_inscripcion_curso']);
                $pdf->print_qr($code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 'AusterRounded-Light', 10);
            }
        }

        if ($certificado_blanco == false) {
            $name = $datos_curso[0]->shortname . date('Y_m_d_H_s_i') . ".pdf";
            $pdf->Output("F", "assets/pdf_temp/$name");
            echo "pdf_temp/$name";
        } else {
            echo base64_encode($pdf->Output('S'));
        }
    }

    public function generate_certificates($datos_curso = null, $datos_estudiante = null)
    {
        $cn = 0;
        $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
        $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
        foreach ($datos_estudiante as $key => $estudiante) {
            $pdf = new FPDF();
            $pdf->AddPage("L", "letter");
            $rand = random_int(1, 10);
            $pdf->Image("assets/certificados_enviar/$estudiante->id/" . $rand . ".jpg", 0, 0, 279.4, 215.9);

            // Nombre estudiante
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $pdf->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
            $pdf->SetXY($datos_curso[0]->posx_nombre_participante, $datos_curso[0]->posy_nombre_participante);
            $pdf->AddFont('Parisienne-Regular', '', 'Parisienne-Regular.php');
            $pdf->SetFont('Parisienne-Regular', '', $datos_curso[0]->tamano_titulo + 10);
            // $pdf->Cell(15, 18, utf8_decode("A: "), 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', $datos_curso[0]->tamano_titulo);
            $pdf->SetXY($datos_curso[0]->posx_nombre_participante + 15, $datos_curso[0]->posy_nombre_participante);
            $pdf->Cell(196, 18, utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($estudiante->usuario)), MB_CASE_UPPER)), 0, 1, 'C');

            // TIPO PARTICIPACION
            $pdf->SetTextColor(0, 0, 0);
            if ($estudiante->tipo_participacion == "PARTICIPANTE") {
                $pdf->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $pdf->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $pdf->SetFont('Arial', 'B', $datos_curso[0]->tamano_texto);
                $pdf->Cell(190, 11, utf8_decode($this->verificar_aprobacion($datos_curso[0]->nota_aprobacion, $estudiante->calificacion_final)), 0, 1, '');
            } elseif ($estudiante->tipo_participacion == "EXPOSITOR") {
                $pdf->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $pdf->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $pdf->SetFont('Arial', 'B', $datos_curso[0]->tamano_texto);
                $pdf->Cell(190, 11, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso:"), 0, 1, '');
            } elseif ($estudiante->tipo_participacion == "ORGANIZADOR") {
                $pdf->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $pdf->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $pdf->SetFont('Arial', 'B', $datos_curso[0]->tamano_texto);
                $pdf->Cell(190, 11, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso:"), 0, 1, '');
            } else {
                $pdf->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $color_s = explode(", ", $datos_curso[0]->color_subtitulo);
                $pdf->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
                $pdf->SetFont('Arial', 'B', $datos_curso[0]->tamano_texto);
                $pdf->Cell(190, 11, utf8_decode("Por haber participado  del curso:"), 0, 1, '');
            }

            //qr
            $code = md5('CERTIFICADO_' . $estudiante->id_inscripcion_curso);
            $pdf->Image("http://localhost/generar_qr/qr_generator.php?code=" . $code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36, "png");
            // texto de verificacion qr
            $pdf->SetXY(intval($datos_curso[0]->posx_qr), intval($datos_curso[0]->posy_qr) + 36);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(36, 3.5, utf8_decode("Código QR de verificación del certificado"), 0, "C");

            $name = $estudiante->id_inscripcion_curso . ".pdf";
            $pdf->Output("F", "assets/certificados_enviar/enviar_{$estudiante->id}/$name");
            $pdf->Close();
            $cn++;
        }
        return $cn;
    }

    function numberToLetras($xcifra)
    {
        $xarray = array(
            0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
        //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                } else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena .= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena .= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN BILLON ";
                        else
                            $xcadena .= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN MILLON ";
                        else
                            $xcadena .= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO Bs.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN  Bs. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena .= "  Bs. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }
    // END FUNCTION

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }

    // IMPRIMIR TOTAL RECAUDACION
    public function imprimir_reporte_total_reacudacion($data_course, $inscritos, $preinscritos)
    {
        $this->AddPage("P", "letter");
        // $this->Image("assets/img/img_send_certificate/posgrado-negro.jpg", 20, 10, 28, 14.5);
        $this->AddFont('EthnocentricRg-Regular', '', 'EthnocentricRg-Regular.php');
        $this->SetFont('EthnocentricRg-Regular', '', 20);
        $this->Cell(0, 8, utf8_decode("CURSOS POSGRADO"), 0, 1, "C");
        $this->Cell(0, 8, utf8_decode("UPEA"), 0, 1, "C");
        $tam = 5;
        $bordeCelda = 0;
        $this->Ln();
        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Curso: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->nombre_curso), $bordeCelda, 1, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Fecha Inicio: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->fecha_inicial), $bordeCelda, 1, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Fecha Fin: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->fecha_final), $bordeCelda, 1, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Carga Horaria: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->carga_horaria . " horas académicas"), $bordeCelda, 1, 'L');

        $this->Ln();
        $this->SetFont('Arial', 'BU', 12);
        $this->Cell(0, 6, utf8_decode("TOTAL RECAUDACIÓN INSCRITOS"), 0, 1, "C");
        $this->Ln();
        $header = array('Tipo Pago', 'Monto Total');
        $this->SetX($this->GetX() + 45);
        $this->FancyTable($header, $inscritos);

        $this->Ln(7);
        $this->SetFont('Arial', 'BU', 12);
        $this->Cell(0, 6, utf8_decode("TOTAL RECAUDACIÓN PREINSCRITOS"), 0, 1, "C");
        $this->Ln();
        $this->SetX($this->GetX() + 45);
        $this->FancyTable($header, $preinscritos);

        $this->Ln(7);
        $this->SetFont('Arial', 'BU', 12);
        $this->Cell(0, 6, utf8_decode("TOTAL RECAUDACIÓN"), 0, 1, "C");
        $this->Ln();
        $this->SetX($this->GetX() + 45);
        $this->imprimir_total($inscritos, $preinscritos);

        echo base64_encode($this->Output('S'));
    }

    public function imprimir_total($inscritos, $preinscritos)
    {
        $this->SetFillColor(51, 102, 204);
        $this->SetTextColor(255);
        $this->SetDrawColor(51, 102, 204);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(55, 55,);

        $this->Cell($w[0], 7, "TOTAL: ", 1, 0, 'C', true);
        $this->Cell($w[1], 7, $this->sumar_inscritos_preinscritos($inscritos, $preinscritos) . " Bs.", 1, 0, 'C', true);
        $this->Ln();
    }

    public function sumar_inscritos_preinscritos($inscritos, $preinscritos)
    {
        $suma = 0;
        foreach ($inscritos as $row) {
            $suma = $suma + intval($row->monto_total);
        }

        $suma1 = 0;
        foreach ($preinscritos as $row) {
            $suma1 = $suma1 + intval($row->monto_total);
        }
        return $suma + $suma1;
    }

    public function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(51, 102, 204);
        $this->SetTextColor(255);
        $this->SetDrawColor(51, 102, 204);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(55, 55,);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        $total_inscritos = 0;
        if ($data != null) {
            foreach ($data as $row) {
                $this->SetX($this->GetX() + 45);
                $this->Cell($w[0], 6, $row->tipo_pago, 'LR', 0, 'L', $fill);
                $this->Cell($w[1], 6, $row->monto_total . " Bs.", 'LR', 0, 'C', $fill);
                $total_inscritos = $total_inscritos + intval($row->monto_total);
                $this->Ln();
                $fill = !$fill;
            }
            $this->SetFont('Arial', 'B', 12);
            $this->SetX($this->GetX() + 45);
            $this->Cell($w[0], 6, "TOTAL", 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $total_inscritos . " Bs.", 'LR', 0, 'C', $fill);
            $this->Ln();
        } else {
            $this->SetX($this->GetX() + 45);
            $this->Cell($w[0] + $w[1], 6, "SIN REGISTROS", 'LR', 0, 'C', $fill);
            $this->Ln();
        }
        // Closing line
        $this->SetX($this->GetX() + 45);
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    public function imprimir_recibo($data)
    {
        // return var_dump($data);
        // header('Content-Type: application/pdf');
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(90, 300));
        $pdf->AddPage();
        $pdf->SetMargins(0.2, 2, 0.2);

        $pdf->setXY(0.2, 3);
        $pdf->AddFont('EthnocentricRg-Regular', '', 'EthnocentricRg-Regular.php');
        $pdf->SetFont('EthnocentricRg-Regular', '', 16.1);
        $pdf->Cell(85, 6, utf8_decode("CURSOS POSGRADO"), 0, 1, "C");
        $pdf->setX(0.1);
        $pdf->Cell(85, 6, utf8_decode("UPEA"), 0, 1, "C");
        $pdf->setX(0.7);
        $pdf->Image('assets/img/img_send_certificate/posgrado-negro.jpg', 22, $pdf->GetY() + 0.2, 40, 17);
        $pdf->SetY($pdf->GetY() + 17);

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(85, 4, utf8_decode("https://cursosposgrado.upea.bo/"), 0, 1, "C");
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(85, 1, utf8_decode("----------------------------------------------------------------------------------"), 0, 1, "C");
        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 13);
        $pdf->Cell(85, 9, utf8_decode("DIRECCIÓN DE POSGRADO"), 0, 1, "C");
        $pdf->Cell(85, 8, utf8_decode("Edificio Emblemático de la UPEA."), 0, 1, "C");
        $pdf->setX(0.1);
        $pdf->Cell(85, 8, utf8_decode("Tercer Piso Oficina Nº 3"), 0, 1, "C");
        $pdf->setX(0.1);
        $pdf->Cell(85, 8, utf8_decode("Dirección: Av. Juan Pablo II y Av. Sucre"), 0, 1, "C");
        $pdf->setX(0.1);
        $pdf->Cell(85, 8, utf8_decode("Zona: Villa Esperanza"), 0, 1, "C");
        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(85, 1, utf8_decode("========================================="), 0, 1, "C");
        $pdf->SetFont('Arial', 'B', 14.3);
        $pdf->Cell(85, 7, utf8_decode("COMPROBANTE DE INSCRIPCIÓN"), 0, 1, "C");
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(85, 1, utf8_decode("========================================="), 0, 1, "C");

        $pdf->Cell(85, 1.7, utf8_decode(""), 0, 1, "C");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("Nº transacción: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode($data->id_transaccion), 0, 1, "R");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("Fecha: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode(strtolower(strftime("%d/%m/%G", strtotime($data->fecha_pago)))), 0, 1, "R");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("Método de pago: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode("EFECTIVO"), 0, 1, "R");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("Nombre: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode($data->nombre), 0, 1, "R");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("Paterno: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode($data->paterno), 0, 1, "R");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("Materno: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode($data->materno), 0, 1, "R");

        $pdf->setX(0.1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(40, 8, utf8_decode("C.I.: "), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 8, utf8_decode($data->ci), 0, 1, "R");

        $pdf->Cell(85, 2, utf8_decode(""), 0, 1, "C");

        $data_header_table = array(utf8_decode('Nº'), 'CURSO', 'MONTO');
        $lenght = array(10, 60, 15);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetTypeCell(['c', 'c', 'c']);
        $pdf->SetAligns(['C', 'C', 'C']);
        $pdf->SetWidths($lenght);
        $pdf->setX(0.1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Row(
            $data_header_table
        );

        // Imprimir datos del reporte
        $data_table = array(utf8_decode('1'), utf8_decode($data->fullname), 'Bs.' . intval($data->monto_pago));
        $pdf->setX(0.1);
        $pdf->SetTypeCell(['c', 'm', 'c']);
        $pdf->SetAligns(['C', 'J', 'C']);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Row(
            $data_table
        );

        // Imprimir total
        $data_total = array(utf8_decode('TOTAL'), 'Bs.' . intval($data->monto_pago));
        $lenght1 = array(70, 15);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetTypeCell(['c', 'c']);
        $pdf->SetAligns(['C', 'C']);
        $pdf->SetWidths($lenght1);
        $pdf->setX(0.1);
        $pdf->Row(
            $data_total
        );

        // letras
        $pdf->SetY($pdf->GetY() + 3);
        $pdf->SetFont('Arial', '', 14);
        $pdf->setX(0.1);
        $pdf->Cell(85, 6, utf8_decode("Son: " . $this->numberToLetras(intval($data->monto_pago))), 0, 1, "L");
        $pdf->setX(0.1);
        $pdf->Cell(85, 6, utf8_decode("Usuario: BRAYAN27"), 0, 1, "L");
        $code = md5('INSCRIPCION_' . $data->id_preinscripcion_curso);

        $pdf->SetY($pdf->GetY() + 1);
        $pdf->Image("http://localhost/generar_qr/qr_generator.php?inscripcion=" . $code, 13.1, $pdf->GetY(), 60, 60, "png");
        $pdf->SetXY($pdf->GetX() + 18, $pdf->GetY() + 58.5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(50, 4, utf8_decode("Código QR de verificación de inscripción"), 0, "C");
        $pdf->SetY($pdf->GetY());
        $pdf->Ln();
        $pdf->setX(0.1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(85, 6, utf8_decode("**** GRACIAS POR INSCRIBIRSE AL CURSO ****"), 0, 1, "C");
        $pdf->Image('assets/img/img_send_certificate/teampsg-negro.jpg', 33, $pdf->GetY(), 20, 6);

        $pdf->Cell(85, 5, utf8_decode(""), 0, 1, "C");
        $pdf->Output("D", "factura" . date("_Y-m-d_H-i-s") . ".pdf", true);
    }

    public function imprimir_estudiantes($students, $data_course)
    {
        $this->AddPage("P", "letter");
        $this->SetFont('Arial', 'B', 14);
        $this->AddFont('EthnocentricRg-Regular', '', 'EthnocentricRg-Regular.php');
        $this->SetFont('EthnocentricRg-Regular', '', 20);
        $this->Cell(0, 8, utf8_decode("CURSOS POSGRADO"), 0, 1, "C");
        $this->Cell(0, 8, utf8_decode("UPEA"), 0, 1, "C");
        $tam = 5;
        $bordeCelda = 0;
        $this->Ln();
        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Curso: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->shortname), $bordeCelda, 1, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Fecha Inicio: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->fecha_inicial), $bordeCelda, 1, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Fecha Fin: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->fecha_final), $bordeCelda, 1, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(35, $tam, utf8_decode('Carga Horaria: '), $bordeCelda, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, $tam, utf8_decode($data_course[0]->carga_horaria . " horas académicas"), $bordeCelda, 1, 'L');
        $this->Ln();
        $this->SetTypeCell(['c', 'c', 'c', 'cfs']);
        $this->SetAligns(['C', 'C', 'C', 'C']);
        $this->SetWidths([35, 101, 30, 30]);
        $this->SetFont('Arial', 'B', 9);
        $this->Row([
            utf8_decode('ID INSCRIPCIÓN'),
            'NOMBRES Y APELLIDOS',
            'NOTA FINAL',
            'CERTIFICADO'
        ]);
        if (count($students) > 0) {
            $bandera = false;


            $this->SetAligns(['C', 'L', 'C', 'C']);
            $this->SetFont('Arial', '', 12);
            //Gris tenue de cada fila
            $this->SetFillColor(238, 238, 238);
            //Color del texto: Negro
            $this->SetTextColor(3, 3, 3);
            $this->SetFont('Arial', '', 8);
            foreach ($students as $key => $student) {
                if ($bandera) {
                    $d = "D";
                } else {
                    $d = "DF";
                }
                $this->Row([
                    $student->id_inscripcion_curso,
                    utf8_decode($student->usuario),
                    $student->calificacion_final,
                    utf8_decode($student->certificacion_unica)
                ], $d);
                $bandera = !$bandera;
            }
        } else {
            $this->Cell(0, 10, utf8_decode('NO HAY ESTUDIANTES INSCRITOS'), 1, 1, 'C');
        }
        $this->Output("D", $data_course[0]->shortname . ".pdf", true);
    }

    public function print_header_table($data, $tam)
    {

        $this->Ln();
        $this->SetFont('Arial', 'B', 6);
        $this->SetTextColor(0, 0, 0);
        $this->SetTypeCell(['c', 'm', 'c']);
        $this->SetAligns(['C', 'L', 'C']);
        $this->SetWidths($tam);
        // $this->Row(
        //     $data
        // );
        $this->Ln();
    }

    public function imprimir_envios($curso, $data)
    {
        if ($data != NULL) {

            if (count($data) % 2 == 0) {
                $j = 0;
                $k = 0;
                for ($i = 0; $i < count($data) / 2; $i++) {
                    $this->AddPage("P", "letter");
                    $this->SetFont('Arial', 'B', 14);
                    $this->Image("assets/img/img_send_certificate/membrete.jpg", 0, 0, 215.9, 279.4);
                    $this->SetFont('Arial', 'B', 10);

                    foreach ($data as $key => $value) {
                        if ($key == $k + $j) {
                            $this->SetXY(52, 43.2);
                            $this->Cell(132, 8, utf8_decode($value->remitente), 0, 0, 'L');
                            $this->SetXY(52, 54.2);
                            $this->Cell(132, 8, utf8_decode($value->participante), 0, 0, 'L');
                            $this->SetXY(52, 64.6);
                            $this->Cell(132, 8, utf8_decode($value->celular), 0, 0, 'L');
                            $this->SetXY(52, 75.9);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 6, utf8_decode($value->direccion . ' - ' . $value->departamento), 0, 'J');
                            $this->SetXY(52, 91);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 4, utf8_decode($curso[0]->nombre_curso), 0, 'L');
                            $code = 'https://clik.upea.bo/r/cursos-posgrado';
                            $this->Image("http://localhost/generar_qr/qr_generator.php?code=" . $code, 170, 100.5, 17, 17, "png");

                            break;
                        }
                    }

                    foreach ($data as $key => $value) {
                        if ($key ==  $k + $j + 1) {
                            $this->SetXY(52, 184);
                            $this->Cell(132, 8, utf8_decode($value->remitente), 0, 0, 'L');
                            $this->SetXY(52, 195);
                            $this->Cell(132, 8, utf8_decode($value->participante), 0, 0, 'L');
                            $this->SetXY(52, 205);
                            $this->Cell(132, 8, utf8_decode($value->celular), 0, 0, 'L');
                            $this->SetXY(52, 216);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 6, utf8_decode($value->direccion . ' - ' . $value->departamento), 0, 'J');
                            $this->SetXY(52, 232);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 4, utf8_decode($curso[0]->nombre_curso), 0, 'L');
                            break;
                        }
                    }
                    $j++;
                    $k++;
                }
            } else {
                $j = 0;
                $k = 0;
                for ($z = 0; $z < count($data) / 2; $z++) {

                    $this->AddPage("P", "letter");
                    $this->SetFont('Arial', 'B', 14);
                    $this->Image("assets/img/img_send_certificate/membrete.jpg", 0, 0, 215.9, 279.4);
                    $this->SetFont('Arial', 'B', 10);

                    foreach ($data as $key => $value) {
                        if ($key == $k + $j) {
                            $this->SetXY(52, 43.2);
                            $this->Cell(132, 8, utf8_decode($value->remitente), 0, 0, 'L');
                            $this->SetXY(52, 54.2);
                            $this->Cell(132, 8, utf8_decode($value->participante), 0, 0, 'L');
                            $this->SetXY(52, 64.6);
                            $this->Cell(132, 8, utf8_decode($value->celular), 0, 0, 'L');
                            $this->SetXY(52, 75.9);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 6, utf8_decode($value->direccion . ' - ' . $value->departamento), 0, 'J');
                            $this->SetXY(52, 91);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 4, utf8_decode($curso[0]->nombre_curso), 0, 'L');
                            break;
                        }
                    }

                    foreach ($data as $key => $value) {
                        if ($key ==  $k + $j + 1) {
                            $this->SetXY(52, 184);
                            $this->Cell(132, 8, utf8_decode($value->remitente), 0, 0, 'L');
                            $this->SetXY(52, 195);
                            $this->Cell(132, 8, utf8_decode($value->participante), 0, 0, 'L');
                            $this->SetXY(52, 205);
                            $this->Cell(132, 8, utf8_decode($value->celular), 0, 0, 'L');
                            $this->SetXY(52, 216);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 6, utf8_decode($value->direccion . ' - ' . $value->departamento), 0, 'J');
                            $this->SetXY(52, 232);
                            $this->SetFont('Arial', 'B', 9);
                            $this->multiCelda(132, 4, utf8_decode($curso[0]->nombre_curso), 0, 'L');
                            break;
                        }
                    }
                    $j++;
                    $k++;
                }
            }
        } else {
            $this->AddPage("P", "letter");
            $this->SetFont('Arial', '', 9);
            $this->Cell(0, 10, utf8_decode('NO HAY PARTICIPANTE PARA EL ENVÍO'), 1, 1, 'C');
        }
        $this->Output("D", $curso[0]->shortname . ".pdf", true);
    }

    public function printInscritos($data)
    {
        $this->AddPage("P", "letter");
        $this->SetFont('Arial', 'B', 14);
        $this->multiCelda(0, 8,'LISTADO DE INSCRITOS', 0, 'C');
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(10,5,'Nro',1,0,'C');
        $this->Cell(60,5,'NOMBRE',1,0,'C');
        $this->Cell(40,5,'CELULAR',1,0,'C');
        $this->Cell(40,5,'EMAIL',1,0,'C');
        $this->Cell(50,5,'HORA EVENTO',1,0,'C');

        foreach($data as $key => $value){
            $this->SetFont('Arial', '', 9);
            $this->Ln();
            $this->Cell(10,5,$key+1,1,0,'C');
            $this->Cell(60,5,utf8_decode($value->nombre_completo),1,0,'L');
            $this->Cell(40,5,utf8_decode($value->nro_celular),1,0,'C');
            $this->Cell(40,5,utf8_decode($value->correo),1,0,'L');
            $this->Cell(50,5,utf8_decode($value->hora_evento),1,0,'L');
        }
       
        $this->Output("D", "listado.pdf", true);
    }
}
