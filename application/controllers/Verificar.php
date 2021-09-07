<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verificar extends CI_Controller
{
	protected $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('verificar_model');
	}

	public function index()
	{
		if ($this->input->get('id') && $this->input->get('id') != null) {
			$resultado = $this->verificar_model->verificar_certificado($this->input->get('id'));
			if (empty($resultado['code'])) {
				$this->data['id'] = $this->input->get('id');
				$this->data['certificado'] = $resultado;
				$this->templater->view('verificacion/certificado', $this->data, 'base_verificacion');
			} else {
				$this->data['id'] = $this->input->get('id');
				$this->templater->view('verificacion/certificado_erroneo', $this->data, 'base_verificacion');
			}
		}elseif ($this->input->get('id_inscripcion') && $this->input->get('id_inscripcion') != null) {
			$resultado = $this->verificar_model->verificar_preinscripcion($this->input->get('id_inscripcion'));
			
			if (is_array($resultado) && count($resultado) > 0 ) {
				$this->data['id_inscripcion'] = $this->input->get('id_inscripcion');
				$this->data['participante'] = $resultado[0];
				$this->templater->view('verificacion/inscripcion', $this->data, 'base_verificacion');
			} else {
				$this->data['id_inscripcion'] = $this->input->get('id_inscripcion');
				$this->templater->view('verificacion/inscripcion_erroneo', $this->data, 'base_verificacion');
			}
		} else {
			redirect(base_url('ofertas'));
		}
	}
}
