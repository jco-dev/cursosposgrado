<?php defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{
    var $APIurl = ' https://api.chat-api.com/instance341775/';
    var $token = '8r2o4yixy382dxu6';
    public function __construct()
    {
        parent::__construct();
        $json = file_get_contents('php://input');
        $decoded = json_decode($json, true);
    }

    public function enviar_correos($estudiantes)
    {
        var_dump($estudiantes);
    }
    public function enviar_whatsapp($estudiante)
    {
    }
    public function sendMessage($chatId, $text)
    {
        $data = array('chatId' => $chatId, 'body' => $text);
        $this->sendRequest('message', $data);
    }
}
