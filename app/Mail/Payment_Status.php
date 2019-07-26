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
    public $li;
    public $event_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $url_img, $p1, $p2, $subject, $person, $event_id, $li = null,
                                $android_url = null, $apple_url = null)
    {

        $this->url = $url;
        $this->url_img = $url_img;
        $this->apple_url = $apple_url ? $apple_url : 'https://itunes.apple.com/app/id1430220715';
        $this->android_url = $android_url ? $android_url : 'https://play.google.com/store/apps/details?id=com.br.beconnect';
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->subject = $subject;
        $this->person = $person;
        $this->li = $li;
        $this->event_id = $event_id;
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
