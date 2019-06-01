<?php

namespace App\Jobs;

use App\Services\MessageServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Teste implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = new MessageServices();

        $data['person_id'] = '1000';

        $data['number'] = '5515997454531';//'5511993105830';

        $data['event_name'] = 'Indústria 4.0 (Noturno)';

        $data['person_name'] = 'Luiz Fernando';

        $data['text'] = 'Parabéns '.$data['person_name'] .'. Você foi inscrito pelo BeConnect no evento '. $data['event_name']. ' que acontecerá em 05/06/2019. Lembre-se de apresentar o QR code acima para se identificar em sua entrada. Bom evento!!';

        sleep(3);

        $message->sendWhatsApp($data);
    }
}
