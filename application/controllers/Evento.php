<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('America/La_Paz');
require_once APPPATH . '/controllers/Reportes/ImprimirCertificado.php';

class Evento extends PSG_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('evento_model');
    }

    public function index()
    {
        $this->data['votacion'] = $this->evento_model->listar_cursos_sorteo();
        $this->data['votacion_horario'] = $this->evento_model->listar_horario_votacion();
        $this->templater->view('evento/index', $this->data);
    }

    public function printInscritos()
    {
        $data = $this->evento_model->listar_inscritos();
        $print = new ImprimirCertificado();
        $print->printInscritos($data);
    }

}
