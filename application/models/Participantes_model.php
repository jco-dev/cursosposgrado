<?php defined('BASEPATH') or exit('No direct script access allowed');

class Participantes_model extends PSG_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	public function total_user()
	{
		$this->db->from('user u');
		$this->db->where_not_in("u.id", array(1, 2));
		if (is_integer($query = $this->db->count_all_results())) {
			$resultado = $query;
		} else {
			$resultado = $this->db->error();
		}
		return $resultado;
	}

    public function total_participantes()
    {
        $this->db->from('participantes p');
		$this->db->where_not_in("p.id", array(290));
        if (is_integer($query = $this->db->count_all_results())) {
            $resultado = $query;
        } else {
            $resultado = $this->db->error();
        }
        return $resultado;
    }
	public function lista_user($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se ha encontrado el registro.');
		$this->db->select("c.*, (SELECT cc.id FROM mdl_participantes cc WHERE cc.id_moodle = c.id) AS vinculo");
		$this->db->where_not_in("c.id", array(1));
		$this->db->order_by('c.id', 'ASC');
		if (is_numeric($id)) {
			$this->db->where('c.id', $id);
			$query = $this->db->get('user c');
			$resultado = (($query) ? $query->row_array() : $this->db->error());
		} elseif ($id === TRUE) {
			$query = $this->db->get('user c');
			$resultado = (($query) ? $query->result_array() : $this->db->error());
		}
		return $resultado;
	}

	public function lista_participantes($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se ha encontrado el registro.');
		$this->db->where_not_in("c.id", array(1));
		$this->db->order_by('c.id_moodle', 'ASC');
		if (is_numeric($id)) {
			$this->db->where('c.id', $id);
			$query = $this->db->get('participantes c');
			$resultado = (($query) ? $query->row_array() : $this->db->error());
		} elseif ($id === TRUE) {
			$query = $this->db->get('participantes c');
			$resultado = (($query) ? $query->result_array() : $this->db->error());
		}
		return $resultado;
	}

	public function insertar_curso($data = array())
	{
		$resultado = array('code' => 'info', 'message' => 'No se puede insertar el registro.');
		if (!empty($data)) {
			$query = $this->db->insert('participantes', $data);
			$resultado = (($query) ? $this->db->insert_id() : $this->db->error());
		}
		return $resultado;
	}

	public function vincular_curso($id = NULL, $id_moodle = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se puede vincular el registro.');
		if ((!is_null($id)) && (!is_null($id_moodle))) {
			$query = $this->db->update('participantes', array('id_moodle' => $id_moodle), array('id' => $id));
			$resultado = (($query) ? $id_moodle : $this->db->error());
		}
		return $resultado;
	}

	public function desvincular_curso($id = NULL)
	{
		$resultado = array('code' => 'info', 'message' => 'No se puede desvincular el registro.');
		if (!is_null($id)) {
			$query = $this->db->update('participantes', array('id_moodle' => NULL), array('id' => $id));
			$resultado = (($query) ? $id : $this->db->error());
		}
		return $resultado;
	}
}
