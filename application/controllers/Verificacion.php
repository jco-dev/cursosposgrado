<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verificacion extends CI_Controller
{
	protected $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('verificar_model');
	}

	public function index()
	{
		if ($this->input->get('id')) {
			$resultado = $this->verificar_model->verificar_certificado($this->input->get('id'));
			if (empty($resultado['code'])) {
				$this->data['id'] = $this->input->get('id');
				$this->data['certificado'] = $resultado;
				$this->templater->view('verificacion/certificado', $this->data, 'base_verificacion');
			} else {
				$this->data['id'] = $this->input->get('id');
				$this->templater->view('verificacion/certificado_erroneo', $this->data, 'base_verificacion');
			}
		} else {
			redirect(base_url('ofertas'));
		}
	}
}
