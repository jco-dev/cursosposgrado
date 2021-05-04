<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('autentificado')) {
	function autentificado()
	{
		$CI = &get_instance();
		$id = $CI->encryption->decrypt($CI->session->userdata('id', TRUE));
		$usuario = $CI->login_model->verificar_usuario($id);
		return (empty($usuario['code']) ? $usuario : FALSE);
	}
}
if (!function_exists('fecha_literal')) {
	function fecha_literal($fecha, $formato = 1)
	{
		$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
		$meses = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$infofecha = getdate(strtotime($fecha));
		if (empty($fecha)) {
			return ('');
		} else {
			switch ($formato) {
				case 1:
					return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'];
					break;
				case 2:
					return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'] . ' [Hrs. ' . ($infofecha['hours'] < 10 ? '0' : '') . $infofecha['hours'] . ':' . ($infofecha['minutes'] < 10 ? '0' : '') . $infofecha['minutes'] . ']';
					break;
				case 11:
					return $dias[$infofecha['wday']] . ', ' . ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'];
					break;
				case 12:
					return $dias[$infofecha['wday']] . ', ' . ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'] . ' [Hrs. ' . ($infofecha['hours'] < 10 ? '0' : '') . $infofecha['hours'] . ':' . ($infofecha['minutes'] < 10 ? '0' : '') . $infofecha['minutes'] . ']';
					break;
				case 21:
					return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . '/' . substr(strtolower($meses[$infofecha['mon']]), 0, 3);
					break;
				default:
					return date('Y-m-d H:i:s', strtotime($fecha));
					break;
			}
		}
	}
}
