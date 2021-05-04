<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Templater
{
	private $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
	}

	public function view($contenido, $data = array(), $base = 'base')
	{
		$vars['contenido'] = $this->CI->load->view($contenido, $data, TRUE);
		$base = $this->CI->load->view($base, $vars, TRUE);
		$this->CI->output->set_output($base);
	}

	public function login()
	{
		$data['pie'] = $this->CI->load->view('pie', NULL, TRUE);
		$login = $this->CI->load->view('login', $data, TRUE);
		$this->CI->output->set_output($login);
	}
}
