<?php defined('BASEPATH') or exit('No direct script access allowed');

class Participantes extends PSG_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('participantes_model');
    }

    public function index()
    {
		$this->data['total_user'] = $this->participantes_model->total_user();
		$this->data['total_participantes'] = $this->participantes_model->total_participantes();
		$this->data['user'] = $this->participantes_model->lista_user(TRUE);
		$this->data['participantes'] = $this->participantes_model->lista_participantes(TRUE);
        $this->templater->view('participantes/index', $this->data);
    }

	public function insertar()
	{
		$user = $this->participantes_model->lista_user(current($this->input->post()));
		if (empty($user['code'])) {
			$id = $this->participantes_model->insertar_curso(array('nombre_curso' => $user['fullname'], 'nombre_corto' => $user['shortname'], 'imagen_certificado' => $user['id'], 'id_moodle' => $user['id']));
			if (empty($id['code'])) {
				$this->session->set_flashdata("success", "Registro insertado correctamente. [" . $id . "]");
			} else {
				$this->session->set_flashdata($id['code'], $id['message']);
			}
		} else {
			$this->session->set_flashdata($user['code'], $user['message']);
		}
		redirect(base_url('participantes'));
	}

	public function vincular()
	{
		if ($this->input->post('id_user') && $this->input->post('id_participantes')) {
			$id = $this->participantes_model->vincular_curso($this->input->post('id_participantes'), $this->input->post('id_user'));
			if (empty($id['code'])) {
				$this->session->set_flashdata("success", "Registro vinculado correctamente. [" . $id . "]");
			} else {
				$this->session->set_flashdata($id['code'], $id['message']);
			}
		} else {
			$this->session->set_flashdata("warning", "No se han enviado datos.");
		}
		redirect(base_url('participantes'));
	}

	public function desvincular()
	{
		if ($this->input->post()) {
			$id = $this->participantes_model->desvincular_curso(current($this->input->post()));
			if (empty($id['code'])) {
				$this->session->set_flashdata("success", "Registro desvinculado correctamente. [" . $id . "]");
			} else {
				$this->session->set_flashdata($id['code'], $id['message']);
			}
		} else {
			$this->session->set_flashdata("warning", "No se han enviado datos.");
		}
		redirect(base_url('participantes'));
	}
}
