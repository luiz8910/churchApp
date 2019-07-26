<?php

namespace App\Jobs;

use App\Mail\Payment_Status;
use App\Models\Bug;
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
    public $li;
    public $url;
    public $url_img;
    public $subject;
    public $p1;
    public $p2;
    public $x;
    public $event_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($li, $url, $url_img, $subject, $p1, $p2, $x, $event_id)
    {
        //
        $this->li = $li;
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
                           PaymentRepository $paymentRepository)
    {
        $payment = $paymentRepository->findByField('metaId', $this->x['metaId'])->first();

        if($payment)
        {
            if($payment->status == 4)
            {
                try{
                    $person = $personRepository->findByField('id', $this->x['person_id'])->first();

                    $user = $person->user;

                    Mail::to($user)->send(new Payment_Status($this->url, $this->url_img,
                        $this->p1, $this->p2, $this->subject, $person, $this->li));

                    $qrServices->generateQrCode($person->id);

                    $eventServices->subEvent($this->event_id, $person->id);

                    $this->subject = 'Seu acesso ao evento MIGS 2019';

                    $this->p1 = 'Nos dias 12, 13 e 14 de setembro, exiba o QrCode abaixo para ter acesso ao evento. 
                Você pode ter acesso também pelo app MIGS (link no final)';

                    Mail::to($user)->send(new Payment_Status($this->url, $this->url_img,
                        $this->p1, $this->p2, $this->subject, $person, $this->event_id));

                    \DB::commit();

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
