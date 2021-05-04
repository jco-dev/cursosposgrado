<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PSG_Controller extends CI_Controller
{
	protected $data;

	public function __construct()
	{
		parent::__construct();
		$this->usuario = autentificado();
		if (!$this->usuario) {
			$this->session->set_flashdata('info', 'Escriba su Nombre de Usuario y su Clave de Acceso, para verificar su identidad.');
			redirect(base_url('login'));
		}
		$this->data['usuario'] = $this->usuario;
	}
}
