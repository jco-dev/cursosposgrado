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
			mcc.nota_aprobacion,
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
			mcc.estado_curso
			FROM mdl_configuracion_curso mcc 
			INNER JOIN mdl_course mc ON mcc.id_course_moodle = mc.id AND mcc.id_course_moodle = '$id' AND mcc.estado_curso <> 'ELIMINADO'
			";
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
			ic.estado_inscripcion_curso
			from mdl_inscripcion_curso ic inner join mdl_user u on ic.id_user_moodle = u.id
			inner join mdl_course c on ic.id_course_moodle = c.id AND c.id = '$id'";
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
