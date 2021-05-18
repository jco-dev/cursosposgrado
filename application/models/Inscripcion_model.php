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

	public function datos_estudiante_curso($id_preinscripcion)
	{
		$sql = "SELECT concat(mppc.nombre, ' ', mppc.paterno, ' ', mppc.materno) as nombre_completo, 
		mc.fullname as curso, mppc.estado_correo FROM mdl_participante_preinscripcion_curso mppc INNER JOIN mdl_course mc ON
		mppc.id_course_moodle = mc.id AND mppc.id_preinscripcion_curso = $id_preinscripcion";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function get_data_informacion($id_preinscripcion)
	{
		$sql = "SELECT concat(mp.nombre, ' ', mp.paterno, ' ', mp.materno) as nombre_completo, 
		mc.fullname,mp.correo, mcc.url_pdf, mcc.banner_curso
		FROM mdl_participante mp INNER JOIN mdl_preinscripcion_curso mpc ON mp.id_participante = mpc.id_participante
		INNER JOIN mdl_configuracion_curso mcc ON mpc.id_course_moodle = mcc.id_course_moodle
		INNER JOIN mdl_course mc on mc.id = mcc.id_course_moodle
		AND mpc.id_preinscripcion_curso = $id_preinscripcion";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function ver_estudiantes_confirmados($idcurso)
	{
		$sql = "SELECT count(id_participante) AS total from mdl_participante_preinscripcion_curso  WHERE estado= 'INSCRITO' AND id_course_moodle = $idcurso";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
