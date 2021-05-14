<?php defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function enviar_correos($estudiantes)
    {
        var_dump($estudiantes);
    }
}
