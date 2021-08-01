<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporte_economico_excel extends Spreadsheet
{
    public function __construct()
    {
        parent::__construct();
    }

    public function reporte_economico_curo($data_course, $data_students, $total_inscrito, $total_preinscrito)
    {
        $this->setActiveSheetIndex(0);
        $this->getActiveSheet()->setTitle($data_course[0]->shortname);
			
        $this->getActiveSheet()->mergeCells('A4:J4')->setCellValue("A4", $data_course[0]->nombre_curso);
		// Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 12));
        $this->getActiveSheet()->getStyle('A4:J4')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
			
        $this->getActiveSheet()->setCellValue("A5", 'Fecha Inicio:'.$data_course[0]->fecha_inicial);
        // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 12,5));
        $this->getActiveSheet()->getStyle('A5')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			
			
		$this->getActiveSheet()->setCellValue("A6", 'Fecha Final: ' . $data_course[0]->fecha_final);
        // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 12,5));
        $this->getActiveSheet()->getStyle('A6')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			
			
		$this->getActiveSheet()->setCellValue("A7", 'Fecha Certificación: ' . $data_course[0]->fecha_certificacion);
        // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 12,5));
        $this->getActiveSheet()->getStyle('A7')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			
		$this->getActiveSheet()->setCellValue("A8", 'Carga Horaria: ' . $data_course[0]->carga_horaria);
        // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 12,5));
        $this->getActiveSheet()->getStyle('A8')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			
		
		$this->setActiveSheetIndex(0)->mergeCells('A11:A12')->setCellValue('A11', 'N°');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 9));
        $this->getActiveSheet()->getStyle('A11:A12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
			
		$this->setActiveSheetIndex(0)->mergeCells('B11:D11')->setCellValue('B11', 'NÓMINA DE ESTUDIANTES');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 9));
        $this->getActiveSheet()->getStyle('B11:D11')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
		
		$this->setActiveSheetIndex(0)->setCellValue('B12', 'CI');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('B12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
			
		$this->setActiveSheetIndex(0)->setCellValue('C12', 'NOMBRES Y APELLIDOS');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('C12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
		$this->setActiveSheetIndex(0)->setCellValue('D12', 'TIPO PAGO');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('D12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
		$this->setActiveSheetIndex(0)->mergeCells('E11:E12')->setCellValue('E11', 'CELULAR');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('E11:E12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $this->setActiveSheetIndex(0)->mergeCells('F11:F12')->setCellValue('F11', 'ID TRANSACCIÓN');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('F11:F12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
			
		$this->setActiveSheetIndex(0)->mergeCells('G11:G12')->setCellValue('G11', 'MONTO PAGO (Bs)');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('G11:G12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
		$this->setActiveSheetIndex(0)->mergeCells('H11:H12')->setCellValue('H11', 'FECHA PAGO');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('H11:H12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
		$this->setActiveSheetIndex(0)->mergeCells('I11:I12')->setCellValue('I11', 'FECHA REGISTRO');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('I11:I12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
		$this->setActiveSheetIndex(0)->mergeCells('J11:J12')->setCellValue('J11', 'ESTADO');
		 // Fuente de la primera fila en negrita
        $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 8));
        $this->getActiveSheet()->getStyle('J11:J12')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
        $this->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $this->getActiveSheet()->getColumnDimension('B')->setWidth(14);
        $this->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $this->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $this->getActiveSheet()->getColumnDimension('F')->setWidth(19);
        $this->getActiveSheet()->getColumnDimension('G')->setWidth(16);
        $this->getActiveSheet()->getColumnDimension('H')->setWidth(14);
        $this->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $this->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        //$this->getActiveSheet()->getStyle("A" . $contador . ":H" . $contador)->getFont()->setBold(true);
	
		$contador = 13; 
		$x=1;

        if($data_students != null){
            foreach($data_students as $value)
            {
                $this->getActiveSheet()->setCellValue("A" . $contador, ($x++));
                $this->getActiveSheet()->setCellValue("B" . $contador, $value->ci);           
                $this->getActiveSheet()->setCellValue("C" . $contador, $value->nombre_completo);           
                $this->getActiveSheet()->setCellValue("D" . $contador, $value->tipo_pago);
                $this->getActiveSheet()->setCellValue("E" . $contador, $value->celular);           
                $this->getActiveSheet()->setCellValue("F" . $contador, $value->id_transaccion);           
                $this->getActiveSheet()->setCellValue("G" . $contador, $value->monto_pago); 
                $this->getActiveSheet()->setCellValue("H" . $contador, $value->fecha_pago); 
                $this->getActiveSheet()->setCellValue("I" . $contador, $value->fecha_preinscripcion); 
                $this->getActiveSheet()->setCellValue("J" . $contador, $value->estado);          
                $contador++;
            }
            // PONER LOS TOTALES
            $this->getActiveSheet()->setCellValue("A" . intval($contador+1), "TOTAL INSCRITO: Bs. " . intval($total_inscrito));
            $this->getActiveSheet()->setCellValue("A" . intval($contador+2), "TOTAL PREINSCRITO: Bs. " . intval($total_preinscrito)); 

        }else{            
            $this->setActiveSheetIndex(0)->mergeCells('A13:J13')->setCellValue('A13', 'NO HAY ESTUDIANTES INSCRITOS EN EL CURSO');
            $boldArray = array('font' => array('bold' => true,'name' => 'Arial','size' => 9));
            $this->getActiveSheet()->getStyle('A13:J13')->applyFromArray($boldArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        $rango="A11:J".intval($contador-1);
        $styleArray = [
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        'color' => ['argb' => '000000'],]]    
        ];
        $this->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
        $hoy = date("Ymd");
        $filename = 'Reporte_economico_' . $data_course[0]->shortname;
        $writer = new Xlsx($this);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
		ob_end_clean();
        $writer->save('php://output');

    }

}