<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
			$this->db->select("*, cc.nota_aprobacion, cc.fecha_certificacion, cc.fecha_inicial, cc.fecha_final");
			$this->db->from("inscripcion_curso insc");
			$this->db->join("user u", "u.id = insc.id_user_moodle");
			$this->db->join("course c", "c.id = insc.id_course_moodle");
			$this->db->join("configuracion_curso cc", "c.id=cc.id_course_moodle", "right");
			$this->db->where("md5(concat('CERTIFICADO_', insc.id_inscripcion_curso)) = '" . $id . "'");
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
