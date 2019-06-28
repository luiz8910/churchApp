<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Certificate extends Mailable
{
    use Queueable, SerializesModels;
    public $apple_url;
    public $android_url;
    public $person;
    public $url;
    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($person, $url, $event)
    {
        $this->person = $person;
        $this->url = $url;
        $this->apple_url = 'https://itunes.apple.com/app/id1430220715';
        $this->android_url = 'https://play.google.com/store/apps/details?id=com.br.beconnect';
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = "Seu Certificado Está Pronto";

        return $this
            ->from('contato@beconnect.com.br')
            ->subject($text)
            ->view("emails.certificate");
    }
}
