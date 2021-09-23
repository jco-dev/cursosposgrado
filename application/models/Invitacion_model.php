<?php defined('BASEPATH') or exit('No direct script access allowed');

class Invitacion_model extends PSG_Model
{
	protected $mk;
	public function __construct()
	{
		parent::__construct();
		$this->mk = $this->load->database('marketing', true);
	}

	public function listar_grupos_whatsapp($condicion = [])
	{

		$this->mk->order_by('orden asc');
		return empty($condicion) ? $this->mk->get('grupo_whatsapp') : $this->mk->get_where('grupo_whatsapp', $condicion);
	}

	public function actualizar_suscritos($id, $suscritos)
	{

		return $this->mk->update('grupo_whatsapp', ['suscritos' => $suscritos], ['id_grupo_whatsapp' => $id]);
		// return var_dump($this->mk->last_query());
	}

	public function listar_responsables($id)
	{
		$this->mk->select();
		$this->mk->from("responsable_categoria as rc");
		$this->mk->join("categoria as c", "c.id_categoria = rc.id_categoria");
		return $this->mk->where("rc.id_categoria=$id")->get();
	}

	public function video_informacion($condicion)
	{
		return $this->mk->get_where('video_informacion', $condicion)->row_array();
	}
}
