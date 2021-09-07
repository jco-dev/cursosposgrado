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
            $this->Image("assets/img/img_send_certificate/fondo.jpg", 0, 0, 215.9, 280.5);

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
        header('Content-Type: application/pdf');
        $pdf = new FPDF($orientation='P',$unit='mm', array(55.6,115));
        $pdf->AddPage();

        
        $pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
        
        $pdf->Image(base_url('assets/img/img_send_certificate/cursos-logo.jpg'), 15,2,25,8);
        $pdf->Ln(2);
        $pdf->setX(3);
        $pdf->SetFont('Arial','',5);
        $pdf->Cell(49.8,2, utf8_decode("Telefóno: 70648629"), 0, 1, "C");
        $pdf->SetFont('Arial','',5);
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Dirección:  Av. Sucre Bloque 'A' - Zona Villa Esperanza"), 0, 1, "C");
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Tercer Piso del Edificio  Emblemático de la UPEA."), 0, 1, "C");
        $pdf->setX(3);
        $pdf->Cell(49.8,3, utf8_decode("*********************************************************************"), 0, 1, "C");

        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Remitente: CURSOS POSGRADO UPEA"), 0, 1, "L");
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("ID inscripción: 021012"), 0, 1, "L");
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Fecha: 12/12/2021"), 0, 1, "L");
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Método de pago: PAGO EN OFICINA"), 0, 1, "L");
        
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("C.I.: 9248587 LP"), 0, 1, "L");
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Cliente: JUAN CARLOS CONDORI ZAPANA"), 0, 1, "L");

        $pdf->setX(3);
        $pdf->Cell(49.8,3, utf8_decode("*********************************************************************"), 0, 1, "C");
        $data_header_table = array(utf8_decode('Nº'), 'CURSO', 'PAGO');
        $lenght = array(5, 34, 9);
        $pdf->SetFont('Arial', 'B', 5);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetTypeCell(['c', 'm', 'c']);
        $pdf->SetAligns(['C', 'J', 'C']);
        $pdf->SetWidths($lenght);
        $pdf->setX(4);
        $pdf->Row(
            $data_header_table
        );

        // Imprimir datos del reporte
        $data_table = array(utf8_decode('1'), utf8_decode('GESTIÓN Y ADMINISTRACIÓN DE HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL 1RA. VERSIÓN'), 'Bs.'. 100);
        $pdf->setX(4);
        $pdf->Row(
            $data_table
        );

        // Imprimir total
        $data_total = array(utf8_decode('TOTAL'), 'Bs.'. 100);
        $lenght1 = array(39, 9);
        $pdf->SetFont('Arial', 'B', 5);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetTypeCell(['c', 'c']);
        $pdf->SetAligns(['C', 'C']);
        $pdf->SetWidths($lenght1);
        $pdf->setX(4);
        $pdf->Row(
            $data_total
        );

        $data_total = array(utf8_decode('SALDO'), 'Bs.'. 0);
        $lenght1 = array(39, 9);
        $pdf->SetFont('Arial', 'B', 5);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetTypeCell(['c', 'c']);
        $pdf->SetAligns(['C', 'C']);
        $pdf->SetWidths($lenght1);
        $pdf->setX(4);
        $pdf->Row(
            $data_total
        );

        // letras
        $pdf->setX(3);
        $pdf->Cell(49.8,3, utf8_decode("Son: " . $this->numberToLetras(100)) , 0, 1, "L");
        $pdf->setX(3);
        $pdf->Cell(49.8,2, utf8_decode("Usuario: JUANCA92"), 0, 1, "L");

        $pdf->Image("http://localhost/generar_qr/qr_generator.php?code=12345fsdfsafdsafdsaf", 16, $pdf->GetY(),25,25, "png");
        $pdf->SetY($pdf->GetY()+25);
        $pdf->Ln();
        $pdf->setX(3);
        $pdf->Cell(49.8,3, utf8_decode("        **** GRACIAS POR INSCRIBIRSE AL CURSO ****") , 0, 1, "L");
        $pdf->Output("D", "factura.pdf", true);
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
            $this->Image("assets/img/img_send_certificate/fondo.jpg", 0, 0, 215.9, 279.4);

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
            if ($tipo == "SI") {
                $this->Cell(15, 18, utf8_decode("A: "), 0, 1, 'C');
            }

            // TIPO DE PARTICIPACION
            $this->SetTextColor(0, 0, 0);
            $this->SetXY($datos_curso[0]->posx_tipo_participacion, $datos_curso[0]->posy_tipo_participacion);
            $this->SetFont('AusterRounded-Light', '', $datos_curso[0]->tamano_texto);
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
            $this->AddFont('BebasNeue-Regular', '', 'BebasNeue-Regular.php');
            $this->SetFont('BebasNeue-Regular', '', $datos_curso[0]->tamano_subtitulo);
            $this->MultiCell(186, 13, utf8_decode($cur['nombre_curso']), 0, 'C');

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
            $this->SetFont('AusterRounded-Light', '', $datos_curso[0]->tamano_texto);
            $this->multiCelda(128, 8, utf8_decode("Realizado desde el $dia de $mes hasta el $fecha_final, por la Dirección de Posgrado de la Universidad Pública de El Alto, con una carga horaria de $carga_horaria horas académicas."), 0, 'J');
            $fecha_certificacion = "El Alto, " . strtolower(fecha_literal($cur['fecha_certificacion']));
            $this->SetX($datos_curso[0]->posx_bloque_texto);
            $this->multiCelda(132, 8, utf8_decode(($fecha_certificacion)) . "     ", 0, 'R');

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
    function numberToLetras($xcifra)
    {
        $xarray = array(0 => "Cero",
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
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
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
                                }
                                else {
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
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO $xdecimales/100 Bs.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN $xdecimales/100 Bs. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " $xdecimales/100 Bs. "; //
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
}
