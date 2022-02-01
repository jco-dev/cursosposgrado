<?php defined('BASEPATH') or exit('No direct script access allowed');

class Certificacion_model extends PSG_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function buscar_persona_por_ci($ci, $celular)
	{
		if ($ci != null) {
			$sql = "select 
			mc.id,
			mc.fullname, 
			mp.ci ,
			mp.nombre ,
			mp.paterno,
			mp.materno,
			mic.calificacion_final, 
			mcc.nota_aprobacion, 
			mcc.carga_horaria, 
			mcc.certificacion_disponible, 
			mcc.certificacion_disponible_inicio, 
			mcc.certificacion_disponible_fin
			from mdl_course mc
			inner join mdl_configuracion_curso mcc on mc.id = mcc.id_course_moodle
			inner join mdl_inscripcion_curso mic on mic.id_course_moodle = mcc.id_course_moodle
			inner join mdl_participante mp on mp.id_user = mic.id_user_moodle  and mp.ci =$ci and mp.celular =$celular";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}
