<?php

namespace App\Jobs;

use App\Mail\Payment_Status;
use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UrlRepository;
use App\Services\EventServices;
use App\Services\qrServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class Payment_Mail_Url implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $li_0;
    public $url;
    public $url_img;
    public $subject;
    public $p1;
    public $p2;
    public $x;
    public $url_id;
    public $li_1;
    public $li_2;
    public $li_3;
    public $li_4;
    public $li_5;
    public $li_6;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($li_0, $li_1, $li_2, $li_3, $li_4, $li_5, $url, $url_img, $subject, $p1, $p2, $x, $url_id, $li_6 = null)
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
        $this->url_id = $url_id;
        $this->li_6 = $li_6;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PersonRepository $personRepository, EventServices $eventServices, qrServices $qrServices,
                           PaymentRepository $paymentRepository, EventRepository $eventRepository, UrlRepository $urlRepository)
    {
        $payment = $paymentRepository->findByField('metaId', $this->x['metaId'])->first();

        if($payment)
        {
            if($payment->status == 4)
            {
                try{
                    $person = $personRepository->findByField('id', $this->x['person_id'])->first();

                    $user = $person->user;

                    $url = $urlRepository->findByField('id', $this->url_id)->first();

                    if($url)
                    {
                        /*Mail::to($user)->send(new Payment_Status($this->url, $this->url_img,
                            $this->p1, $this->p2, $this->subject, $person, $this->event_id));*/

                        $eventServices->subEvent($this->url_id, $person->id);

                        //$qrCode = 'https://beconnect.com.br/qrcodes/' . $person->id . '.png';

                        if($this->li_6)
                        {
                            $this->subject = 'Seu pagamento foi aprovado';

                            $this->p1 = 'Você adquiriu os cursos: ' . implode(' - ', $this->li_6);

                            Mail::to($user)->send(new Payment_Status($this->url, $this->url_img,
                                $this->p1, $this->p2, $this->subject, $person, $this->url_id, $url,
                                $this->li_0, $this->li_1, $this->li_2, $this->li_3, $this->li_4, $this->li_5));
                        }


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
