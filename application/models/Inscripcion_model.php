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

	public function ver_estudiantes_curso($idcurso, $estado)
	{
		$sql = "";
		if($estado == "PREINSCRITO"){
			$sql = "SELECT count(id_participante) AS total from mdl_participante_preinscripcion_curso  
			        WHERE estado= 'PREINSCRITO' AND id_course_moodle = $idcurso";
		}elseif($estado == "INSCRITO"){
			$sql = "SELECT count(id_participante) AS total from mdl_participante_preinscripcion_curso  
			        WHERE estado= 'INSCRITO' AND id_course_moodle = $idcurso";
		}else{
			$sql = "SELECT count(id_participante) AS total from mdl_participante_preinscripcion_curso  
			        WHERE id_course_moodle = $idcurso";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function listar_estudiantes_todos($id)
	{
		$sql = "SELECT * from mdl_participante_preinscripcion_curso where id_course_moodle= $id AND estado != 'INTERESADO'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}


	public function get_config_curso($idcurso)
	{
		if ($idcurso != null) {
			$sql = "SELECT
			cc.fecha_inicial,
			cc.fecha_final,
			cc.carga_horaria,
			cc.inversion,
			cc.horario,
			CONCAT (
			CASE DAYOFWEEK(cc.fecha_inicial)
			WHEN 1 THEN 'Domingo'
			WHEN 2 THEN 'Lunes'
			WHEN 3 THEN 'Martes'
			WHEN 4 THEN 'Miércoles'
			WHEN 5 THEN 'Jueves'
			WHEN 6 THEN 'Viernes'
			WHEN 7 THEN 'Sábado' END)as nombre_dia,
			datediff(cc.fecha_final , cc.fecha_inicial)/7 AS semanas,
			CONCAT(DATE_FORMAT(cc.fecha_inicial, '%d'), ' DE ',
			CASE MONTH(cc.fecha_inicial)
			WHEN 1 THEN 'ENERO'
			WHEN 2 THEN 'FEBRERO'
			WHEN 3 THEN 'MARZO'
			WHEN 4 THEN 'ABRIL'
			WHEN 5 THEN 'MAYO'
			WHEN 6 THEN 'JUNIO'
			WHEN 7 THEN 'JULIO'
			WHEN 8 THEN 'AGOSTO'
			WHEN 9 THEN 'SEPTIEMBRE'
			WHEN 10 THEN 'OCTUBRE'
			WHEN 11 THEN 'NOVIEMBRE'
			WHEN 12 THEN 'DICIEMBRE'
			END, ' DE ', DATE_FORMAT(cc.fecha_inicial, '%Y')
			) AS fecha_inicial_literal ,
			CONCAT(DATE_FORMAT(cc.fecha_final, '%d'), ' DE ',
			CASE MONTH(cc.fecha_final)
			WHEN 1 THEN 'ENERO'
			WHEN 2 THEN 'FEBRERO'
			WHEN 3 THEN 'MARZO'
			WHEN 4 THEN 'ABRIL'
			WHEN 5 THEN 'MAYO'
			WHEN 6 THEN 'JUNIO'
			WHEN 7 THEN 'JULIO'
			WHEN 8 THEN 'AGOSTO'
			WHEN 9 THEN 'SEPTIEMBRE'
			WHEN 10 THEN 'OCTUBRE'
			WHEN 11 THEN 'NOVIEMBRE'
			WHEN 12 THEN 'DICIEMBRE'
			END, ' DE ', DATE_FORMAT(cc.fecha_final, '%Y')
			) AS fecha_final_literal 
			from mdl_configuracion_curso cc WHERE cc.id_course_moodle = $idcurso AND cc.estado_curso='REGISTRADO'";
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
