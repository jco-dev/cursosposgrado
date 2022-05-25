<?php defined('BASEPATH') or exit('No direct script access allowed');

class Evento_model extends PSG_Model
{
	protected $mk;

	public function __construct()
	{
		parent::__construct();
		$this->mk = $this->load->database('marketing', TRUE);
	}

	public function listar_cursos_sorteo()
	{
		$sql = "SELECT mcs.id_curso_sorteo, mcs.nombre_curso_sorteo,
		(SELECT COUNT(*) from mk_curso_sorteo_persona_externa mcsp where mcsp.id_curso_sorteo = mcs.id_curso_sorteo) as votacion
		FROM mk_curso_sorteo mcs WHERE estado_curso_sorteo = 'ACTIVO' order by 3 desc";
		$query = $this->mk->query($sql);
		return $query->result();
	}

	public function listar_horario_votacion()
	{
		$sql = "SELECT mhe.id_hora_evento, mhe.hora_evento, (SELECT COUNT(*) FROM mk_persona_externa p WHERE p.id_hora_evento = mhe.id_hora_evento)as votacion 
		FROM  mk_hora_evento mhe order by 3 DESC ";
		$query = $this->mk->query($sql);
		return $query->result();
	}

	public function listar_inscritos()
	{
		$sql = "SELECT mpe.id_persona_externa,
		mpe.nombre_completo,
		mpe.nro_celular,
		mpe.correo,
		mhe.hora_evento
	FROM mk_persona_externa mpe
	inner join mk_hora_evento mhe on mhe.id_hora_evento=mpe.id_hora_evento order by 5 asc";
		$query = $this->mk->query($sql);
		return $query->result();
	}
}
