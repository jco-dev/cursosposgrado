<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function autenticar_usuario($usuario = NULL, $password = NULL)
	{
		$resultado = array('code' => 'warning', 'message' => 'Usuario y Contraseña incorrectos.');
		if ((!is_null($usuario)) && (!is_null($password))) {
			$this->db->select("u.id, u.usuario, u.password");
			$this->db->from("mdl_usuarios u");
			$this->db->where("u.usuario", $usuario);
			$this->db->where("u.password", md5($password));
			$query = $this->db->get();
			if ($query) {
				if ($query->num_rows() === 1) {
					$resultado = $query->row_array();
				}
			} else {
				$resultado = $this->db->error();
			}
		}
		return $resultado;
	}

	public function verificar_usuario($id = NULL)
	{
		$resultado = array('code' => 'error', 'message' => 'No se encuentra el usuario.');
		if (!is_null($id)) {
			$this->db->select("u.id, u.usuario, u.password");
			$this->db->from("mdl_usuarios u");
			$this->db->where("u.id", $id);
			$query = $this->db->get();
			if ($query) {
				if ($query->num_rows() === 1) {
					$resultado = $query->row_array();
				}
			} else {
				$resultado = $this->db->error();
			}
		}
		return $resultado;
	}
}
