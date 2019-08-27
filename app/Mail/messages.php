<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class messages extends Mailable
{
    use Queueable, SerializesModels;

    public $person;

    public $url;

    public $apple_url;

    public $android_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($person, $url)
    {
        $this->person = $person;
        $this->url = $url;
        $this->apple_url = 'https://itunes.apple.com/app/id1430220715';
        $this->android_url = 'https://play.google.com/store/apps/details?id=com.br.beconnect';

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = "Palestra Miguel Falabella adiada";

        return $this
            ->from('contato@beconnect.com.br')
            ->subject($text)
            ->view("emails.message");
    }
}
