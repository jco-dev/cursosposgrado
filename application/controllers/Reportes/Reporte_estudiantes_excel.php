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

        $file = new Spreadsheet();

        $active_sheet = $file->getActiveSheet();
        $active_sheet->setCellValue('A1', 'username');
        $active_sheet->setCellValue('B1', 'password');
        $active_sheet->setCellValue('C1', 'firstname');
        $active_sheet->setCellValue('D1', 'lastname');
        $active_sheet->setCellValue('E1', 'email');
        $active_sheet->setCellValue('F1', 'course1');



        $contador = 2;
        if (count($data) != 0) {
            foreach ($data as $value) {
                $active_sheet->setCellValue("A" . $contador, strtolower(explode(" ", trim($value->nombre))[0]) . $value->celular);
                $active_sheet->setCellValue("B" . $contador, $value->celular ."_Bolivia");
                $active_sheet->setCellValue("C" . $contador, $value->nombre);
                $active_sheet->setCellValue("D" . $contador, $value->paterno . " " . $value->materno);
                $active_sheet->setCellValue("E" . $contador, $value->correo);
                $active_sheet->setCellValue("F" . $contador, $curso);
                $contador++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, "Csv");

        $file_name = $curso ."_".time() . '.' . 'csv';

        $writer->save($file_name);

        header('Content-Type: application/x-www-form-urlencoded');

        header('Content-Transfer-Encoding: Binary');

        header("Content-disposition: attachment; filename=\"" . $file_name . "\"");

        readfile($file_name);

        unlink($file_name);

        exit;

    }

    public function lista_estudiantes_contacto($data, $curso)
    {
    
        $file = new Spreadsheet();

        $active_sheet = $file->getActiveSheet();
        $active_sheet->setCellValue('A1', 'nombres');
        $active_sheet->setCellValue('B1', 'paterno');
        $active_sheet->setCellValue('C1', 'materno');
        $active_sheet->setCellValue('D1', 'celular');
        $active_sheet->setCellValue('E1', 'email');
        $active_sheet->setCellValue('F1', 'curso');



        $contador = 2;
        if (count($data) != 0) {
            foreach ($data as $value) {
                $active_sheet->setCellValue("A" . $contador, $value->nombre);
                $active_sheet->setCellValue("B" . $contador, $value->paterno);
                $active_sheet->setCellValue("C" . $contador, $value->materno);
                $active_sheet->setCellValue("D" . $contador, $value->celular);
                $active_sheet->setCellValue("E" . $contador, $value->correo);
                $active_sheet->setCellValue("F" . $contador, $curso);
                $contador++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, "Csv");

        $file_name = $curso ."_".time() . '.' . 'csv';

        $writer->save($file_name);

        header('Content-Type: application/x-www-form-urlencoded');

        header('Content-Transfer-Encoding: Binary');

        header("Content-disposition: attachment; filename=\"" . $file_name . "\"");

        readfile($file_name);

        unlink($file_name);

        exit;

    }
}
