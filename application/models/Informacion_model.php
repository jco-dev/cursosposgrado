<?php defined('BASEPATH') or exit('No direct script access allowed');

class Informacion_model extends PSG_Model
{
	protected $mk;
	public function __construct()
	{
		parent::__construct();
		$this->mk = $this->load->database('marketing', true);
	}

	public function listar_profesiones_oficios()
	{
		$sql = "SELECT *
			from mdl_profesion_oficio where id_profesion_oficio != '1'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function informacion_curso($id)
	{
		$sql = "SELECT  
			mcc.mensaje_whatsapp
			from mdl_configuracion_curso mcc where  mcc.id_course_moodle =$id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function buscar_por_celular($celular)
	{
		$this->mk->select('nombre');
		$this->mk->from("contacto as c");
		return $this->mk->where("c.celular=$celular")->get();
	}

	// Insertar contacto celular y nombre en marketing contacto.
	public function insertar_contacto($data = [])
	{
		$this->mk->insert('contacto', $data);
		return $this->mk->insert_id();
	}
}
