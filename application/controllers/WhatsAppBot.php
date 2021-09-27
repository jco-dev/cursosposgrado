<?php
class whatsAppBot extends CI_Controller
{
    //specify instance URL and token


    public function __construct()
    {
        define('CHAT_TOKEN', '8r2o4yixy382dxu6');
        define('CHAT_URL', 'https://api.chat-api.com/instance341775/');
    }

    public function sendMessage($to = '59178917623', $msg = "hola desde chat api")
    {
        $data = [
            'phone' => $to,
            'body' => $msg
        ];

        $json = json_encode($data);

        $url = CHAT_URL . 'sendMessage?token=' . CHAT_TOKEN;

        $options = stream_context_create(
            [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => $json
                ]
            ]
        );

        $result = file_get_contents($url, false, $options);
        var_dump($result);

        if ($result) return json_decode($result);
        else {
            var_dump(getallheaders());
        }

        return false;
    }
}
