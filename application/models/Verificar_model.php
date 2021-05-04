<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verificar_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function verificar_certificado($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'Certificado no encontrado.');
		if (!is_null($id)) {
			$this->db->select("*");
			$this->db->from("calificaciones cal");
			$this->db->join("participantes p", "p.id = cal.id_participante");
			$this->db->join("cursos c", "c.id = cal.id_curso");
			$this->db->where("md5(concat('CERTIFICADO_', cal.id)) = '" . $id . "'");
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
