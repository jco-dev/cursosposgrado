<?php defined('BASEPATH') or exit('No direct script access allowed');

class Contactos_model extends PSG_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function count_contacts()
	{
		$sql = "SELECT COUNT(*) as cantidad FROM mdl_contactos WHERE estado = 'REGISTRADO'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return 0;
		}
	}

	public function list_contacts($start, $end)
	{
		$sql = "";
		if($start == null || $start == "" && $end == null || $end == ""){
			$sql = "SELECT id_contacto, nombre, paterno, materno, email FROM mdl_contactos WHERE estado = 'REGISTRADO'";
		}else{
			$sql = "SELECT id_contacto, nombre, paterno, materno, email FROM mdl_contactos WHERE estado = 'REGISTRADO' AND id_contacto >= '$start' AND id_contacto <= '$end' ";
		}

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function course_data($id)
	{
		$sql = "select 
		mc.fullname as nombre_curso,
		mcc.imagen_curso,
		mcc.fecha_inicial ,
		mcc.fecha_final ,
		mcc.carga_horaria,
		mcc.fuente_pdf,
		mcc.detalle_curso,
		mcc.url_pdf
		from mdl_course mc inner join mdl_configuracion_curso mcc on mcc.id_course_moodle = mc.id AND mcc.id_course_moodle  = '$id'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function list_last_courses($id = null)
	{
		$sql = "SELECT 
		mcc.id_course_moodle, 
		mcc.fecha_inicial, 
		mcc.fecha_final,
		mcc.detalle_curso, 
		mc.fullname, 
		mcc.banner_curso,
		mcc.carga_horaria,
		mcc.url_pdf,
		mcc.celular_referencia,
		mcc.inversion
		FROM mdl_configuracion_curso mcc 
		INNER JOIN mdl_course mc on mcc.id_course_moodle = mc.id 
		AND mcc.fecha_inicial > now() and mcc.id_course_moodle <> $id
		order by fecha_inicial
		LIMIT 3";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
