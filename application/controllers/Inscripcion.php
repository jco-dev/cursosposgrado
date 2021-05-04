<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');
require_once APPPATH . '/controllers/Reportes/ImprimirCertificado.php';

class Inscripcion extends PSG_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->templater->view('inscripcion/index', $this->data);
    }

    public function imprimir_recibo()
    {
        $datos = array(
            'titulo' => "CURSO PLATAFORMA MOODLE",
            'fecha' => date('d-m-Y'),
            'numero' => '002',
            'importe' => '100 Bs.',
            'descripcion' => "PAGO DEL CURSO DE PLATAFORMAS DE MOODLE",
            'recibido_por' => "WALTER PACO SILES",
            'entregado_a' => "LIC TANTOS",
            'a_favor_de' => "JUAN CARLOS CONDORI"
        );

        $rep = new ImprimirCertificado();
        $rep->imprimir_recibo($datos);
    }
}
