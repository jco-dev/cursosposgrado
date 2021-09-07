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

	public function verificar_preinscripcion($id = NULL)
	{
		$sql = "SELECT mpc.id_preinscripcion_curso, concat_ws(' ', mp.nombre, mp.paterno, mp.materno) as participante, concat_ws(' ', mp.ci, mp.expedido) as ci,
		mc.fullname, mpc.monto_pago, mpc.id_transaccion, mpc.fecha_pago, mpc.estado, mcc.fecha_inicial, mcc.fecha_final, mcc.carga_horaria
		from mdl_preinscripcion_curso mpc inner join mdl_participante mp on mpc.id_participante = mp.id_participante and md5(concat('INSCRIPCION_', mpc.id_preinscripcion_curso)) = '" . $id . "'
		inner join mdl_course mc on mpc.id_course_moodle = mc.id  inner join mdl_configuracion_curso mcc on mcc.id_course_moodle = mpc.id_course_moodle";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
