<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporte_estudiantes_excel extends Spreadsheet
{
    public function __construct()
    {
        parent::__construct();
    }

    public function lista_estudiantes($data, $curso)
    {
        $this->setActiveSheetIndex(0);
        // set Header
        $this->getActiveSheet()->SetCellValue('A1', 'username');
        $this->getActiveSheet()->SetCellValue('B1', 'password');
        $this->getActiveSheet()->SetCellValue('C1', 'firstname');
        $this->getActiveSheet()->SetCellValue('D1', 'lastname');
        $this->getActiveSheet()->SetCellValue('E1', 'email');
        $this->getActiveSheet()->SetCellValue('F1', 'course1');

        $contador = 2;
        if (count($data) != 0) {
            foreach ($data as $value) {
                $this->getActiveSheet()->setCellValue("A" . $contador, strtoupper(explode(" ", $value->nombre)[0]) . "_" . $value->ci);
                $this->getActiveSheet()->setCellValue("B" . $contador, $value->fecha_nacimiento);
                $this->getActiveSheet()->setCellValue("C" . $contador, $value->nombre);
                $this->getActiveSheet()->setCellValue("D" . $contador, $value->paterno . " " . $value->materno);
                $this->getActiveSheet()->setCellValue("E" . $contador, $value->correo);
                $this->getActiveSheet()->setCellValue("F" . $contador, $curso);
                $contador++;
            }
        }

        $hoy = date("Ymdhi");
        $filename = $curso . str_replace(array(' ', '|'), '_', $hoy);
        $writer = new Xlsx($this);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');
    }
}
