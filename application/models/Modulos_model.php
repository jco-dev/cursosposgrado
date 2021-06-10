<?php defined('BASEPATH') or exit('No direct script access allowed');

class Modulos_model extends PSG_Model
{
	public function __construct()
	{
		parent::__construct();
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

}
