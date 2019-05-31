<?php

namespace App\Services;

use App\Models\EventSubscribedList;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryEloquent;
use App\Repositories\PersonRepository;
use GuzzleHttp\Client;


class MessageServices
{

    private $client, $base_uri, $token;
    /**
     * @var EventSubscribedList
     */
    private $listRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(EventSubscribedList $listRepository, EventRepository $eventRepository, PersonRepository $personRepository)
    {
        $this->client = new Client();
        $this->base_uri = 'http://api.gobot.digital/master/api/';
        $this->token = '0exreoz92yyy654e';
        $this->listRepository = $listRepository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
    }

    /*
     * Send QR code via WhatsApp
     */
    public function send_QR_WP($event_id)
    {


        $list = $this->listRepository->findByField('event_id', $event_id);

        $data = [];

        $i = 0;

        if(count($list) > 0)
        {
            $event = $this->eventRepository->findByField('id', $event_id)->first();

            if($event)
            {
                foreach ($list as $item)
                {
                    $person = $this->personRepository->findByField('id', $item->person_id)->first();

                    if($person)
                    {
                        if($person->cel == "" && $person->tel == "")
                        {
                            return false;
                        }

                        if($person->cel == "")
                        {
                            $data['number'] = $person->tel;
                        }
                        else{
                            $data['number'] = $person->cel;
                        }

                        $data['number'] = $this->formatPhoneNumber($data['number']);

                        $data['person_name'] = $person->name;

                        $data['person_id'] = $person->id;

                        $data['event_name'] = $event->name;

                        $data['event_date'] = date_format(date_create($event->eventDate . $event->startTime), 'd/m/Y H:i');

                        $data['text'] = 'Parabéns '. $data['person_name'] .'. Você foi inscrito pelo BeConnect no evento '. $data['event_name']. ' que acontecerá em '.$data['event_date'].' Lembre-se de apresentar o QR code acima para se identificar em sua entrada. Bom evento!!';

                        dd($data);
                    }
                    else{

                        return false;
                    }
                }
            }


        }

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

    public function formatPhoneNumber($number)
    {
        $number = str_replace('(', '', $number);
        $number = str_replace(')', '', $number);
        $number = str_replace('-', '', $number);
        $number = str_replace(' ', '', $number);
        $number = '55' . $number;

        return $number;
    }
}
