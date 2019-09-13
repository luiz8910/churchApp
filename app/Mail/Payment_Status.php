<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Payment_Status extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    public $url_img;
    public $android_url;
    public $apple_url;
    public $p1;
    public $p2;
    public $subject;
    public $person;
    public $event_id;
    public $qrCode;
    public $li_0;
    public $li_1;
    public $li_2;
    public $li_3;
    public $li_4;
    public $li_5;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $url_img, $p1, $p2, $subject, $person, $event_id, $qrCode = null,
                                $li_0 = null, $li_1 = null, $li_2 = null, $li_3 = null, $li_4 = null, $li_5 = null,
                                $android_url = null, $apple_url = null)
    {

        $this->url = $url;
        $this->url_img = 'https://migs.med.br/2019/wp-content/uploads/2019/03/MIGS2019_curva_OK.png';
        $this->apple_url = $apple_url ? $apple_url : 'https://itunes.apple.com/app/id1430220715';
        $this->android_url = $android_url ? $android_url : 'https://play.google.com/store/apps/details?id=com.br.beconnect';
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->subject = $subject;
        $this->person = $person;
        $this->event_id = $event_id;
        $this->qrCode = $qrCode;
        $this->li_0 = $li_0;
        $this->li_1 = $li_1;
        $this->li_2 = $li_2;
        $this->li_3 = $li_3;
        $this->li_4 = $li_4;
        $this->li_5 = $li_5;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this
            ->from('pagamentos@beconnect.com.br')
            ->subject($this->subject)
            ->view("emails.payment");
    }
}
