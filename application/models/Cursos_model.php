<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cursos_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function total_course()
	{
		$this->db->from('course c');
		$this->db->where_not_in("c.id", array(1));
		if (is_integer($query = $this->db->count_all_results())) {
			$resultado = $query;
		} else {
			$resultado = $this->db->error();
		}
		return $resultado;
	}

	public function total_cursos()
	{
		$this->db->from('cursos c');
		$this->db->where_not_in("c.id", array(1));
		if (is_integer($query = $this->db->count_all_results())) {
			$resultado = $query;
		} else {
			$resultado = $this->db->error();
		}
		return $resultado;
	}

	public function lista_course($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se ha encontrado el registro.');
		$this->db->select("c.*, (SELECT cc.id FROM mdl_cursos cc WHERE cc.id_moodle = c.id) AS vinculo");
		$this->db->where_not_in("c.id", array(1));
		$this->db->order_by('c.id', 'ASC');
		if (is_numeric($id)) {
			$this->db->where('c.id', $id);
			$query = $this->db->get('course c');
			$resultado = (($query) ? $query->row_array() : $this->db->error());
		} elseif ($id === TRUE) {
			$query = $this->db->get('course c');
			$resultado = (($query) ? $query->result_array() : $this->db->error());
		}
		return $resultado;
	}

	public function lista_cursos($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se ha encontrado el registro.');
		$this->db->where_not_in("c.id", array(1));
		$this->db->order_by('c.id_moodle', 'ASC');
		if (is_numeric($id)) {
			$this->db->where('c.id', $id);
			$query = $this->db->get('cursos c');
			$resultado = (($query) ? $query->row_array() : $this->db->error());
		} elseif ($id === TRUE) {
			$query = $this->db->get('cursos c');
			$resultado = (($query) ? $query->result_array() : $this->db->error());
		}
		return $resultado;
	}

	public function insertar_curso($data = array())
	{
		$resultado = array('code' => 'info', 'message' => 'No se puede insertar el registro.');
		if (!empty($data)) {
			$query = $this->db->insert('cursos', $data);
			$resultado = (($query) ? $this->db->insert_id() : $this->db->error());
		}
		return $resultado;
	}

	public function vincular_curso($id = NULL, $id_moodle = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se puede vincular el registro.');
		if ((!is_null($id)) && (!is_null($id_moodle))) {
			$query = $this->db->update('cursos', array('id_moodle' => $id_moodle), array('id' => $id));
			$resultado = (($query) ? $id_moodle : $this->db->error());
		}
		return $resultado;
	}

	public function desvincular_curso($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se puede desvincular el registro.');
		if (!is_null($id)) {
			$query = $this->db->update('cursos', array('id_moodle' => NULL), array('id' => $id));
			$resultado = (($query) ? $id : $this->db->error());
		}
		return $resultado;
	}

	public function verificar_configuracion($id = null)
	{
		if ($id != null) {
			$sql = "SELECT * FROM mdl_configuracion_curso WHERE id_course_moodle = $id and estado_curso='REGISTRADO'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	public function get_listado_estudiantes_curso($id = null)
	{
		if ($id != null) {
			$sql = "SELECT mdl_user.id AS id_user_moodle, mdl_user.firstname AS apellidos , mdl_user.lastname AS nombre,
			concat(mdl_user.firstname, ' ',mdl_user.lastname) AS alumno,
			mdl_course.fullname AS curso, mdl_course_categories.name AS categoria, mdl_course.id AS id_course_moodle,
			CASE WHEN mdl_grade_items.itemtype = 'course' THEN concat('CalificacionFinal:')
			WHEN mdl_grade_items.itemtype ='category' THEN mdl_grade_categories.fullname ELSE mdl_grade_items.itemname
			END AS elementocalificador, mdl_grade_grades.itemid, ROUND(mdl_grade_grades.finalgrade,2) AS nota, mdl_scale.scale,			
			if(ROUND(mdl_grade_grades.finalgrade)<2,SUBSTRING_INDEX(mdl_scale.scale,',',ROUND(mdl_grade_grades.finalgrade)),
			substring(SUBSTRING_INDEX(mdl_scale.scale,',',ROUND(mdl_grade_grades.finalgrade)),((length(SUBSTRING_INDEX(mdl_scale.scale,',',ROUND(mdl_grade_grades.finalgrade)))-length(SUBSTRING_INDEX(mdl_scale.scale,',',ROUND(mdl_grade_grades.finalgrade)-1))-1)*-1))) as texto,
			DATE_ADD('1970-01-01', INTERVAL mdl_grade_items.timemodified SECOND) AS fechanota,
			mdl_grade_items.itemtype as tipoelemento, mdl_grade_items.sortorder, mdl_grade_items.hidden
			FROM mdl_course
			JOIN mdl_context  ON mdl_course.id = mdl_context.instanceid
			JOIN mdl_role_assignments ON mdl_role_assignments.contextid = mdl_context.id
			JOIN mdl_user  ON mdl_user.id = mdl_role_assignments.userid
			JOIN mdl_grade_grades ON mdl_grade_grades.userid = mdl_user.id
			JOIN mdl_grade_items ON mdl_grade_items.id = mdl_grade_grades.itemid
			left join mdl_grade_categories on mdl_grade_categories.id = mdl_grade_items.iteminstance
			JOIN mdl_course_categories ON mdl_course_categories.id = mdl_course.category
			left join mdl_scale on mdl_scale.id = mdl_grade_grades.rawscaleid
			WHERE mdl_grade_items.courseid = mdl_course.id and mdl_course.id = '$id'
			and mdl_grade_grades.finalgrade is not null and mdl_grade_items.hidden=0 AND (CASE WHEN mdl_grade_items.itemtype = 'course' THEN concat('CalificacionFinal:')
			WHEN mdl_grade_items.itemtype ='category' THEN mdl_grade_categories.fullname ELSE mdl_grade_items.itemname
			END)='CalificacionFinal:'
			ORDER BY curso, sortorder";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return null;
			}
		}
	}

	public function editar_inscripcion_curso($id = null)
	{
		if ($id != null) {
			$sql = "SELECT 
			ic.id_inscripcion_curso, u.lastname,u.firstname,
			concat(u.lastname, ' ',u.firstname) AS usuario,
			c.id,
			ic.calificacion_final,
			ic.tipo_pago,
			ic.nro_transaccion,
			ic.monto_pago,
			ic.respaldo_pago,
			ic.tipo_participacion,
			ic.fecha_entrega,
			ic.entregado_a,
			ic.observacion_entrega,
			ic.fecha_registro,
			ic.tipo_certificacion_solicitado,
			ic.certificado_recogido,
			ic.estado_inscripcion_curso
			from mdl_inscripcion_curso ic inner join mdl_user u on ic.id_user_moodle = u.id AND ic.id_inscripcion_curso = '$id'
			inner join mdl_course c on ic.id_course_moodle = c.id order by u.lastname, u.firstname";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return null;
			}
		}
	}

	/** get configuracion de un curso */
	public function get_datos_curso($id = null)
	{
		if ($id != null) {
			$sql = "SELECT
			mcc.imagen_curso,
			mc.fullname as nombre_curso,
			mc.shortname,
			mcc.nota_aprobacion,
			mcc.orientacion,
			DATE_FORMAT(mcc.fecha_certificacion, '%Y-%m-%d') as fecha_certificacion,
			DATE_FORMAT(mcc.fecha_inicial, '%Y-%m-%d') as fecha_inicial,
			DATE_FORMAT(mcc.fecha_final, '%Y-%m-%d') as fecha_final,
			mcc.carga_horaria,
			mcc.posx_nombre_participante,
			mcc.posy_nombre_participante,
			mcc.posx_bloque_texto,
			mcc.posy_bloque_texto,
			mcc.posx_qr,
			mcc.posy_qr,
			mcc.posx_tipo_participacion,
			mcc.posy_tipo_participacion,
			mcc.posx_nombre_curso,
			mcc.posy_nombre_curso,
			mcc.fuente_pdf,
			mcc.tamano_titulo,
			mcc.tamano_subtitulo,
			mcc.tamano_texto,
			mcc.color_nombre_participante,
			mcc.color_subtitulo,
       		mcc.banner_curso,
			mcc.imagen_personalizado,
			mcc.posx_imagen_personalizado,
			mcc.posy_imagen_personalizado,
			mcc.imprimir_subtitulo,
			mcc.subtitulo,
			mcc.estado_curso,
			mtc.metodo
			FROM mdl_configuracion_curso mcc 
			INNER JOIN mdl_course mc ON mcc.id_course_moodle = mc.id AND mcc.id_course_moodle = '$id' AND mcc.estado_curso <> 'ELIMINADO'
			LEFT JOIN mdl_tipo_certificado mtc on mtc.id_tipo_certificado = mcc.id_tipo_certificado";
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

	/** Obtener el estudiantes para la certificacion */
	public function get_datos_estudiante($id = null)
	{
		if ($id != null) {
			$sql = "SELECT
			ic.id_inscripcion_curso,
			concat(u.firstname, ' ',u.lastname) AS usuario,
			c.id,
			ic.calificacion_final,			
			ic.tipo_participacion,
			ic.fecha_entrega,
			ic.fecha_registro,
			ic.estado_inscripcion_curso
			from mdl_inscripcion_curso ic inner join mdl_user u on ic.id_user_moodle = u.id AND ic.id_inscripcion_curso = '$id'
			inner join mdl_course c on ic.id_course_moodle = c.id";
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

	public function get_estudiantes_curso($id)
	{
		if ($id != null) {
			$sql = "SELECT
			ic.id_inscripcion_curso,
			concat(u.firstname, ' ',u.lastname) AS usuario,
			c.id,
			ic.calificacion_final,			
			ic.tipo_participacion,
			ic.fecha_entrega,
			ic.fecha_registro,
			ic.certificacion_unica,
			ic.estado_inscripcion_curso
			from mdl_inscripcion_curso ic inner join mdl_user u on ic.id_user_moodle = u.id and ic.estado_inscripcion_curso <> 'ELIMINADO'
			inner join mdl_course c on ic.id_course_moodle = c.id AND c.id = '$id' ORDER BY u.firstname, u.lastname";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return array();
			}
		} else {
			return array();
		}
	}

	public function get_estudiantes_send($idcurso)
	{
		if ($idcurso != null) {
			$sql = "SELECT
			ic.id_inscripcion_curso,
			concat(u.firstname, ' ',u.lastname) AS nombre_completo,
			u.email,
			c.id,
			c.fullname,
			ic.calificacion_final,			
			ic.tipo_participacion,
			ic.certificacion_unica
			from mdl_inscripcion_curso ic inner join mdl_user u on ic.id_user_moodle = u.id
			inner join mdl_course c on ic.id_course_moodle = c.id AND c.id = '$idcurso'";
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

	public function get_url_pdf($idcurso)
	{
		if ($idcurso != null) {
			$sql = "SELECT url_pdf
			from mdl_configuracion_curso mcc  where mcc.id_course_moodle = '$idcurso'";
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

	public function contar_modulos($id)
	{
		if ($id != null) {
			$sql = "SELECT COUNT(*) as cantidad FROM mdl_certificacion WHERE id_course='$id' AND estado='REGISTRADO'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function contar_estudiantes_inscritos($id)
	{
		if ($id != null) {
			$sql = "SELECT COUNT(*) as cantidad FROM mdl_inscripcion_curso_vista WHERE id = $id AND tipo_participacion = 'PARTICIPANTE'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function contar_estudiantes_preinscritos($id)
	{
		if ($id != null) {
			$sql = "SELECT COUNT(*) as cantidad FROM mdl_ver_inscritos WHERE id_course_moodle = $id";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return ($query->result());
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function get_inscritos_preinscritos($id = null)
	{
		if ($id != null) {
			$sql = "SELECT
			CONCAT_WS(' ', mp.ci, mp.expedido) as ci,
			CONCAT_WS(' ', mp.nombre, mp.paterno, mp.materno) as nombre_completo,
			mp.celular,
			mpc.tipo_pago, 
			mpc.id_transaccion, 
			mpc.monto_pago, 
			mpc.fecha_pago, 
			mpc.fecha_preinscripcion,
			mpc.estado
			from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante  = mp.id_participante  and mpc.id_course_moodle = '$id' and mpc.estado <> 'INTERESADO'
			and mpc.estado = 'INSCRITO'
			
			UNION
			
			SELECT
			CONCAT_WS(' ', mp.ci, mp.expedido) as ci,
			CONCAT_WS(' ', mp.nombre, mp.paterno, mp.materno) as nombre_completo,
			mp.celular,
			mpc.tipo_pago, 
			mpc.id_transaccion, 
			mpc.monto_pago, 
			mpc.fecha_pago, 
			mpc.fecha_preinscripcion, 
			mpc.estado 
			from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante  = mp.id_participante  and mpc.id_course_moodle = '$id' and mpc.estado <> 'INTERESADO'
			and mpc.estado = 'PREINSCRITO' ORDER BY 9, 2";
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

	public function total_recaudacion($id, $tipo)
	{
		if ($id != null) {
			$sql = "SELECT
			SUM(mpc.monto_pago) AS monto_total
			from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante  = mp.id_participante  and mpc.id_course_moodle = '$id' and mpc.estado <> 'INTERESADO'
			and mpc.estado = '$tipo'";
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

	public function total_recaudacion_por_tipo_pago($id, $tipo)
	{
		if ($id != null) {
			$sql = "select
			tipo_pago, 
			SUM(mpc.monto_pago) AS monto_total
			from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante  = mp.id_participante  and mpc.id_course_moodle = '$id' and mpc.estado <> 'INTERESADO'
			and mpc.estado = '$tipo'
			group  by tipo_pago";
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

	public function total_recaudacion_por_tipo_pago_agrupacion($id, $tipo)
	{
		if ($id != null) {
			$sql = "SELECT
			count(mpc.tipo_pago) as cantidad,
			mpc.tipo_pago,
			sum(mpc.monto_pago) as monto_pago
			from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante  = mp.id_participante  and mpc.id_course_moodle = '$id' and mpc.estado <> 'INTERESADO'
			and mpc.estado = '$tipo'
			group by mpc.tipo_pago";
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

	public function date_print($id)
	{
		if ($id != null) {
			$sql = "SELECT fecha_inicial, fecha_final, fecha_certificacion FROM mdl_configuracion_curso WHERE id_course_moodle = '$id'";
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

	public function get_datos_envio($id)
	{
		if ($id != null) {
			$sql = "SELECT
			mec.remitente,
			CONCAT_WS(' ', mp.nombre, mp.paterno, mp.materno) as participante,
			mp.celular,
			mec.direccion,
			(SELECT md.nombre  FROM mdl_municipios mm join mdl_provincias mp2 on mm.id_provincia=mp2.id_provincia and mm.id_municipio = mp.id_municipio  JOIN
			mdl_departamentos md on mp2.id_departamento = md.id_departamento) as departamento
			from mdl_preinscripcion_curso mpc join mdl_envio_certificados mec on mpc.id_preinscripcion_curso = mec.id_preinscripcion_curso 
			and mpc.id_course_moodle  = $id and mec.estado='CONFIRMADO'
			join mdl_participante mp on mpc.id_participante = mp.id_participante ";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0)
				return ($query->result());
			else
				return null;
		} else {
			return null;
		}
	}
}
