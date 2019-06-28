<?php

namespace App\Services;

use App\Mail\Certificate;
use App\Mail\welcome;
use App\Mail\welcome_sub;
use App\Models\Event;
use App\Models\EventSubscribedList;
use App\Models\Person;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use App\Traits\EmailTrait;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class MessageServices
{
    use EmailTrait;
    private $client, $base_uri, $token;


    /**
     * MessageServices constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->base_uri = 'http://api.gobot.digital/master/api/';
        $this->token = "bis6egzn595rog7p";//env('APP_WP_TOKEN');
    }

    /*
     * Send QR code via WhatsApp
     */
    public function send_QR_WP($event_id)
    {

        $list_model = new EventSubscribedList();

        $list = $list_model->where(['event_id' => $event_id])->get();

        $data = [];

        $i = 0;

        if(count($list) > 0)
        {
            $event_model = new Event();

            $event = $event_model->find($event_id);

            if($event)
            {
                foreach ($list as $item)
                {
                    $person_model = new Person();

                    $person = $person_model->findOrFail($item->person_id);

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

                        $i++;

                        if($i == 10)
                        {
                            $i = 0;

                            sleep(30);
                        }

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

    public function send_QR_Teste($data)
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
                'caption' => $data['text'] . ' Enviado ás ' . date_format(Carbon::now(), 'H:i')
            ]
        ]);

        DB::table('msg_jobs')
            ->insert([
                'person_id' => $data['person_id'],
                'channel' => 'whatsapp',
                'responseCode' => $response->getStatusCode(),
                'responseText' => $response->getReasonPhrase(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return true;
    }

    public function welcome($user, $password)
    {
        $url = $this->getUrl();

        Mail::to($user)
            ->send(new welcome(
                $user, $url, $password
            ));

        return true;
    }

    public function welcome_sub($user, $event, $qrCode)
    {
        $url = $this->getUrl();

        Mail::to($user)
            ->send(new welcome_sub(
                $user, $url, $event, $qrCode
            ));

        return true;
    }

    public function sendCertificate($user, $person, $event)
    {
        $url = $this->getUrl();

        Mail::to($user)
            ->send(new Certificate($person, $url, $event));
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
