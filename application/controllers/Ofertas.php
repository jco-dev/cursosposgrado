<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ofertas extends CI_Controller
{
	protected $data;

	public function index()
	{
		$this->load->view('ofertas/index', null);
	}
}
