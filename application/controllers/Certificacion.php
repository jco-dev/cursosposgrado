<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificacion extends CI_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('certificacion_model');
	}

	public function index()
	{
		$this->load->view('ofertas/certificacion', $this->data);
	}
}
