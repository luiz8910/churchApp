<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class welcome_sub extends Mailable
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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $url, $event)
    {
        $this->user = $user;
        $this->url = $url;
        $this->event = $event;
        $this->apple_url = 'https://itunes.apple.com/app/id1430220715';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = "Bem vindo ao Beconnect";

        return $this
            ->from('admin@beconnect.com.br')
            ->subject($text)
            ->view("emails.welcome-sub");
    }
}
