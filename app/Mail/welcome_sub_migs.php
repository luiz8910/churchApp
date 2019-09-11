<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class welcome_sub_migs extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    public $user;
    /**
     * @var
     */
    public $url;
    /**
     * @var
     */
    public $event;

    public $apple_url;

    public $android_url;

    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $url, $event, $password)
    {
        $this->user = $user;
        $this->url = $url;
        $this->event = $event;
        $this->apple_url = 'https://itunes.apple.com/app/id1475992800';
        $this->android_url = 'https://play.google.com/store/apps/details?id=com.br.beconnect.migs';
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $text = 'Bem vindo ao MIGS 2019';

        return $this
            ->from('contato@beconnect.com.br')
            ->subject($text)
            ->view("emails.welcome-sub-migs");
    }
}
