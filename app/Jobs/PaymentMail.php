<?php

namespace App\Jobs;

use App\Mail\Payment_Status;
use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
use App\Services\EventServices;
use App\Services\qrServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class PaymentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $li_0;
    public $url;
    public $url_img;
    public $subject;
    public $p1;
    public $p2;
    public $x;
    public $event_id;
    public $li_1;
    public $li_2;
    public $li_3;
    public $li_4;
    public $li_5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($li_0, $li_1, $li_2, $li_3, $li_4, $li_5, $url, $url_img, $subject, $p1, $p2, $x, $event_id)
    {
        //
        $this->li_0 = $li_0;
        $this->li_1 = $li_1;
        $this->li_2 = $li_2;
        $this->li_3 = $li_3;
        $this->li_4 = $li_4;
        $this->li_5 = $li_5;
        $this->url = $url;
        $this->url_img = $url_img;
        $this->subject = $subject;
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->x = $x;
        $this->event_id = $event_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PersonRepository $personRepository, EventServices $eventServices, qrServices $qrServices,
                           PaymentRepository $paymentRepository, EventRepository $eventRepository)
    {
        $payment = $paymentRepository->findByField('metaId', $this->x['metaId'])->first();

        if($payment)
        {
            if($payment->status == 4)
            {
                try{
                    $person = $personRepository->findByField('id', $this->x['person_id'])->first();

                    $user = $person->user;

                    $event = $eventRepository->findByField('id', $this->event_id)->first();

                    if($event)
                    {
                        Mail::to($user)->send(new Payment_Status($this->url, $this->url_img,
                            $this->p1, $this->p2, $this->subject, $person, $this->event_id));

                        $qrServices->generateQrCode($person->id);

                        $eventServices->subEvent($this->event_id, $person->id);

                        $this->subject = 'Seu acesso ao evento ' . $event->name;

                        $this->p1 = 'No dia '. date_format(date_create($event->eventDate), 'd/m').', exiba o 
                        QrCode abaixo para ter acesso ao evento. Você pode ter acesso também pelo app 
                        Beconnect (link no final)';

                        $qrCode = 'https://beconnect.com.br/qrcodes/' . $person->id . '.png';

                        Mail::to($user)->send(new Payment_Status($this->url, $this->url_img,
                            $this->p1, $this->p2, $this->subject, $person, $this->event_id, $qrCode,
                            $this->li_0, $this->li_1, $this->li_2, $this->li_3, $this->li_4, $this->li_5));

                        \DB::commit();
                    }

                }catch (\Exception $e)
                {
                    \DB::rollBack();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'Back-end';
                    $bug->location = 'line ' . $e->getLine() . ' handle() PaymentMail.php';
                    $bug->model = 'Queue';
                    $bug->status = 'Pendente';

                    $bug->save();
                }

            }
        }

    }
}
