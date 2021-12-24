<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cupon_model extends PSG_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_id_last_number_cupon($id_cupones)
	{
		$sql = "SELECT numero_cupon FROM mdl_cupones_participante WHERE id_cupones = $id_cupones and estado = 'REGISTRADO' order by id_cupones_participante desc LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
