<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cupon_model extends PSG_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_id_last_number_cupon($id_cupones)
	{
		$sql = "SELECT numero_cupon FROM mdl_cupones_participante WHERE id_cupones = $id_cupones and estado = 'REGISTRADO' order by id_cupones_participante desc LIMIT 1";
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

	public function buscar_cupones_usuario($ci)
	{
		$sql = "SELECT mcp.numero_cupon FROM mdl_cupones_participante mcp JOIN mdl_participante mp ON mcp.id_participante = mp.id_participante 
		JOIN mdl_cupones mc ON mcp.id_cupones = mc.id_cupones 
		WHERE mp.ci = '$ci' AND mcp.estado = 'REGISTRADO' and " . date('Y-m-d') . " <= mc.fecha_fin_canje";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function buscar_cupon_por_numero_cupon($ci, $numero_cupon)
	{
		$sql = "SELECT * FROM mdl_cupones_participante mcp JOIN mdl_participante mp ON mcp.id_participante = mp.id_participante 
		JOIN mdl_cupones mc ON mc.id_cupones = mcp.id_cupones
		WHERE mcp.numero_cupon = '$numero_cupon' AND mp.ci = '$ci' and mcp.estado = 'REGISTRADO' and " . date('Y-m-d') . " <= mc.fecha_fin_canje";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function listar_data_usuario($ci)
	{
		$sql = "SELECT id_participante, ci, expedido, nombre, paterno, materno, celular FROM mdl_participante where ci = '$ci'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}

	public function listar_cupones_segun_fecha()
	{

		$sql = "SELECT * FROM mdl_cupones mc WHERE " . date('Y-m-d') . " BETWEEN mc.fecha_inicio AND mc.fecha_fin";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return ($query->result());
		} else {
			return null;
		}
	}
}
