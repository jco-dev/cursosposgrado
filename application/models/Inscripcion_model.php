<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inscripcion_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function data_curso($id)
	{
		$sql = "SELECT id_course_moodle, banner_curso, detalle_curso FROM mdl_configuracion_curso
		WHERE id_course_moodle = '$id'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function listar_cursos()
	{
		$sql = "SELECT mcc.id_course_moodle, mc.fullname FROM mdl_configuracion_curso mcc INNER JOIN mdl_course mc on mc.id = mcc.id_course_moodle";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function listar_municipios()
	{
		$sql = "SELECT id_municipio, nombre_departamento, nombre_municipio FROM mdl_departamentos_municipios";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
