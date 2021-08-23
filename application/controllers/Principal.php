<?php defined('BASEPATH') or exit('No direct script access allowed');

class Principal extends PSG_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cursos_model');
        $this->load->model('participantes_model');
    }

    public function index()
    {
        $this->data['total_course'] = $this->cursos_model->total_course();
        $this->data['total_cursos'] = $this->cursos_model->total_cursos();
        $this->data['total_user'] = $this->participantes_model->total_user();
        $this->data['total_participantes'] = $this->participantes_model->total_participantes();
        $this->data['estudiantes'] = $this->participantes_model->get_estudents();
        $this->templater->view('principal/index', $this->data);
    }
}
