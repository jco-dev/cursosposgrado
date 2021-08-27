<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "/libraries/Fpdf_psg.php";

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

            $valor = ['id_inscripcion_curso', 'nombre_estudiante', 'calificacion_final', 'tipo_participacion', 'nombre_curso', 'fecha_inicial', 'fecha_final', 'carga_horaria', 'imagen_personalizado', 'posx_imagen_personalizado', 'posy_imagen_personalizado','color_nombre_curso', 'fecha_certificacion','tipo'];

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
                $this->Cell(190, 11, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso especializado de:"), 0, 1, '');
            } elseif ($est['tipo_participacion'] == "ORGANIZADOR") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso especializado de:"), 0, 1, '');
            } else {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado  del curso especializado de:"), 0, 1, '');
            }

            // titulo del curso
            if($est['color_nombre_curso'] == ""){
                $color_s[0] = 0;
                $color_s[1] = 0;
                $color_s[2] = 0;
            }else{
                $color_s = explode(", ", $est['color_nombre_curso']);
            }

            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_curso, $datos_curso[0]->posy_nombre_curso);
            $this->AddFont('BookmanOldStyle-Bold', '', 'BOOKOSB.php');
            $this->SetFont('BookmanOldStyle-Bold', '', $datos_curso[0]->tamano_subtitulo);
            $this->MultiCell(214, 9, utf8_decode($est['nombre_curso']), 0, 'C');

            //IMPRIMIR SUBITULO
            $posy_bt = intval($datos_curso[0]->posy_bloque_texto);
            if($est['tipo'] == "CURSO"){
                if($datos_curso[0]->imprimir_subtitulo == "1"){
                    $this->SetX($datos_curso[0]->posx_nombre_curso);
                    $this->SetFont('Arial', 'B', 13);
                    $this->Cell(214, 5,utf8_decode($datos_curso[0]->subtitulo), 0, 1, 'C');
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
            if($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null)
            {
                $this->Image($est['imagen_personalizado'], $est['posx_imagen_personalizado'] , $est['posy_imagen_personalizado']);
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
            return "Por haber APROBADO SATISFACTORIAMENTE el curso: ";
        } else {
            return "Por haber PARTICIPADO del curso: ";
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
    public function imprimir_todos($datos_curso = null, $datos_estudiante = null, $value)
    {
        // var_dump($datos_estudiante);
        $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
        $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);

        foreach ($datos_estudiante as $estudiante) {

            $valor = ['id_inscripcion_curso', 'nombre_estudiante', 'calificacion_final', 'tipo_participacion', 'nombre_curso', 'fecha_inicial', 'fecha_final', 'carga_horaria', 'imagen_personalizado', 'posx_imagen_personalizado', 'posy_imagen_personalizado','color_nombre_curso', 'fecha_certificacion','tipo'];

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
                $this->Cell(190, 11, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso especializado de:"), 0, 1, '');
            } elseif ($est['tipo_participacion'] == "ORGANIZADOR") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso especializado de:"), 0, 1, '');
            } else {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
                $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
                $this->Cell(190, 11, utf8_decode("Por haber participado  del curso especializado de:"), 0, 1, '');
            }

            // titulo del curso
            if($est['color_nombre_curso'] == ""){
                $color_s[0] = 0;
                $color_s[1] = 0;
                $color_s[2] = 0;
            }else{
                $color_s = explode(", ", $est['color_nombre_curso']);
            }

            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_curso, $datos_curso[0]->posy_nombre_curso);
            $this->AddFont('BookmanOldStyle-Bold', '', 'BOOKOSB.php');
            $this->SetFont('BookmanOldStyle-Bold', '', $datos_curso[0]->tamano_subtitulo);
            $this->MultiCell(214, 9, utf8_decode($est['nombre_curso']), 0, 'C');

            //IMPRIMIR SUBITULO
            $posy_bt = intval($datos_curso[0]->posy_bloque_texto);
            if($est['tipo'] == "CURSO"){
                if($datos_curso[0]->imprimir_subtitulo == "1"){
                    $this->SetX($datos_curso[0]->posx_nombre_curso);
                    $this->SetFont('Arial', 'B', 13);
                    $this->Cell(214, 5,utf8_decode($datos_curso[0]->subtitulo), 0, 1, 'C');
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
            if($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null)
            {
                $this->Image($est['imagen_personalizado'], $est['posx_imagen_personalizado'] , $est['posy_imagen_personalizado']);
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


        $name = "doc_" . date('Y_m_d_H_s_i') . ".pdf";
        $this->Output("F", "assets/pdf_temp/$name");
        echo "pdf_temp/$name";
    }

    // IMPRIMIR TODOS LOS CERTIFICADOS DEL CURSO VERTICAL
    public function imprimir_todos_vertical($datos_curso = null, $datos_estudiante = null, $value)
    {
        // var_dump($datos_estudiante);
        $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
        $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);

        foreach ($datos_estudiante as $estudiante) {

            $valor = ['id_inscripcion_curso', 'nombre_estudiante', 'calificacion_final', 'tipo_participacion', 'nombre_curso', 'fecha_inicial', 'fecha_final', 'carga_horaria', 'imagen_personalizado', 'posx_imagen_personalizado', 'posy_imagen_personalizado','color_nombre_curso', 'fecha_certificacion','tipo'];

            $est = array();
           
            for ($i = 0; $i < count($estudiante); $i++) {

                $est[$valor[$i]] = $estudiante[$i];
            }

            $this->AddPage("P", "letter");

            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                $this->Image($datos_curso[0]->imagen_curso, 0, 0, 215.9, 279.4);
            }
            $this->Image("assets\img\img_send_certificate/fondo.jpg", 0, 0, 215.9, 279.4);

            $this->AddFont('AusterRounded-Light', '', 'AusterRounded-Light.php');
            $this->SetFont('AusterRounded-Light', '', 15);
            $this->SetXY(68,51);
            $this->Cell(70, 7, "Otorga el Presente: ", 0, 1, 'L');

            // CERTIFICADO
            $this->AddFont('BebasNeue-Regular', '', 'BebasNeue-Regular.php');
            $this->SetFont('BebasNeue-Regular', '', 60);
            $this->SetXY(10,65);
            $this->Cell(197, 20, "CERTIFICADO", 0, 1, 'C');


            // Nombre estudiante
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_participante, $datos_curso[0]->posy_nombre_participante);
            $this->AddFont('PalaceScriptMT', '', 'PalaceScriptMT.php');
            $this->SetFont('PalaceScriptMT', '', $datos_curso[0]->tamano_titulo + 15);
            if ($value == "SI") {
                $this->Cell(15, 18, utf8_decode("A: "), 0, 1, 'C');
            }

            $this->AddFont('Roboto-Black', '', 'Roboto-Black.php');
            $this->SetFont('Roboto-Black', '', $datos_curso[0]->tamano_titulo);
            $this->SetXY($datos_curso[0]->posx_nombre_participante + 15, $datos_curso[0]->posy_nombre_participante);
            $this->Cell(171, 18, utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($est['nombre_estudiante'])), MB_CASE_UPPER)), 0, 1, 'C');

            // TIPO PARTICIPACION
            
            $this->SetFont('AusterRounded-Light', '', $datos_curso[0]->tamano_texto);
            $this->SetTextColor(0, 0, 0);
            if ($est['tipo_participacion'] == "PARTICIPANTE") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->Cell(186, 11, utf8_decode($this->verificar_aprobacion($datos_curso[0]->nota_aprobacion, $est['calificacion_final'])), 0, 1, '');
            } elseif ($est['tipo_participacion'] == "EXPOSITOR") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->Cell(186, 11, utf8_decode("Por haber participado en calidad de EXPOSITOR del curso especializado de:"), 0, 1, '');
            } elseif ($est['tipo_participacion'] == "ORGANIZADOR") {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->Cell(186, 11, utf8_decode("Por haber participado en calidad de ORGANIZADOR del curso especializado de:"), 0, 1, '');
            } else {
                $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
                $this->Cell(186, 11, utf8_decode("Por haber participado  del curso especializado de:"), 0, 1, '');
            }

            // titulo del curso
            if($est['color_nombre_curso'] == ""){
                $color_s[0] = 0;
                $color_s[1] = 0;
                $color_s[2] = 0;
            }else{
                $color_s = explode(", ", $est['color_nombre_curso']);
            }

            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_curso, $datos_curso[0]->posy_nombre_curso);
            $this->AddFont('BebasNeue-Regular', '', 'BebasNeue-Regular.php');
            $this->SetFont('BebasNeue-Regular', '', $datos_curso[0]->tamano_subtitulo);
            $this->MultiCell(186, 13, utf8_decode($est['nombre_curso']), 0, 'C');

            //IMPRIMIR SUBITULO
            $posy_bt = intval($datos_curso[0]->posy_bloque_texto);
            if($est['tipo'] == "CURSO"){
                if($datos_curso[0]->imprimir_subtitulo == "1"){
                    $this->SetX($datos_curso[0]->posx_nombre_curso);
                    $this->SetFont('AusterRounded-Light', '', 13);
                    $this->Cell(197, 5,utf8_decode($datos_curso[0]->subtitulo), 0, 1, 'C');
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
            $this->SetFont('AusterRounded-Light', '', $datos_curso[0]->tamano_texto);
            $this->multiCelda(128, 8, utf8_decode("Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de $carga_horaria horas académicas."), 0, 'J');
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($est['fecha_certificacion']));
            $this->SetX($datos_curso[0]->posx_bloque_texto);
            $this->multiCelda(132, 8, utf8_decode(($fecha_certificacion)) . "     ", 0, 'R');

            // imagen personalizado curso
            if($est['imagen_personalizado'] != "" || $est['imagen_personalizado'] != null)
            {
                $this->Image($est['imagen_personalizado'], $est['posx_imagen_personalizado'] , $est['posy_imagen_personalizado']);
            }

            //qr
            $code = md5('CERTIFICADO_' . $est['id_inscripcion_curso']);
            $this->Image("http://localhost/generar_qr/qr_generator.php?code=" . $code, $datos_curso[0]->posx_qr, $datos_curso[0]->posy_qr, 36, 36, "png");            
            // texto de verificacion qr
            $this->SetXY(intval($datos_curso[0]->posx_qr), intval($datos_curso[0]->posy_qr) + 36);
            $this->SetFont('AusterRounded-Light', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->MultiCell(36, 3.5, utf8_decode("Código QR de verificación del certificado"), 0, "C");
            
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

    public function imprimir_blanco($datos = null, $datos_curso = null, $tipo)
    {
        $valor = ['nombre_curso', 'fecha_inicial', 'fecha_final', 'carga_horaria', 'imagen_personalizado', 'posx_imagen_personalizado', 'posy_imagen_personalizado', 'color_nombre_curso', 'fecha_certificacion', 'tipo_participacion','tipo'];

        foreach ($datos as $key => $curso) {
            $cur = array();
            for ($i = 0; $i < count($curso); $i++) {

                $cur[$valor[$i]] = $curso[$i];
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
            if ($tipo == "SI") {
                $this->Cell(15, 18, utf8_decode("A: "), 0, 1, 'C');
            }

            // TIPO DE PARTICIPACION
            $this->SetTextColor(0, 0, 0);
            $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
            $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
            $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
            $this->Cell(190, 11, utf8_decode($this->verificar_tipo_participacion($cur['tipo_participacion'])), 0, 1, '');

            // titulo del curso
            if($cur['color_nombre_curso'] == ""){
                $color_s[0] = 0;
                $color_s[1] = 0;
                $color_s[2] = 0;
            }else{
                $color_s = explode(", ", $cur['color_nombre_curso']);
            }

            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_curso, $datos_curso[0]->posy_nombre_curso);
            $this->AddFont('BookmanOldStyle-Bold', '', 'BOOKOSB.php');
            $this->SetFont('BookmanOldStyle-Bold', '', $datos_curso[0]->tamano_subtitulo);
            $this->multiCelda(214, 9, utf8_decode($cur['nombre_curso']), 0, 'C');
            //IMPRIMIR SUBITULO
            $posy_bt = intval($datos_curso[0]->posy_bloque_texto);
            if ($cur['tipo'] == "CURSO") {
                if ($datos_curso[0]->imprimir_subtitulo == "1") {
                    $this->SetX($datos_curso[0]->posx_nombre_curso);
                    $this->SetFont('Arial', 'B', 13);
                    $this->Cell(214, 5, utf8_decode($datos_curso[0]->subtitulo), 0, 1, 'C');
                    $posy_bt = $posy_bt + 4;
                }
            }

            // imagen personalizado curso
            if ($cur['imagen_personalizado'] != "" || $cur['imagen_personalizado'] != null) {
                $this->Image($cur['imagen_personalizado'], $cur['posx_imagen_personalizado'], $cur['posy_imagen_personalizado']);
            }

            // bloque de texto
            $this->SetTextColor(0, 0, 0);
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $posy_bt);
            $dia = date("d", strtotime($cur['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($cur['fecha_inicial'])));
            $fecha_final = fecha_literal($cur['fecha_final']);
            $carga_horaria = $cur['carga_horaria'];
            $this->AddFont('OpenSans-SemiBold', '', 'OpenSans-SemiBold.php');
            $this->SetFont('OpenSans-SemiBold', '', $datos_curso[0]->tamano_texto);
            $this->multiCelda(210, 8, utf8_decode("Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de $carga_horaria horas académicas."), 0, 'J');
            $fecha_certificacion = "El Alto, " . fecha_literal($cur['fecha_certificacion']);
            $this->SetX($datos_curso[0]->posx_bloque_texto);
            $this->multiCelda(210, 8, utf8_decode($fecha_certificacion) . "     ", 0, 'R');
        }

        echo base64_encode($this->Output('S'));
    }

    public function imprimir_blanco_vertical($datos = null, $datos_curso = null, $tipo)
    {
        $valor = ['nombre_curso', 'fecha_inicial', 'fecha_final', 'carga_horaria', 'imagen_personalizado', 'posx_imagen_personalizado', 'posy_imagen_personalizado', 'color_nombre_curso', 'fecha_certificacion', 'tipo_participacion','tipo'];

        foreach ($datos as $key => $curso) {
            $cur = array();
            for ($i = 0; $i < count($curso); $i++) {

                $cur[$valor[$i]] = $curso[$i];
            }

            $this->AddPage("P", "letter");
            if ($datos_curso[0]->imagen_curso != "" || $datos_curso[0]->imagen_curso != NULL) {
                $this->Image($datos_curso[0]->imagen_curso, 0, 0, 215.9, 279.4);
            }

            // CERTIFICADO
            $this->AddFont('Roboto-Black', '', 'Roboto-Black.php');
            $this->SetFont('Roboto-Black', '', 39);
            $this->SetXY(10,65);
            $this->Cell(197, 18, "CERTIFICADO", 0, 1, 'C');

            // Nombre estudiante
            $color_p = explode(", ", $datos_curso[0]->color_nombre_participante);
            $this->SetTextColor($color_p[0], $color_p[1], $color_p[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_participante, $datos_curso[0]->posy_nombre_participante);
            $this->AddFont('PalaceScriptMT', '', 'PalaceScriptMT.php');
            $this->SetFont('PalaceScriptMT', '', $datos_curso[0]->tamano_titulo + 15);
            if ($tipo == "SI") {
                $this->Cell(15, 18, utf8_decode("A: "), 0, 1, 'C');
            }

            // TIPO DE PARTICIPACION
            $this->SetTextColor(0, 0, 0);
            $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
            $this->AddFont('Calibri-Light', '', 'Calibri-Light.php');
            $this->SetFont('Calibri-Light', '', $datos_curso[0]->tamano_texto);
            $this->Cell(197, 11, utf8_decode($this->verificar_tipo_participacion($cur['tipo_participacion'])), 0, 1, '');

            // titulo del curso
            if($cur['color_nombre_curso'] == ""){
                $color_s[0] = 0;
                $color_s[1] = 0;
                $color_s[2] = 0;
            }else{
                $color_s = explode(", ", $cur['color_nombre_curso']);
            }

            $this->SetTextColor($color_s[0], $color_s[1], $color_s[2]);
            $this->SetXY($datos_curso[0]->posx_nombre_curso, $datos_curso[0]->posy_nombre_curso);
            $this->AddFont('Roboto-Black', '', 'Roboto-Black.php');
            $this->SetFont('Roboto-Black', '', $datos_curso[0]->tamano_subtitulo);
            $this->MultiCell(197, 9, utf8_decode($cur['nombre_curso']), 0, 'C');

            //IMPRIMIR SUBITULO
            $posy_bt = intval($datos_curso[0]->posy_bloque_texto);
            if($cur['tipo'] == "CURSO"){
                if($datos_curso[0]->imprimir_subtitulo == "1"){
                    $this->SetX($datos_curso[0]->posx_nombre_curso);
                    $this->SetFont('Calibri-Light', '', 13);
                    $this->Cell(197, 5,utf8_decode($datos_curso[0]->subtitulo), 0, 1, 'C');
                    $posy_bt = $posy_bt + 4;
                }
            }

            //bloque de texto
            $this->SetTextColor(0, 0, 0);
            $this->SetXY($datos_curso[0]->posx_bloque_texto, $posy_bt);
            $dia = date("d", strtotime($cur['fecha_inicial']));
            $mes = $this->mes_literal(date("m", strtotime($cur['fecha_inicial'])));
            $fecha_final = strtolower(fecha_literal($cur['fecha_final']));
            $carga_horaria = $cur['carga_horaria'];
            $this->SetFont('Calibri-Light', '', $datos_curso[0]->tamano_texto);
            $this->multiCelda(197, 8, utf8_decode("Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de $carga_horaria horas académicas."), 0, 'J');
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($cur['fecha_certificacion']));
            $this->SetX($datos_curso[0]->posx_bloque_texto);
            $this->multiCelda(197, 8, utf8_decode(($fecha_certificacion)) . "     ", 0, 'R');

            // imagen personalizado curso
            if($cur['imagen_personalizado'] != "" || $cur['imagen_personalizado'] != null)
            {
                $this->Image($cur['imagen_personalizado'], $cur['posx_imagen_personalizado'] , $cur['posy_imagen_personalizado']);
            }
        }

        echo base64_encode($this->Output('S'));
    }

    public function verificar_tipo_participacion($tipo)
    {
        if($tipo == "APROBADO"){
            return "Por haber APROBADO SATISFACTORIAMENTE el curso: ";
        }elseif($tipo == "EXPOSITOR")
        {
            return "Por haber participado en calidad de EXPOSITOR del curso:";
        }elseif($tipo == "ORGANIZADOR"){
            return "Por haber participado en calidad de ORGANIZADOR del curso:";
        }elseif($tipo == "PARTICIPADO"){
            return "Por haber PARTICIPADO del curso: ";
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
}
