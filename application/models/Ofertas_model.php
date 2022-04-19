<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ofertas_model extends PSG_Model
{
	protected $mk;
	public function __construct()
	{
		parent::__construct();
		$this->mk = $this->load->database('marketing', true);
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
			DATE_FORMAT(mcc.limite_inscripcion, '%d-%m-%Y') as limite_inscripcion,
			DATE_FORMAT(mcc.fecha_final, '%d-%m-%Y') as fecha_final,
			mcc.inversion,
			mcc.carga_horaria,
			mcc.url_pdf,
			mcc.celular_referencia,
			mcc.descuento,
			DATE_FORMAT(mcc.fecha_inicio_descuento, '%d-%m-%Y') as fecha_inicio_descuento,
			DATE_FORMAT(mcc.fecha_fin_descuento, '%d-%m-%Y') as fecha_fin_descuento
			from mdl_configuracion_curso mcc
			inner join mdl_course mc on mcc.id_course_moodle = mc.id 
			WHERE DATE_FORMAT(mcc.limite_inscripcion, '%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d') AND mcc.proximo_curso = 'no'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function verificar_proximos_cursos()
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
			mcc.celular_referencia,
			mcc.descuento,
			DATE_FORMAT(mcc.fecha_inicio_descuento, '%d-%m-%Y') as fecha_inicio_descuento,
			DATE_FORMAT(mcc.fecha_fin_descuento, '%d-%m-%Y') as fecha_fin_descuento
			from mdl_configuracion_curso mcc
			inner join mdl_course mc on mcc.id_course_moodle = mc.id 
			WHERE DATE_FORMAT(mcc.fecha_fin_lanzamiento, '%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d') AND mcc.proximo_curso = 'si'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function actualizar_proximo_curso()
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
			mcc.celular_referencia,
			mcc.descuento,
			DATE_FORMAT(mcc.fecha_inicio_descuento, '%d-%m-%Y') as fecha_inicio_descuento,
			DATE_FORMAT(mcc.fecha_fin_descuento, '%d-%m-%Y') as fecha_fin_descuento
			from mdl_configuracion_curso mcc
			inner join mdl_course mc on mcc.id_course_moodle = mc.id 
			WHERE DATE_FORMAT(mcc.fecha_fin_lanzamiento, '%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d') AND mcc.proximo_curso = 'si'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function buscar_por_celular($celular)
	{
		$this->mk->select('id_contacto, nombre');
		$this->mk->from("contacto as c");
		return $this->mk->where("c.celular=$celular")->get();
	}

	// Insertar contacto celular y nombre en marketing contacto.
	public function insertar_contacto($data = [])
	{
		$this->mk->insert('contacto', $data);
		return $this->mk->insert_id();
	}

	public function insertar_area($data = [])
	{
		$this->mk->insert('area_interes_contacto', $data);
		return $this->mk->insert_id();
	}
}
