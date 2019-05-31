<?php

namespace App\Services;

use GuzzleHttp\Client;


class MessageServices
{

    private $client, $base_uri, $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->base_uri = 'http://api.gobot.digital/master/api/';
        $this->token = '0exreoz92yyy654e';
    }

    /*
     * Send QR code via WhatsApp
     */
    public function send_QR_WP($data)
    {

        $response = $this->client->request('POST', $this->base_uri . 'sendFile', [

            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'token'      => $this->token
            ],
            'form_params' => [
                'phone' => $data['number'],
                'body' => 'https://beconnect.com.br/qrcodes/'. $data['person_id'] . '.png',
                'filename' => $data['person_id'] . '.png',
                'caption' => $data['text']
            ]
        ]);

        return $response->getStatusCode();
    }

    /*
     * Send WhatsApp message
     */
    public function sendWhatsApp($data)
    {

        $response = $this->client->request('POST', $this->base_uri . 'sendMessage', [

            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'token'      => $this->token
            ],
            'form_params' => [
                'phone' => $data['number'],
                'body' => $data['text'],
            ]
        ]);

        return $response->getStatusCode();
    }
}
