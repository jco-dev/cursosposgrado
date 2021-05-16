<?php defined('BASEPATH') or exit('No direct script access allowed');

class Informacion_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function listar_profesiones_oficios()
	{
		$sql = "SELECT *
			from mdl_profesion_oficio where id_profesion_oficio != '1'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
