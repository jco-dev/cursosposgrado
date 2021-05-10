<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ofertas extends CI_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ofertas_model');
	}

	public function index()
	{
		$this->load->view('ofertas/index', null);
	}

	public function cursos()
	{
		$tarjeta = '';
		$cursos = $this->ofertas_model->listado_cursos();
		if ($cursos != NULL) {
			foreach ($cursos as $key => $curso) {
				$this->data['curso'] = $curso;
				$tarjeta .= $this->load->view('ofertas/tarjeta/tarjeta_curso', $this->data, true);
			}
			echo $tarjeta;
		} else {
			echo "No existen cursos";
		}
	}
}
