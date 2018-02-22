<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact_Site extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $tel;
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $tel, $msg)
    {
        $this->name = $name;
        $this->email = $email;
        $this->tel= $tel;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('contato@beconnect.com.br')
            ->subject('Contato pelo Formulário do site')
            ->view("emails.contact_site");
    }
}
