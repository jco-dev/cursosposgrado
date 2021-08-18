<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ofertas extends CI_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ofertas_model');
	}

	public function index()
	{
		$this->data['proximo_curso'] = $this->ofertas_model->verificar_proximos_cursos();
		$cursos_proximos = $this->ofertas_model->actualizar_proximo_curso();
		// return var_dump($cursos_proximos);
		if($cursos_proximos != NULL){
			foreach($cursos_proximos as $c){
				$res = $this->sql_ssl->modificar_tabla(
					'configuracion_curso',
					[
						'proximo_curso' => 'no'
					],
					[
						'id_configuracion_curso' => $c->id_configuracion_curso
					]
				);
			}
		} 
		
		$this->load->view('ofertas/index', $this->data);
	}

	public function cursos()
	{
		$tarjeta = '';
		$cursos = $this->ofertas_model->listado_cursos();
		if ($cursos != NULL) {
			foreach ($cursos as $key => $curso) {
				$this->data['curso'] = $curso;
				$tarjeta .= $this->load->view('ofertas/tarjeta/tarjeta_curso', $this->data, true);
			}
			echo $tarjeta;
		} else {
			echo "No existen cursos";
		}
	}

	public function proximos_cursos($data)
	{
		$tarjeta = '';
		$cursos = $this->ofertas_model->verificar_proximos_cursos();
		if ($cursos != NULL) {
			foreach ($cursos as $key => $curso) {
				$this->data['curso'] = $curso;
				$tarjeta .= $this->load->view('ofertas/tarjeta/tarjeta_curso_proximo', $this->data, true);
			}
			echo $tarjeta;
		} else {
			echo "No existen cursos próximos";
		}
	}

	public function cursos_proximos()
	{
		$this->data['proximo_curso'] = $this->ofertas_model->verificar_proximos_cursos(); 
		$card_proximo = $this->proximos_cursos($this->data['proximo_curso']);
		echo $card_proximo;
	}
}
