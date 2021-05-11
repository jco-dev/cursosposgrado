<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ofertas_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function listado_cursos()
	{
		$sql = "SELECT
			mcc.id_configuracion_curso,
			mcc.id_course_moodle,
			mc.fullname,
			mcc.banner_curso,
			mcc.detalle_curso,
			DATE_FORMAT(mcc.fecha_inicial, '%d-%m-%Y') as fecha_inicial,
			DATE_FORMAT(mcc.fecha_final, '%d-%m-%Y') as fecha_final,
			mcc.inversion,
			mcc.carga_horaria,
			mcc.url_pdf,
			mcc.celular_referencia
			from mdl_configuracion_curso mcc
			inner join mdl_course mc on mcc.id_course_moodle = mc.id 
			WHERE DATE_FORMAT(mcc.fecha_inicial, '%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
