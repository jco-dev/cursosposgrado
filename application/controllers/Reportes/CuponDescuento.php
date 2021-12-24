<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "/libraries/Fpdf_psg.php";

class CuponDescuento extends Fpdf_psg
{

    public function imprimir_cupon($cupon, $participante)
    {

        $this->AddPage('P', 'letter');
        $this->SetFont('Arial', 'B', 12);
        if (file_exists('assets/img/img_send_certificate/fondo-cupon.jpg')) {
            $this->Image('assets/img/img_send_certificate/fondo-cupon.jpg', 0, 0, 215.9, 279.4);
        }
        $this->SetXY(7, 182.8);
        $this->Cell(0, 5, utf8_decode("PARTICIPANTE: " . $participante[0]->nombre . ' ' . $participante[0]->paterno . ' ' . $participante[0]->materno), 0, 1, 'C');
        $this->SetX(7);
        $this->Cell(0, 5, utf8_decode("Válido hasta: 31/12/2022"), 0, 1, 'C');
        $this->Image('https://chart.googleapis.com/chart?chs=180x180&chld=L&cht=qr&chl=' . $cupon[0]->numero_cupon . '&.png', 85, 195);
        $this->SetY($this->GetY() + 45);
        $this->Cell(0, 5, utf8_decode("CÓDIGO: " . $cupon[0]->numero_cupon), 0, 1, 'C');
        echo base64_encode($this->Output('S'));
    }
}
