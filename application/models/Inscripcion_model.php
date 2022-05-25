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

	public function listar_cursos_vigentes()
	{
		$sql = "SELECT mcc.id_course_moodle, mc.fullname FROM mdl_configuracion_curso mcc INNER JOIN mdl_course mc on mc.id = mcc.id_course_moodle WHERE DATE_FORMAT(mcc.fecha_inicial, '%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d') AND mcc.proximo_curso = 'no'";
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
		if ($estado == "PREINSCRITO") {
			$sql = "SELECT count(id_participante) AS total from mdl_participante_preinscripcion_curso  
			        WHERE estado= 'PREINSCRITO' AND id_course_moodle = $idcurso";
		} elseif ($estado == "INSCRITO") {
			$sql = "SELECT count(id_participante) AS total from mdl_participante_preinscripcion_curso  
			        WHERE estado= 'INSCRITO' AND id_course_moodle = $idcurso";
		} else {
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
			cc.limite_inscripcion,
			cc.carga_horaria,
			cc.inversion,
			cc.horario,
			cc.descuento,
			cc.fecha_inicio_descuento,
			cc.fecha_fin_descuento,
			cc.celular_referencia,
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

	public function get_id_last_id_transaccion()
	{
		$sql = "SELECT (id_transaccion+1)as id_transaccion FROM mdl_preinscripcion_curso WHERE tipo_pago = 'PAGO EN OFICINA' order by id_preinscripcion_curso desc LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function buscar_preinscrito($id_preinscripcion)
	{
		$sql = "SELECT mpc.id_preinscripcion_curso, concat_ws(' ', mp.nombre, mp.paterno, mp.materno) as participante, mp.nombre, mp.paterno, mp.materno, concat_ws(' ', mp.ci, mp.expedido) as ci,
		mc.fullname, mpc.monto_pago, mpc.id_transaccion, mpc.fecha_pago, mpc.estado 
		from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante = mp.id_participante and mpc.id_preinscripcion_curso = '$id_preinscripcion'
		inner join mdl_course mc on mpc.id_course_moodle = mc.id;";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function verificar_cupon_por_ci_cupon($ci, $numero_cupon)
	{
		$sql = "SELECT * FROM mdl_cupones_participante mcp JOIN mdl_participante mp ON mcp.id_participante = mp.id_participante 
		JOIN mdl_cupones mc ON mcp.id_cupones = mc.id_cupones 
		WHERE mcp.numero_cupon = '$numero_cupon' AND mp.ci = '$ci' and mcp.estado = 'REGISTRADO' and " . date('Y-m-d') . " <= mc.fecha_fin_canje";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function listar_bancos()
	{
		$sql = "SELECT * FROM mdl_banco";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
