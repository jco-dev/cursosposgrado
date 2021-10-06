<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');

class Login extends CI_Controller
{
	protected $data;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (autentificado()) {
			redirect(base_url('principal'));
		} else {
			$this->templater->view('login/login', $this->data, 'base_verificacion');
		}
	}

	public function autenticar()
	{
		if ($this->input->post("usuario") && $this->input->post("password")) {
			$usuario = mb_convert_case($this->input->post("usuario"), MB_CASE_LOWER);
			$password = $this->input->post("password");
			$resultado = $this->login_model->autenticar_usuario($usuario, $password);
			if (empty($resultado['code'])) {

				$this->session->set_userdata('id', $this->encryption->encrypt($resultado['id']));
				$this->session->set_flashdata('info', 'Ha ingresado correctamente al Sistema. ¡Le damos la Bienvenida!');
				if ($resultado['id'] != 4) {
					redirect(base_url());
				} else {
					redirect(base_url('principal'));
				}
			} else {
				$this->session->set_flashdata($resultado['code'], $resultado['message']);
				redirect(base_url('login'));
			}
		}
	}

	public function salir()
	{
		$this->session->set_flashdata('success', 'Ha salido correctamente del Sistema.');
		$this->session->unset_userdata('id');
		redirect(base_url('login'));
	}
}
